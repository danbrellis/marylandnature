<?php

namespace NHSM\Events\Metaboxes;

use NHSM\Events\Admin\Events_Admin;

if ( ! defined( 'ABSPATH' ) )
	exit;

class Metaboxes {

	public function __construct() {
		//actions
		add_action( 'add_meta_boxes_event', array( $this, 'add_events_meta_boxes' ), 10, 2 );
		add_action( 'save_post', array( $this, 'save_event' ), 10, 2 );
	}


	/**
	 * Add event metaboxes.
     * @param \WP_Post $post
	 */
	public function add_events_meta_boxes( $post ) {
        add_meta_box(
            'nhsm-event-registration-details-box',
            'Event Registration Details',
            array( $this, 'event_registration_cb' ),
            'event',
            'normal',
            'high'
        );
	}


	/**
	 * Event registration details metabox callback.
     * @param \WP_Post $post
	 */
	public function event_registration_cb( $post ) {
		wp_nonce_field( 'nhsm_wa_events_save_event_registration', 'nhsm_wa_event_nonce_registration' );

		// metas
		$reg_enabled = get_post_meta( $post->ID, '_nhsm_wa_events_registration_enabled', true );
        $reg_limit = get_post_meta( $post->ID, '_nhsm_wa_events_registration_limit', true );
        $reg_confirm_extra_info = get_post_meta( $post->ID, '_nhsm_wa_events_reg_confirm_extra_info', true );
        $reg_msg = get_post_meta( $post->ID, '_nhsm_wa_events_registration_msg', true );
        $payment_instr = get_post_meta( $post->ID, '_nhsm_wa_events_payment_instr', true );

        $wa_event_id = get_post_meta($post->ID, '_wa_event_id', true);
		?>
        <?php if($wa_event_id): ?>
            <div class="update-nag">This event is saved in WildApricot with ID <?php echo $wa_event_id; ?>. Use their <a href="https://marylandnature.wildapricot.org/admin/events/details/?DetailsDisplayMode=View&eventId=<?php echo $wa_event_id; ?>&selTab=3" target="_blank" title="Edit event in WildApricot.">event details dashboard</a> to complete event registration set up.</div>
        <?php endif; ?>
        <div class="nhsm_wa_events_reg_metabox">
            <label for="nhsm_wa_events_registration_enabled">Enable Registration?</label>
            <div>
                <input id="nhsm_wa_events_registration_enabled" type="checkbox" name="nhsm_wa_events_registration_enabled" value="1" <?php checked($reg_enabled); ?>>
            </div>

            <label for="nhsm_wa_events_registration_limit">Registration Limit:</label>
            <div>
                <input id="nhsm_wa_events_registration_limit" type="number" size="4" name="nhsm_wa_events_registration_limit" value="<?php echo esc_html($reg_limit); ?>"><br />
                <span class="description">Leave blank for unlimited</span>
            </div>

            <label for="nhsm_wa_events_reg_confirm_extra_info">Registration Extra<br />Information:</label>
            <div>
                <textarea id="nhsm_wa_events_reg_confirm_extra_info" rows="3" maxlength="2000" name="nhsm_wa_events_reg_confirm_extra_info"><?php echo esc_textarea($reg_confirm_extra_info); ?></textarea>
                <span class="description">Additional event information to be inserted in registration confirmation email (max length 2000 characters)</span>
            </div>

            <label for="nhsm_wa_events_registration_msg">Registration Message:</label>
            <div>
                <textarea id="nhsm_wa_events_registration_msg" rows="2" maxlength="500" name="nhsm_wa_events_registration_msg"><?php echo esc_textarea($reg_msg); ?></textarea>
                <span class="description">Shown above Register button on Event details (max length 500 characters)</span>
            </div>

            <label for="nhsm_wa_events_payment_instr">Payment Instructions:</label>
            <div>
                <textarea id="nhsm_wa_events_payment_instr" rows="3" maxlength="2000" name="nhsm_wa_events_payment_instr"><?php echo esc_textarea($payment_instr); ?></textarea>
                <span class="description">Payment instructions for this event only (for invoice) (max length 2000 characters)</span>
            </div>
        </div>

        <?php
	}

	/**
	 * Save event metaboxes data.
     * @param int $post_ID
     * @return int
	 */
	public function save_event( $post_ID ) {
		// break if doing autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_ID;

		// break if current user can't edit events
		if ( ! current_user_can( 'edit_event', $post_ID ) )
			return $post_ID;

		// event registration
		if ( isset( $_POST['nhsm_wa_event_nonce_registration'] ) && wp_verify_nonce( $_POST['nhsm_wa_event_nonce_registration'], 'nhsm_wa_events_save_event_registration' ) ) {
			update_post_meta( $post_ID, '_nhsm_wa_events_registration_enabled', (isset( $_POST['nhsm_wa_events_registration_enabled'] ) ? 1 : 0 ) );

            $reg_limit = $_POST['nhsm_wa_events_registration_limit'] === "" ? "" : intval( $_POST['nhsm_wa_events_registration_limit'] );
            update_post_meta( $post_ID, '_nhsm_wa_events_registration_limit', $reg_limit );

            $reg_confirm_extra_info = sanitize_textarea_field($_POST['nhsm_wa_events_reg_confirm_extra_info']);
            update_post_meta( $post_ID, '_nhsm_wa_events_reg_confirm_extra_info', $reg_confirm_extra_info );

            $reg_msg = sanitize_textarea_field($_POST['nhsm_wa_events_registration_msg']);
            update_post_meta( $post_ID, '_nhsm_wa_events_registration_msg', $reg_msg );

            $payment_instr = sanitize_textarea_field($_POST['nhsm_wa_events_payment_instr']);
            update_post_meta( $post_ID, '_nhsm_wa_events_payment_instr', $payment_instr );
		}

        return $post_ID;
	}
}

new Metaboxes();