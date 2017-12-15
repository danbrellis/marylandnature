<div id="sidebar1" class="sidebar medium-pull-9 medium-3 columns hide-for-small-only" role="complementary" data-equalizer-watch="brellis" data-sticky-container>
	<div class="sticky" data-sticky data-margin-top="0" data-anchor="post-<?php the_ID(); ?>">
		<?php joints_sidebar_nav(); ?>

		<?php if ( is_active_sidebar( 'sidebar1' ) ) : ?>

			<?php dynamic_sidebar( 'sidebar1' ); ?>

		<?php else : ?>

			<!-- This content shows up if there are no widgets defined in the backend. -->

		<?php endif; ?>
	</div>
</div>