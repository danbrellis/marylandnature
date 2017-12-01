<div class="top-bar" id="main-menu">
	<div class="container">
		<div class="row">
      <div class="small-12 columns">
        <div class="float-left">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="brand"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/nhsm-logo.png" alt="<?php bloginfo('name'); ?>" /></a>
          <span class="site-tagline show-for-large"><?php bloginfo('description'); ?></span>
        </div>
        <div class="top-nav-cont">
          <button type="button" id="off-canvas-toggle" class="button float-right" data-toggle="off-canvas" aria-label="Open the main navigation"><span>Menu </span><div class="toci" aria-hidden="true" title="Toggle main menu"><span></span><span></span><span></span></div></button>
          <div class="top-bar-right">
            <div class="full reveal" id="search-modal" data-reveal data-full-screen="true" data-animation-in="hinge-in-from-top" data-animation-out="hinge-out-from-top">
              <div class="container">
                <div class="row">
                  <div class="small-10 medium-8 columns small-offset-1 medium-offset-2">
                    <h1>What do you want to find?</h1>
                    <?php get_search_form(); ?>
                  </div>
                </div>
              </div>
              <button class="close-button" data-close aria-label="Close modal" type="button">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <?php joints_aux_nav(); ?>
          </div>
          <div class="top-bar-right">
            <?php joints_top_nav(); ?>
          </div>
        </div>
      </div>
		</div>
	</div>
</div>