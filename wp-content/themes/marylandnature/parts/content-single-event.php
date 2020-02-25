<article id="post-<?php the_ID(); ?>" <?php post_class(''); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
						
	<header class="article-header">	
		<?php nhsm_addthis(); ?>
		<h1 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>
		<?php 
		nhsm_em_the_date_reg_box();
		nhsm_the_banner_image();
		the_tags('<p class="post_tags"><i class="fi-pricetag-multiple" title="Tagged with:"></i>&nbsp;', ', ', '</p>');
		nhsm_em_the_event_terms_list(); ?>
	</header> <!-- end article header -->
					
	<section class="entry-content" itemprop="articleBody">
		<?php //the_post_thumbnail('full'); ?>
		<?php the_content(); ?>
        <?php $reg_types = get_field('registration_types');
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
        <?php endif; ?>
        <h2>Location</h2>
        <?php em_display_single_event_google_map(); ?>
		<?php em_display_event_gallery(); ?>
	</section> <!-- end article section -->
						
	<footer class="article-footer">
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'jointswp' ), 'after'  => '</div>' ) ); ?>
	</footer> <!-- end article footer -->

	<?php comments_template(); ?>

</article> <!-- end article -->