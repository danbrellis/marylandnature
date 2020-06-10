<?php /* in the loop */ ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('page article main__content'); ?>>
    <header class="page__header article__header">
        <h1 class="page__title article__title"><?php the_title(); ?></h1>
        <?php
        get_template_part('parts/snippet', 'event-regBox');

        nhsm_the_banner_image();
        the_tags('<p class="icon-with-text"><i class="fas fa-tags icon icon--accentuate" title="Tagged with:"></i>&nbsp;', ', ', '</p>');
        nhsm_em_the_event_terms_list(); ?>
    </header>
    <section class="page__content article__content">
        <?php the_content(); ?>

        <?php
        //if event hasn't passed, show registration options
        if(!nhsm_is_event_over()):

            $reg_types = get_field('registration_types');
            $tickets_url = get_post_meta( get_the_ID(), '_event_tickets_url', true );

            if( have_rows('registration_types') ): ?>
                <h2>Registration</h2>
                <?php if(count($reg_types) > 1): ?>
                    <span class="subheader h4">Levels:</span>
                    <ul>
                        <?php while ( have_rows('registration_types') ) : the_row(); ?>
                            <li>
                                <?php $name = get_sub_field('name');
                                $desc = get_sub_field('description');
                                $price = get_sub_field('base_price'); ?>
                                <?php printf('<strong>%s:</strong> $%d', $name, $price); ?>
                                <?php if($desc !== ''): ?><br /><span class="h6 subheader"><?php echo $desc; ?></span><?php endif; ?>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <p>
                        <?php while ( have_rows('registration_types') ) : the_row();
                            $name = get_sub_field('name');
                            $desc = get_sub_field('description');
                            $price = get_sub_field('base_price');
                            printf('<strong>%s:</strong> $%d', $name, $price); ?>
                            <?php if($desc !== ''): ?><br /><span class="h6 subheader"><?php echo $desc; ?></span><?php endif; ?>
                        <?php endwhile; ?>
                    </p>
                <?php endif; ?>
                <a href="<?php echo esc_url($tickets_url); ?>" class="button" title="Visit event registration url" target="_blank">Register Now!</a>
            <?php endif;
        endif ?>
        <h2>Location</h2>
        <?php em_display_single_event_google_map(); ?>
        <?php em_display_event_gallery(); ?>
    </section>
    <footer class="page__footer article__footer">

    </footer>
</article>