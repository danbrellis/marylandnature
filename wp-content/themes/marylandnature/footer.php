				<?php if(class_exists('wp_debug')) wp_debug::debug_info(); ?>
				<footer class="footer" role="contentinfo">
					<div id="inner-footer" class="row">
						<div class="medium-12 columns">
							<div class="media-object">
								<div class="media-object-section">
									<a href="<?php echo site_url(); ?>" title="Home"><?php echo wp_get_attachment_image( get_field('footer_logo', 'option'), 'thumbnail', "", array( "class" => "img-responsive hide-for-small-only" ) ); ?></a>
								</div>
								<div class="media-object-section">
									<span class="h4"><?php bloginfo('name'); ?></span><br />
									<?php echo nl2br(get_field('org_info_block', 'option')); ?>
								</div>
								<div class="media-object-section">
									<?php if( have_rows('social_icons', 'option') ): ?>
									<ul class="home-social">
										<?php while ( have_rows('social_icons', 'option') ) : the_row();
										$fi = get_sub_field('social_media_icon');
										$img_id = get_sub_field('social_website_custom_image');
										$icon = '';
										if($fi) $icon = '<i class="fi-'.$fi.'"></i>';
										elseif($img_id) {
											$icon = wp_get_attachment_image( $img_id, false, "" );
										}
										else $icon = '<i class="fi-web"></i>'
										?>
										<li><a href="<?php the_sub_field('social_website_url'); ?>" title="<?php the_sub_field('social_website_name'); ?>" target="_blank"><?php echo $icon; ?></a></li>
										<?php endwhile; ?>
									</ul>
									<?php endif; ?>
								</div>
							</div>

						</div>
						<div class="medium-60 columns0">
							
						</div>
					</div> <!-- end #inner-footer -->
					<div class="row">
						<div class="medium-12 columns">
							<nav role="navigation">
								<a href="<?php echo wp_login_url( admin_url() ); ?>" id="member-login">Member Login</a>
								<?php joints_footer_links(); ?>
								
							</nav>
						</div>
					</div>
					<div class="row">
						<div class="medium-12 columns">
							<p class="source-org copyright text-center">Website designed &amp; developed by Dan Brellis with <a href="https://wordpress.org/" target="_blank">Wordpress</a> &amp; <a href="http://foundation.zurb.com/" target="_blank">Zurb's Foundation</a> | &copy; <?php echo date('Y'); ?></p>
						</div>
					</div>
				</footer> <!-- end .footer -->
			</div>  <!-- end .main-content -->
		</div> <!-- end .off-canvas-wrapper -->
		<?php wp_footer(); ?>
	</body>
</html> <!-- end page -->