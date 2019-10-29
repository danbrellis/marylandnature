<?php
/**
 * Created by PhpStorm.
 * User: danbr
 * Date: 6/18/2019
 * Time: 10:23 AM
 */

namespace NHSM\Events\Admin;

use WildApricot\WaApiClient;
use WP_Query;
use DateTime;
use DateTimeZone;

class Events_Admin {

    private $account_url = null;
    private $waApiClient;
    public $timezone;

    //https://app.swaggerhub.com/apis-docs/WildApricot/wild-apricot_public_api/2.1.0#/Events

    public function __construct() {
        $this->waApiClient = WaApiClient::getInstance();

        //uncomment below for general debugging
        //$this->setWaAuth($this->waApiClient);
        //$r = $this->waApiClient->makeRequest($this->account_url . '/events/3416587', 'GET');
        //echo '<pre>'; var_dump($r); echo '</pre>'; exit();

        $this->timezone = new DateTimezone('America/New_York');

        //hook into events save action
        if(ENV !== 'dev'){
            add_action( 'wp_insert_post', array($this, 'event_saved'), 100, 3 ); //@todo pull post_type from settings
            add_action( 'trash_to_publish', array($this, 'trash_to_publish'), 10, 1 );
            add_action( 'trashed_post', array($this, 'trashed_post'), 10, 1 );

            //For Events Maker duplicate event feature
            add_action('em_after_duplicate_event', array($this, 'em_after_duplicate_event'), 10, 2 );
        }

        add_filter( 'removable_query_args', array($this, 'add_removable_arg') );

        add_action( 'admin_head', array($this, 'admin_head') );

        add_action( 'in_admin_header', array($this, 'import_events') );

        //For Events Maker duplicate event feature
        add_filter('em_duplicate_event_args', array($this, 'em_duplicate_event_args'), 10, 1 );
        add_filter('em_duplicate_event_meta_keys', array($this, 'em_duplicate_event_meta_keys'), 10, 1 );
    }

    /**
     * @param array $args
     * @return array
     */
    public function em_duplicate_event_args(array $args){
        //event_saved() is triggered later from em_after_duplicate_event after meta is added
        remove_action( 'wp_insert_post', array($this, 'event_saved'), 100 );
        return $args;
    }

    /**
     * @param array $keys
     * @return array
     */
    public function em_duplicate_event_meta_keys(array $keys){
        if($keys === null) return $keys;

        if (($key = array_search('_wa_event_id', $keys)) !== false) {
            unset($keys[$key]);
        }
        if (($key = array_search('_event_tickets_url', $keys)) !== false) {
            unset($keys[$key]);
        }

        //removes registration_types_X_registration_type_id && _registration_types_X_registration_type_id
        foreach($keys as $index => $key){
            if (substr($key, -21) === '_registration_type_id' &&
                (substr($key, 0, 18) === 'registration_types' || substr($key, 0, 19) === '_registration_types')) {
                unset($keys[$index]);
            }
        }

        return $keys;
    }

    /**
     * @param int $new_post_id
     * @param \WP_Post $old_post
     * @throws \Exception
     */
    public function em_after_duplicate_event( $new_post_id, \WP_Post $old_post){
        $new_post = get_post($new_post_id);
        $this->event_saved($new_post_id, $new_post, true);
    }

    /**
     * @param WaApiClient $waApiClient
     * @return boolean
     */
    public function setWaAuth($waApiClient){
        $api_key = get_field('wildapricot_api', 'option');
        if(!$api_key): ?>
            <div class="notice notice-warning is-dismissible">
                <p>No API key for WildApricot exists in <a href="<?php echo add_query_arg('page', 'acf-options', get_admin_url()); ?>">Settings</a>. Without one, events will not sync on save.</p>
            </div>
        <?php return false;
        endif;
        $waApiClient->initTokenByApiKey($api_key);
        $this->setAccountUrl($waApiClient);
        return true;
    }

    public function import_events(){
        if(isset($_GET['fix_membership_type']) && $_GET['fix_membership_type'] === 'now'){
            global $wpdb;
            $posts = $wpdb->get_results("
                SELECT * FROM `wp_postmeta`
                WHERE `meta_value` = 'a:6:{i:0;s:14:\"1 - Individual\";i:1;s:10:\"2 - Family\";i:2;s:16:\"3 - Contributing\";i:3;s:14:\"4 - Sustaining\";i:4;s:8:\"5 - Life\";i:5;s:13:\"6 - Corporate\";}'
                AND `meta_key` LIKE '%membership_types%'
                ORDER BY `post_id` LIMIT 0, 1000
                ");
            $membership_types = [
                "1 - Individual",
                "2 - Family",
                "3 - Contributing",
                "4 - Sustaining",
                "5 - Life",
                "6 - Corporate"
            ];
            if($posts && is_array($posts)){
                foreach($posts as $post){
                    update_post_meta($post->post_id, $post->meta_key, $membership_types);
                    $this->event_saved($post->post_id, get_post($post->post_id), true);
                }
            }

        }

        if(isset($_GET['import_wa_events']) && $_GET['import_wa_events'] === "now"){
            if(!$this->setWaAuth($this->waApiClient)) return false;
            $skip = isset($_GET['skip']) ? $_GET['skip'] : 0;
            $top = isset($_GET['top']) ? $_GET['top'] : 20;

            $url = $this->account_url . '/events';
            $query = [
                '$skip' => $skip,
                '$top' => $top,
                '$sort' => "ByStartDate%20asc"
            ];
            $url = add_query_arg($query, $url);

            $events = $this->waApiClient->makeRequest($url);
            //echo '<pre>'; var_dump($events); echo '</pre>';
            echo "Starting Event Import: " . count($events['Events']) . " Events, " . $skip . " from start.<br>";

            remove_action('wp_insert_post', array($this, 'event_saved'), 100);

            foreach($events['Events'] as $event){
                //check if a post event already has the WA ID associated with it
                $wa_event_id = $event['Id'];
                echo "Starting WA Event " . $wa_event_id . "<br>";
                $args = [
                    'post_type' => 'event',
                    'post_status' => 'any',
                    'meta_query' => [
                        [
                            'key' => '_wa_event_id',
                            'value' => $wa_event_id,
                            'compare' => '='
                        ]
                    ]
                ];
                $query = new WP_Query($args);
                if($query->found_posts){
                    echo "-- Skipping WA Event (ID: " . $wa_event_id . "), already exists as POST ID: " . $query->queried_object_id . "<br>";
                    continue;
                }

                //get all event details from WA
                try {
                    $event = $this->waApiClient->makeRequest($this->account_url . '/events/' . $wa_event_id);
                }
                catch(\Exception $e){
                    printf("-- <strong>ERROR</strong>: Skipping WA Event (ID: %d). Couldn't get details from WA. %s<br>", $wa_event_id, $e->getMessage());
                    continue;
                }

               //echo '<pre>'; var_dump($event); echo '</pre>'; exit();

                //start compiling variables to add to WP
                $args = array(
                    'post_content'          => $event['Details']['DescriptionHtml'],
                    'post_content_filtered' => '',
                    'post_title'            => $event['Name'],
                    'post_excerpt'          => wp_trim_words($event['Details']['DescriptionHtml'], 55),
                    'post_status'           => 'publish',
                    'post_type'             => 'event',
                    'comment_status'        => 'closed',
                    'ping_status'           => 'closed'
                );
                $result = wp_insert_post($args, true);
                if(is_wp_error($result)){
                    printf("-- <strong>ERROR</strong>: Skipping WA Event (ID: %d). Error inserting WP Post. %s<br>", $wa_event_id);
                    var_dump($result);
                    continue;
                }
                $post_id = $result;

                //add the meta
                add_post_meta($post_id, '_wa_event_id', $wa_event_id);

                //location
                $location_term_id = 0;
                if(strpos($event['Location'], 'Natural History Society of Maryland') !== false ||
                    strpos($event['Location'], 'Natural History Society of MD') !== false)
                    $event['Location'] = "Natural History Society of MD";
                $location = get_term_by('name', $event['Location'], 'event-location');
                if(!$location){
                    //add new term
                    $loc_term = wp_insert_term($event['Location'], 'event-location');
                    if(is_wp_error($loc_term)){
                        echo "-- <strong>ERROR</strong>: Unable to add new location term<br>";
                        var_dump($loc_term);
                    }
                    else $location_term_id = $loc_term['term_id'];
                }
                else $location_term_id = $location->term_id;

                //add location to post
                if($location_term_id) wp_set_post_terms( $post_id, $location_term_id, 'event-location', false );

                //tags
                wp_set_post_tags( $post_id, $event['Tags'] );

                //start/end dates
                add_post_meta($post_id, '_event_all_day', intval(!$event['StartTimeSpecified']));
                $start = get_date_for_wp($event['StartDate']);
                $end = get_date_for_wp($event['EndDate']);

                if(isset($event['Sessions']) && count($event['Sessions'])){
                    $separate_end_date = [];
                    foreach($event['Sessions'] as $session){
                        $start = get_date_for_wp($session['StartDate']);
                        $end = get_date_for_wp($session['EndDate']);
                        $separate_end_date[] = intval($end !== $start);
                        add_post_meta($post_id, '_event_occurrence_date', $start . '|' . $end);
                    }
                    add_post_meta($post_id, '_event_occurrence_last_date', $start . '|' . $end);

                    $last_session = end($event['Sessions']);
                    $recurrence = [
                        "type" => 'custom',
                        "repeat" => 1,
                        "until" => get_date_for_wp($last_session['StartDate'], "Y-m-d"),
                        "separate_end_date" => $separate_end_date
                    ];
                    add_post_meta($post_id, '_event_recurrence', $recurrence);

                    $start = get_date_for_wp($event['Sessions'][0]['StartDate']);
                    $end = get_date_for_wp($event['Sessions'][0]['EndDate']);
                }
                else {
                    add_post_meta($post_id, '_event_occurrence_date', $start . '|' . $end);
                }
                add_post_meta($post_id, '_event_start_date', $start);
                add_post_meta($post_id, '_event_end_date', $end);

                add_post_meta($post_id, '_event_tickets_url', 'https://marylandnature.wildapricot.org/event-' . $wa_event_id. '/Registration');
                $display_options = [
                    "google_map" => true,
                    "display_gallery" => true,
                    "display_location_details" => true,
                    "price_tickets_info" => false
                ];
                add_post_meta($post_id, '_event_display_options', $display_options);

                //registration
                $enable_registration = 0;
                $reg_types = $event['Details']['RegistrationTypes'];
                foreach($reg_types as $reg_type){
                    if($reg_type['IsEnabled']) {
                        $enable_registration = 1;
                        $membership_types = [];
                        $levels = [
                            313349 => "1 - Individual",
                            313508 => "2- Family",
                            313510 => "3 - Contributing",
                            313511 => "4 - Sustaining",
                            313512 => "5 - Life",
                            313513 => "6 - Corporate"
                        ];
                        if($reg_type['Availability'] === 'MembersOnly' && isset($reg_type['AvailableForMembershipLevels']) && is_array($reg_type['AvailableForMembershipLevels'])){
                            foreach($reg_type['AvailableForMembershipLevels'] as $level) $membership_types[] = $levels[$level['Id']];
                        }

                        $registration_types = [
                            'registration_type_id' => $reg_type['Id'],
                            'name' => $reg_type['Name'],
                            'description' => $reg_type['Description'],
                            'base_price' => $reg_type['BasePrice'],
                            'registration_limit_for_type' => isset($reg_type['MaximumRegistrantsCount']) ? $reg_type['MaximumRegistrantsCount'] : '',
                            'waitlist' => intval($reg_type['IsWaitlistEnabled']),
                            'cancellation' => $reg_type['CancellationBehaviour'],
                            'cancellation_cutoff' => $reg_type['CancellationDaysBeforeEvent'],
                            'allow_guest_registrations' => $reg_type['GuestRegistrationPolicy'] === 'Disabled' ? false : true,
                            'information_to_collect' => $reg_type['GuestRegistrationPolicy'] === 'Disabled' ? '' : $reg_type['GuestRegistrationPolicy'],
                            'guest_pricing' => $reg_type['GuestPrice'] === $reg_type['BasePrice'] ? 'basePrice' : 'specialPrice',
                            'guest_price' => $reg_type['GuestPrice'],
                            'guest_limit' => isset($reg_type['MaxGuestsCount']) ? $reg_type['MaxGuestsCount'] : '',
                            'availability' => $reg_type['Availability'],
                            'membership_types' => $membership_types,
                            'registration_code' => isset($reg_type['RegistrationCode']) ? $reg_type['RegistrationCode'] : '',
                            'available_period' => [
                                'from' => isset($reg_type['AvailableFrom']) ? get_date_for_wp($reg_type['AvailableFrom'], 'U') : '',
                                'to' => isset($reg_type['AvailableThrough']) ? get_date_for_wp($reg_type['AvailableThrough'], 'U') : ''
                            ],
                            'if_unavailable' => $reg_type['UnavailabilityPolicy']
                        ];
                        add_row("registration_types", $registration_types, $post_id);
                    }
                }

                $registration_details = [
                    'registration_limit' => $event['RegistrationsLimit'],
                    'waitlist' => $event['Details']['IsWaitlistEnabled'],
                    'registration_extra_information' => $event['Details']['RegistrationConfirmationExtraInfo'],
                    'registration_message' => $event['Details']['RegistrationMessage']
                ];
                update_field("registration_details", $registration_details, $post_id );
                update_field('enable_registration', $enable_registration, $post_id);
                update_field('payment_instructions', $event['Details']['PaymentInstructions'], $post_id);

                printf("-- Successfully add to WP with meta. Post ID: %d<br>", $post_id);
            }
        }
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
     * @param \WP_Post $post
     * @param int $event_id
     * @return array|bool|mixed|object
     */
    public function deleteEvent($post, $event_id){
        $event_url = $this->getEventUrl($event_id);
        $response = false;
        try{
            $response = $this->waApiClient->makeRequest($event_url, 'DELETE');
        }
        catch(\Exception $e){
            $this->send_error("deleteEvent\n" . $e->getMessage(), [], $post, $event_id);
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
            $this->send_error(
                "<br/><br/>getEvent<br />" . $e->getMessage() .
                "<br/><br/>Unable to retrieve event from WildApricot." .
                "<br/><br/>If the event no longer exists in WildApricot, please <a href='mailto:".get_option('admin_email')."'>contact the site admin</a>.",
                [],
                $post,
                $event_id
            );
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

        if($post->post_status === 'publish' && $update && $this->setWaAuth($this->waApiClient)){

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
                $data['StartDate'] = set_date_for_wa($start, $this->timezone);
                $data['StartTimeSpecified'] = !boolval($allday);
            }
            $end = get_post_meta($post_id, '_event_end_date', true);
            if($end){
                $data['EndDate'] = set_date_for_wa($end, $this->timezone);
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
            if($post_tags) {
                foreach ($post_tags as $tag) {
                    $tags[] = $tag->name;
                }
            }
            if (!empty($tags)) $data['Tags'] = $tags;

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
                    "StartDate" => set_date_for_wa($dates[0], $this->timezone),
                    "StartTimeSpecified" => $start_time !== '00:00:00',
                    "EndDate" => set_date_for_wa($dates[1], $this->timezone),
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
                    $wa_event_id = $this->createEvent($data, $post);
                    update_post_meta($post_id, '_wa_event_id', $wa_event_id);
                    add_filter( 'redirect_post_location', array( $this, 'add_create_success_query_var' ), 99 );
                    if($reg_enabled) $this->addEventRegistrationTypes($wa_event_id, $post);
                }
                catch(\Exception $e){
                    add_filter( 'redirect_post_location', array( $this, 'add_create_error_query_var' ), 99 );
                }
            }

            if($reg_enabled && $wa_event_id){
                update_post_meta($post_id, '_event_tickets_url', 'https://marylandnature.wildapricot.org/event-' . $wa_event_id . '/Registration');
            }
            else {
                delete_post_meta($post_id, '_event_tickets_url');
            }
        }

        return $post_id;
    }

    /**
     * @param \WP_Post $post
     * @throws \Exception
     * @return \WP_Post
     */
    public function trash_to_publish($post){
        $this->event_saved($post->ID, $post, true);
        return $post;
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
        if($types && is_array($types)) {
            foreach ($types as $index => $type) {
                //check if reg type ID already exists, if so we're updating
                $wa_reg_type_id = $type['registration_type_id'];

                $base_price = $type['base_price'];
                $guest_pricing = $type['guest_pricing'];
                $guest_price = $guest_pricing === 'basePrice' ? $base_price : $type['guest_price'];
                $availability = $type['availability'];
                if ($availability === "MembersOnly") {
                    $membership_types = $type['membership_types'];
                    $membership_levels_formatted = [];
                    foreach ($membership_levels as $membership_level) {
                        if (in_array($membership_level['Name'], $membership_types))
                            $membership_levels_formatted[] = [
                                'Id' => $membership_level['Id']
                            ];
                    }
                } else $membership_levels_formatted = NULL;

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

                if ($wa_reg_type_id) {
                    $data['Id'] = $wa_reg_type_id;
                    try {
                        $this->waApiClient->makeRequest($this->account_url . '/EventRegistrationTypes/' . $wa_reg_type_id, 'PUT', $data);
                    } catch (\Exception $e) {
                        $this->send_error("PUT EventRegistrationTypes\n" . $e->getMessage(), $data, $post, $wa_event_id);
                    }
                } else {
                    try {
                        $wa_reg_type_id = $this->waApiClient->makeRequest($this->account_url . '/EventRegistrationTypes', 'POST', $data);
                        update_post_meta($post->ID, 'registration_types_' . $index . '_registration_type_id', $wa_reg_type_id);
                    } catch (\Exception $e) {
                        $this->send_error("POST EventRegistrationTypes\n" . $e->getMessage(), $data, $post, $wa_event_id);
                    }
                }

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
        if($reg_types && is_array($reg_types)) {
            foreach ($reg_types as $reg_type) {
                $reg_type_ids[] = $reg_type['registration_type_id'];
            }
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

    public function trashed_post($post_id){
        $wa_event_id = get_post_meta($post_id, '_wa_event_id', true);
        if($wa_event_id){
            $this->setWaAuth($this->waApiClient);
            $post = get_post($post_id);

            try{
                $this->deleteEvent($post, $wa_event_id);
            }
            catch(\Exception $e){
                $this->send_error("DELETE Event\n" . $e->getMessage(), [], $post, $wa_event_id);
            }
        }

        return $post_id;
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
        if(!$wa_event_id || !$this->setWaAuth($this->waApiClient)) return;

        try{
            $wa_event = $this->getEvent($wa_event_id, $post);
            if(empty($wa_event['Details']['RegistrationTypes'])): ?>
                <div class="notice notice-warning">
                    <p><strong>This event has no registration types. Registration will not be active until a registration type is added.</strong></p>
                </div>
            <?php endif; ?>
                <div class="notice notice-info">
                    <p>This event has a corresponding entry in <a href="https://marylandnature.wildapricot.org/admin/events/details/?DetailsDisplayMode=View&eventId=<?php echo $wa_event_id; ?>" target="_blank" title="Edit event in WildApricot.">WildApricot</a> with ID: <?php echo $wa_event_id; ?>.</strong></p>
                </div>
            <?php
        }
        catch (\Exception $e){ ?>
            <div class="notice notice-warning">
                <p>Error in pulling event details from WildApricot.</p>
            </div>
        <?php }
    }

}

/* Helpers */
function get_date_for_wp($wa_date, $format = "Y-m-d H:i:s"){
    $ts = strtotime($wa_date);
    $offset = substr($wa_date, -6, 3);
    $fixed = strtotime($offset . " hours", $ts);
    return date($format, $fixed);
}

/**
 * @param string $wp_date
 * @param DateTimezone $tz
 * @return string
 */
function set_date_for_wa($wp_date, $tz){
    if(!$tz) $tz = new DateTimezone('America/New_York');
    $dt = new DateTime($wp_date, $tz);
    return $dt->format('c');
}