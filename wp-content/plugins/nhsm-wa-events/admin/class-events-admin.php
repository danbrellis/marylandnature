<?php
/**
 * Created by PhpStorm.
 * User: danbr
 * Date: 6/18/2019
 * Time: 10:23 AM
 */

namespace NHSM\Events\Admin;

use WildApricot\WaApiClient;

class Events_Admin {

    private $account_url = null;
    private $waApiClient;

    //https://app.swaggerhub.com/apis-docs/WildApricot/wild-apricot_public_api/2.1.0#/Events

    public function __construct() {
        $this->waApiClient = WaApiClient::getInstance();
        $this->waApiClient->initTokenByApiKey('sfnzve8mhib8lig1euufu51enp1nyz '); //@todo make dynamic

        $this->setAccountUrl($this->waApiClient);

        $r = $this->waApiClient->makeRequest($this->account_url . '/events/3466080', 'GET');
        //echo '<pre>'; var_dump($r); echo '</pre>'; exit();

        //hook into events save action
        add_action('wp_insert_post', array($this, 'event_saved'), 100, 3); //@todo pull post_type from settings

        add_filter( 'removable_query_args', array($this, 'add_removable_arg') );

        add_action( 'admin_head', array($this, 'admin_head') );
    }

    function admin_head(){
        $screen = get_current_screen();
        if($screen->base === 'post' && $screen->post_type === 'event'){
            add_action( 'admin_notices', array($this, 'admin_notices') );
            add_action( 'admin_notices', array($this, 'admin_notices__warning') );
        }
    }

    function add_removable_arg($args){
        array_push($args, 'WA_EVENT_MSG');
        return $args;
    }

    /**
     * @param WaApiClient $waApiClient
     * @return string
     */
    public function setAccountUrl($waApiClient){
        $account = $this->getAccountDetails($waApiClient);
        $account_url = $account['Url'];
        $this->account_url = $account_url;
        return $account_url;
    }

    /**
     * @param WaApiClient $waApiClient
     * @return string
     */
    function getAccountDetails($waApiClient) {
        $url = 'https://api.wildapricot.org/v2/Accounts/';
        $response = $waApiClient->makeRequest($url);
        return $response['data'][0]; // usually you have access to one account
    }

    /**
     * @param int $event_id
     * @return string
     */
    public function getEventUrl($event_id = 0){
        if($this->account_url === null){
            $this->setAccountUrl($this->waApiClient);
        }
        if($event_id) return $this->account_url . '/events/' . $event_id;
        else return $this->account_url . '/events';
    }

    /**
     * @param array $data
     * @return array
     */
    public function createEvent($data = []){
        $event_url = $this->getEventUrl();
        $response = $this->waApiClient->makeRequest($event_url, 'POST', $data);
        return $response;
    }

    /**
     * @param array $data
     * @param int $event_id
     * @return array
     */
    public function updateEvent($data = [], $event_id){
        $event_url = $this->getEventUrl($event_id);
        $response = $this->waApiClient->makeRequest($event_url, 'PUT', $data);
        return $response;
    }

    /**
     * @param int $event_id
     * @return array
     */
    public function getEvent($event_id){
        $event_url = $this->getEventUrl($event_id);
        $response = $this->waApiClient->makeRequest($event_url, 'GET');
        return $response;
    }

    /**
     * @param int $post_id
     * @param \WP_Post $post
     * @param boolean $update
     * @var \WP_Term $location_data
     * @var \WP_Term $tag
     * @return int
     */
    public function event_saved($post_id, $post, $update) {
        if(!in_array(get_post_type($post), apply_filters( 'em_event_post_type', array( 'event' ) ) ) ) return $post_id;

        if($post->post_status === 'publish' && $update){
            //check if WA event id exists in the meta
            $wa_event_id = get_post_meta($post_id, '_wa_event_id', true);

            $reg_enabled = get_post_meta( $post->ID, '_nhsm_wa_events_registration_enabled', true );
            $reg_limit = get_post_meta( $post->ID, '_nhsm_wa_events_registration_limit', true );
            $reg_confirm_extra_info = get_post_meta( $post->ID, '_nhsm_wa_events_reg_confirm_extra_info', true );
            $reg_msg = get_post_meta( $post->ID, '_nhsm_wa_events_registration_msg', true );
            $payment_instr = get_post_meta( $post->ID, '_nhsm_wa_events_payment_instr', true );

            $content = $post->post_content;
            //remove_filter( 'the_content', 'wpautop' );
            $content = apply_filters('the_content', $content);
            //add_filter( 'the_content', 'wpautop' );
            $content = str_replace(']]>', ']]&gt;', $content);

            $data = [
                "Name" => get_the_title($post),
                "StartTimeSpecified" => false,
                "EndTimeSpecified" => false,
                "RegistrationEnabled" => boolval($reg_enabled),
                "Details" => [
                    "DescriptionHtml" => $content, //@todo add some photos?
                    "PaymentInstructions" => htmlspecialchars($payment_instr),
                    "TimeZone" => [
                        "ZoneId" => "Eastern Standard Time",
                        "Name" => "(UTC-05:00) Eastern Time (US & Canada)",
                        "UtcOffset" => -300
                    ],
                    "AccessControl" => [
                        "AccessLevel" => "Public",
                        "AvailableForAnyLevel" => false,
                        "AvailableForLevels" => [],
                        "AvailableForAnyGroup" => false,
                        "AvailableForGroups" => []
                    ],
                    "GuestRegistrationSettings" => [
                        "Enabled" => true,
                        "CreateContactMode" => "CreateContactForGuestsWithEmail"
                    ],
                    "Organizer" => null,
                    "PaymentMethod" => "OnlineAndOffline",
                    "RegistrationConfirmationExtraInfo" => htmlspecialchars($reg_confirm_extra_info),
                    "RegistrationMessage" => htmlspecialchars($reg_msg),
                    "SendEmailCopy" => false,
                    "IsWaitlistEnabled" => false,
                    "MultipleRegistrationAllowed" => true,
                    "AttendeesDisplaySettings" => [
                        "VisibleTo" => "Public",
                        "ShowPendingAttendees" => true
                    ]
                ],
                "RegistrationsLimit" => $reg_limit === "" ? null : intval($reg_limit)
            ];

            //Event Date
            $allday = get_post_meta($post_id, '_event_all_day', true);
            $start = get_post_meta($post_id, '_event_start_date', true);
            if($start){
                $data['StartDate'] = date('c', strtotime($start));
                $data['StartTimeSpecified'] = !boolval($allday);
            }
            $end = get_post_meta($post_id, '_event_end_date', true);
            if($end){
                $data['EndDate'] = date('c', strtotime($end));
                $data['EndTimeSpecified'] = !boolval($allday);
            }

            //Location
            $locations = [];
            $locations_data = em_get_locations_for($post_id);

            foreach($locations_data as $location_data){
                $locations[] = $location_data->name;
            }
            $data['Location'] = implode(', ', $locations);

            //Tags
            $post_tags = get_the_tags();
            $tags = [];
            foreach($post_tags as $tag) {
                $tags[] = $tag->name;
            }
            if(!empty($tags)) $data['Tags'] = $tags;

            //Occurrences
            $occurrences = get_post_meta($post_id, '_event_occurrence_date', false);
            $os = [];
            foreach($occurrences as $occurrence){
                $dates = explode('|', $occurrence);
                $os[strtotime($dates[0])] = $occurrence;
            }
            ksort($os); $i = 1;
            foreach($os as $start => $o) {
                $dates = explode('|', $o);
                $start_time = substr($dates[0], -8); //ie 00:00:00
                $end_time = substr($dates[1], -8); //ie 00:00:00
                $sessions[] = [
                    "Title" => sprintf("%s (%d of %d)", get_the_title($post), $i, count($os)),
                    "StartDate" => date('c', $start),
                    "StartTimeSpecified" => $start_time !== '00:00:00',
                    "EndDate" => date('c', strtotime($dates[1])),
                    "EndTimeSpecified" => $end_time !== '00:00:00'
                ];
                $i++;
            }
            if(!empty($sessions)) $data['Sessions'] = $sessions;


            //echo '<pre>'; var_dump($data); echo '</pre>'; exit();

            if($wa_event_id){ //update
                $data["Id"] = $wa_event_id;
                $response = $this->updateEvent($data, $wa_event_id);
                if($response['code'] === 200) {
                    add_filter('redirect_post_location', array($this, 'add_update_success_query_var'), 99);
                }
                else {
                    add_filter('redirect_post_location', array($this, 'add_update_error_query_var'), 99);
                    $this->send_error($response, $post, $wa_event_id);
                }
            }
            else { //add new
                $response = $this->createEvent($data);
                //echo '<pre>'; var_dump($response); echo '</pre>';

                if($response['code'] === 200){
                    $event_id = $response['data'];
                    update_post_meta($post_id, '_wa_event_id', $event_id);
                    add_filter( 'redirect_post_location', array( $this, 'add_create_success_query_var' ), 99 );
                }
                else {
                    add_filter( 'redirect_post_location', array( $this, 'add_create_error_query_var' ), 99 );
                    $this->send_error($response, $post);
                }

                //echo '<pre>'; var_dump($event_id); echo '</pre>'; exit();
            }
        }
    }

    /**
     * @param array $response
     * @param \WP_Post $post
     * @param int $wa_event_id
     */
    public function send_error($response, $post, $wa_event_id = 0){
        $to = get_option('admin_email', 'danbrellis@gmail.com');
        $message = "After saving an event in Wordpress, an error occurred while trying to " . ($wa_event_id ? "update" : "create") . " the event in WildApricot.\n";
        $message .= "Wordpress Post ID: <a href='".get_edit_post_link($post->ID)."'>" . $post->ID . "</a>\n";
        if($wa_event_id) $message .= "WildApricot Event ID: " . $wa_event_id . "\n";
        $message .= "Error code: " . $response['code'] . "\n\n";
        ob_start();
        var_dump($response['data']);
        $error = ob_get_clean();

        $message .= "<pre>" . $error . "</pre>";

        $headers = [
            "Content-Type: text/html; charset=ISO-8859-1"
        ];
        if(defined("WP_DEBUG") && WP_DEBUG === true){
            echo $message; exit();
        }
        wp_mail( $to, "NHSM Events/WildApricot Error", $message, $headers );
    }

    /**
     * @param string $location
     * @return string
     */
    public function add_update_success_query_var($location){
        remove_filter( 'redirect_post_location', array( $this, 'add_update_success_query_var' ), 99 );
        return add_query_arg( array( 'WA_EVENT_MSG' => 'update__success' ), $location );
    }

    /**
     * @param string $location
     * @return string
     */
    public function add_create_success_query_var($location){
        remove_filter( 'redirect_post_location', array( $this, 'add_create_success_query_var' ), 99 );
        return add_query_arg( array( 'WA_EVENT_MSG' => 'create__success' ), $location );
    }

    /**
     * @param string $location
     * @return string
     */
    public function add_update_error_query_var($location){
        remove_filter( 'redirect_post_location', array( $this, 'add_update_error_query_var' ), 99 );
        return add_query_arg( array( 'WA_EVENT_MSG' => 'update__error' ), $location );
    }

    /**
     * @param string $location
     * @return string
     */
    public function add_create_error_query_var($location){
        remove_filter( 'redirect_post_location', array( $this, 'add_create_error_query_var' ), 99 );
        return add_query_arg( array( 'WA_EVENT_MSG' => 'create__error' ), $location );
    }

    /**
     * @var \WP_Post $post
     * @var int $wa_event_id
     */
    public function admin_notices() {
        global $post;
        $wa_event_id = get_post_meta($post->ID, '_wa_event_id', true);
        if ( isset( $_GET['WA_EVENT_MSG'] ) ):
            if($_GET['WA_EVENT_MSG'] === 'create__success' && $wa_event_id): ?>
            <div class="notice notice-success is-dismissible">
                <p>Event Successfully added to WildApricot with ID: <?php echo $wa_event_id; ?>.</p>
            </div>
            <?php endif;
            if($_GET['WA_EVENT_MSG'] === 'update__success' && $wa_event_id): ?>
                <div class="notice notice-success is-dismissible">
                    <p>Event successfully updated in WildApricot (ID: <?php echo $wa_event_id; ?>).</p>
                </div>
            <?php endif;

            if($_GET['WA_EVENT_MSG'] === 'create__error'): ?>
                <div class="notice notice-error is-dismissible">
                    <p>Unable to save event in WildApricot. Please try to save again through Wordpress, otherwise, contact the site admin.</p>
                </div>
            <?php endif;
            if($_GET['WA_EVENT_MSG'] === 'update__error'): ?>
                <div class="notice notice-error is-dismissible">
                    <p>Unable to update event in WildApricot. Please try to update again through Wordpress, otherwise, contact the site admin.</p>
                </div>
            <?php endif;
        endif;
        if(!$wa_event_id): ?>
            <div class="notice notice-error is-dismissible">
                <p>Unable to find reference to event in WildApricot. Try to save it again through Wordpress, otherwise, contact the site admin.</p>
            </div>
        <?php endif;
    }

    /**
     * @var \WP_Post $post
     * @var int $wa_event_id
     */
    public function admin_notices__warning() {
        global $post;
        //get event
        $wa_event_id = get_post_meta($post->ID, '_wa_event_id', true);
        if(!$wa_event_id) return;

        $response = $this->getEvent($wa_event_id);

        //if no reg types, show a message
        if($response['code'] === 200 && $post->post_status === 'publish' && empty($response['data']['Details']['RegistrationTypes'])): ?>
            <div class="notice notice-warning">
                <p><strong>This event has no registration types saved in WildApricot.</strong></p>
                <p>Registration is disabled until at least one registration type is created. Go to the <a href="https://marylandnature.wildapricot.org/admin/events/details/?DetailsDisplayMode=View&eventId=<?php echo $wa_event_id; ?>&selTab=3" target="_blank" title="Edit event in WildApricot.">WildApricot event dashboard</a> to create a registration type.</p>
            </div>
        <?php endif;
    }

}