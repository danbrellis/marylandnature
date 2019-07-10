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

        //$r = $this->waApiClient->makeRequest($this->account_url . '/events/3470106', 'GET');
        //echo '<pre>'; var_dump($rt); echo '</pre>'; exit();

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
        $response = false;
        try{
            $response = $waApiClient->makeRequest($url);
        }
        catch(\Exception $e){
            $this->send_error("getAccountDetails\n" . $e->getMessage());
        }
        return $response[0]; // usually you have access to one account
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
     * @param \WP_Post $post
     * @return array
     */
    public function createEvent($data = [], $post){
        $event_url = $this->getEventUrl();
        $response = false;
        try{
            $response = $this->waApiClient->makeRequest($event_url, 'POST', $data);
        }
        catch(\Exception $e){
            $this->send_error("createEvent\n" . $e->getMessage(),$data, $post);
        }
        return $response;
    }

    /**
     * @param array $data
     * @param \WP_Post $post
     * @param int $event_id
     * @return array
     */
    public function updateEvent($data = [], $post, $event_id){
        $event_url = $this->getEventUrl($event_id);
        $response = false;
        try{
            $response = $this->waApiClient->makeRequest($event_url, 'PUT', $data);
        }
        catch(\Exception $e){
            $this->send_error("updateEvent\n" . $e->getMessage(), $data, $post, $event_id);
        }
        return $response;
    }

    /**
     * @param int $event_id
     * @param \WP_Post $post
     * @return array
     */
    public function getEvent($event_id, $post){
        $event_url = $this->getEventUrl($event_id);
        $response = false;
        try{
            $response = $this->waApiClient->makeRequest($event_url, 'GET');
        }
        catch(\Exception $e){
            $this->send_error("getEvent\n" . $e->getMessage(), [], $post, $event_id);
        }
        return $response;
    }

    /**
     * @param int $post_id
     * @param \WP_Post $post
     * @param boolean $update
     * @var \WP_Term $location_data
     * @var \WP_Term $tag
     * @throws \Exception
     * @return int
     */
    public function event_saved($post_id, $post, $update) {
        if(!in_array(get_post_type($post), apply_filters( 'em_event_post_type', array( 'event' ) ) ) ) return $post_id;

        if($post->post_status === 'publish' && $update){
            //check if WA event id exists in the meta
            $wa_event_id = get_post_meta($post_id, '_wa_event_id', true);

            $reg_enabled = get_field('enable_registration', $post_id);

            $reg_details = get_field('registration_details', $post_id);
            $reg_limit = $reg_details['registration_limit'];
            $reg_confirm_extra_info = $reg_details['registration_extra_information'];
            $reg_msg = $reg_details['registration_message'];

            $payment_instr = get_field('payment_instructions', $post_id);

            $photo = get_the_post_thumbnail($post, 'medium');
            $content = $photo . "\n\n" . $post->post_content;
            //remove_filter( 'the_content', 'wpautop' );
            $content = apply_filters('the_content', $content);
            //add_filter( 'the_content', 'wpautop' );
            $content = str_replace(']]>', ']]&gt;', $content);

            $data = [
                "Name" => get_the_title($post),
                "StartTimeSpecified" => false,
                "EndTimeSpecified" => false,
                "RegistrationEnabled" => $reg_enabled,
                "Details" => [
                    "DescriptionHtml" => $content,
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
                try{
                    $event_data = $this->updateEvent($data, $post, $wa_event_id);
                    add_filter('redirect_post_location', array($this, 'add_update_success_query_var'), 99);
                    if($reg_enabled) $this->addEventRegistrationTypes($wa_event_id, $post);

                    //clean up old reg types
                    $this->purgeRegTypes($event_data, $wa_event_id, $post);
                }
                catch(\Exception $e){
                    add_filter('redirect_post_location', array($this, 'add_update_error_query_var'), 99);
                }
            }
            else { //add new
                try{
                    $event_id = $this->createEvent($data, $post);
                    update_post_meta($post_id, '_wa_event_id', $event_id);
                    add_filter( 'redirect_post_location', array( $this, 'add_create_success_query_var' ), 99 );
                    if($reg_enabled) $this->addEventRegistrationTypes($event_id, $post);
                }
                catch(\Exception $e){
                    add_filter( 'redirect_post_location', array( $this, 'add_create_error_query_var' ), 99 );
                }
            }
        }

        return $post_id;
    }

    /**
     * @param int $wa_event_id
     * @param \WP_Post $post
     * @throws \Exception
     */
    public function addEventRegistrationTypes($wa_event_id, $post) {
        try{
            $membership_levels = $this->waApiClient->makeRequest($this->account_url . '/membershiplevels');
        }
        catch(\Exception $e){
            $this->send_error("GET membershiplevels\n" . $e->getMessage(), [], $post, $wa_event_id);
            //use hardcoded defaults
            $membership_levels = [
                [
                    'Name' => '1 - Individual',
                    'Id' => 313349
                ],
                [
                    'Name' => '2 - Family',
                    'Id' => 313508
                ],
                [
                    'Name' => '3 - Contributing',
                    'Id' => 313510
                ],
                [
                    'Name' => '4 - Sustaining',
                    'Id' => 313511
                ],
                [
                    'Name' => '5 - Life',
                    'Id' => 313512
                ],
                [
                    'Name' => '6 - Corporate',
                    'Id' => 313513
                ],
            ];
        }

        $types = get_field('registration_types', $post->ID);
        foreach($types as $index => $type){
            //check if reg type ID already exists, if so we're updating
            $wa_reg_type_id = $type['registration_type_id'];

            $base_price = $type['base_price'];
            $guest_pricing = $type['guest_pricing'];
            $guest_price = $guest_pricing === 'basePrice' ? $base_price : $type['guest_price'];
            $availability = $type['availability'];
            if($availability === "MembersOnly"){
                $membership_types = $type['membership_types'];
                $membership_levels_formatted = [];
                foreach($membership_levels as $membership_level){
                    if(in_array($membership_level['Name'], $membership_types))
                        $membership_levels_formatted[] = [
                            'Id' => $membership_level['Id']
                        ];
                }
            }
            else $membership_levels_formatted = NULL;

            $cancellation = $type['cancellation'];
            $data = [
                "EventId" => $wa_event_id,
                "Name" => $type['name'],
                "IsEnabled" => true,
                "Description" => $type['description'],
                "BasePrice" => $base_price,
                "GuestPrice" => $guest_price,
                "UseTaxScopeSettings" => false,
                "Availability" => $type['availability'],
                "RegistrationCode" => $type['registration_code'],
                "AvailableForMembershipLevels" => $membership_levels_formatted,
                "AvailableFrom" => $type['available_period']['from'] ? date('c', $type['available_period']['from']) : NULL,
                "AvailableThrough" => $type['available_period']['to'] ? date('c', $type['available_period']['to']) : NULL,
                "MaximumRegistrantsCount" => $type['registration_limit_for_type'],
                "GuestRegistrationPolicy" => $type['allow_guest_registrations'] ? $type['information_to_collect'] : "Disabled",
                "MaxGuestsCount" => $type['guest_limit'],
                "UnavailabilityPolicy" => $type['if_unavailable'],
                "CancellationBehaviour" => $cancellation,
                "CancellationDaysBeforeEvent" => $cancellation === 'AllowUpToPeriodBeforeEvent' ? $type['cancellation_cutoff'] : 0,
                "IsWaitlistEnabled" => $type['waitlist']
            ];

            try{
                if($wa_reg_type_id)
                    $this->waApiClient->makeRequest($this->account_url . '/EventRegistrationTypes/' . $wa_reg_type_id, 'PUT', $data);
                else {
                    $wa_reg_type_id = $this->waApiClient->makeRequest($this->account_url . '/EventRegistrationTypes', 'POST', $data);
                    update_post_meta($post->ID, 'registration_types_' . $index . '_registration_type_id', $wa_reg_type_id);
                }
            }
            catch(\Exception $e){
                $this->send_error("Add/Update EventRegistrationTypes\n" . $e->getMessage(), $data, $post, $wa_event_id);
            }
        }
    }

    public function purgeRegTypes($wa_event, $wa_event_id, $post){
        //get all event reg types from WA
        $wa_reg_type_ids = $reg_type_ids = [];
        foreach($wa_event['Details']['RegistrationTypes'] as $wa_reg_type){
            $wa_reg_type_ids[] = $wa_reg_type['Id'];
        }

        //get all event reg types from WP
        $reg_types = get_field('registration_types', $post->ID);
        foreach($reg_types as $reg_type){
            $reg_type_ids[] = $reg_type['registration_type_id'];
        }

        //if any exist in WA that don't have their ID associated with WP, delete them
        $defunct_wa_reg_type_ids = array_diff($wa_reg_type_ids, $reg_type_ids);
        foreach($defunct_wa_reg_type_ids as $id){
            try{
                $this->waApiClient->makeRequest($this->account_url . '/EventRegistrationTypes/' . $id, 'DELETE');
            }
            catch(\Exception $e){
                $this->send_error("DELETE EventRegistrationType\n" . $e->getMessage(), ['typeId' => $id], $post, $wa_event_id);
            }
        }
    }

    /**
     * @param string $msg
     * @param array $data
     * @param \WP_Post $post
     * @param int $wa_event_id
     */
    public function send_error($msg, $data = [], $post = null, $wa_event_id = 0){
        $to = get_option('admin_email', 'danbrellis@gmail.com');
        $message = "After saving an event in Wordpress, an error occurred while trying to " . ($wa_event_id ? "update" : "create") . " the event in WildApricot.\n";
        $message .= "Wordpress Post ID: <a href='".get_edit_post_link($post->ID)."'>" . $post->ID . "</a>\n";
        if($wa_event_id) $message .= "WildApricot Event ID: " . $wa_event_id . "\n";
        $message .= $msg;
        ob_start();
        var_dump($data);
        $data_string = ob_get_clean();
        $message .= '<pre>' . $data_string . '</pre>';
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

        try{
            $wa_event = $this->getEvent($wa_event_id, $post);
            if(empty($wa_event['Details']['RegistrationTypes'])): ?>
                <div class="notice notice-warning">
                    <p><strong>This event has no registration types saved in WildApricot.</strong></p>
                    <p>Registration is disabled until at least one registration type is created. Go to the <a href="https://marylandnature.wildapricot.org/admin/events/details/?DetailsDisplayMode=View&eventId='.$wa_event_id.'&selTab=3" target="_blank" title="Edit event in WildApricot.">WildApricot event dashboard</a> to create a registration type.</p>';
                </div>
            <?php endif;
        }
        catch (\Exception $e){ ?>
            <div class="notice notice-warning">
                <p>Error in pulling event details from WildApricot.</p>
            </div>
        <?php }
    }

}