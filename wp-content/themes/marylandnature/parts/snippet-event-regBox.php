<?php global $post; ?>
<div class="callout event-regBox">
    <ul class="post-meta flex-list flex-list--wrap">
        <li class="flex-list__item icon-with-text">
            <i class="far fa-clock"></i>
            <?php echo nhsm_get_upcoming_event_date_range($post); ?>
        </li>
        <?php if(nhsm_is_event_over()): ?>
            <li class="post-meta-notice flex-list__item icon-with-text">
                <i class="fas fa-exclamation-circle"></i>
                This event has passed.
            </li>
        <?php else:
            $tickets_url = get_post_meta( get_the_ID(), '_event_tickets_url', true );
            $reg_enabled = get_field('enable_registration', get_the_ID());
            if ( $tickets_url && $reg_enabled ) : ?>
                <li class="post-meta-action flex-list__item icon-with-text">
                    <i class="far fa-check-square"></i>
                    <a href="<?php echo esc_url($tickets_url); ?>" title="Visit event registration url" target="_blank">Register Now!</a>
                </li>
            <?php endif;
        endif; ?>
    </ul>
</div>