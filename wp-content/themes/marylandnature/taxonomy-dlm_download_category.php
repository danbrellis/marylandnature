<?php get_header(); 
$term = get_queried_object(); ?>
	
	<div id="content">
		<div id="inner-content">
			<div class="row">
				<div class="medium-12 columns">
			
					<div class="row">
						<main id="main" class="medium-9 medium-push-3 columns" role="main">
							<header class="article-header">
								<?php nhsm_addthis(); ?>
								<h1><?php the_archive_title();?></h1>
								<?php if($term->parent !== 0): 
									$parent = get_term( $term->parent, $term->taxonomy );?>
									<p>Parent Category: <a href="<?php echo get_term_link($parent, $parent->taxonomy); ?>"><?php echo $parent->name; ?></a></p>
								<?php endif; ?>
								<?php the_archive_description('<p class="taxonomy-description">', '</p>');?>
							</header>
							<?php //display sub categories
							$children = get_terms( $term->taxonomy, array(
								'parent'    => $term->term_id,
								'hide_empty' => false
							) );
							if($children): ?>
								<h2>Sub-Categories</h2>
								<div class="row" data-equalizer="folders">
									<?php $i = 0; foreach($children as $subcat): ?>
									<div class="columns large-4<?php if(count($children) === ++$i) echo ' end'; ?>"><a href="<?php echo get_term_link($subcat, $subcat->taxonomy); ?>" class="button expanded large hollow vert-center" data-equalizer-watch="folders"><span><?php echo $subcat->name; ?></span></a></div>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
							<?php if (have_posts()){
								echo '<h2>Resources</h2>';
								while (have_posts()){
									the_post();
									get_template_part( 'parts/loop', 'download-grid' );
								}
								joints_page_navi();
							}
							else {
								get_template_part( 'parts/content', 'missing' );
							} ?>
						</main> <!-- end #main -->

						<?php get_sidebar(); ?>

					</div>
				</div>
			</div>
		  
		  
		</div> <!-- end #inner-content -->

	</div> <!-- end #content -->

<?php get_footer(); ?>