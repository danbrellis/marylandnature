<?php 
$dlm_download = new DLM_Download( get_the_ID() );
// Adjust the amount of rows in the grid
$grid_columns = 2;
$grid_width = 12 / $grid_columns; ?>

<?php if( 0 === ( $wp_query->current_post  )  % $grid_columns ): ?>

    <div class="row archive-grid"> <!--Begin Row:--> 

<?php endif; ?> 

		<!--Item: -->
		<div class="large-<?php echo $grid_width; ?> medium-<?php echo $grid_width; ?> columns">
		
			<div id="post-<?php the_ID(); ?>" <?php post_class('callout'); ?> role="article">
				<?php $download = new DLM_Download( get_the_ID() ); ?>
				<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>" class="h4"><?php the_title(); ?></a>
				<ul class="post-meta clearfix no-bullet subtle">
					<li class="post-meta-date"><i class="fi-clock"></i>&nbsp;<?php echo get_the_time('F j, Y'); ?></li>
					<li class="post-meta-filetype"><i class="fi-page-copy"></i>&nbsp;<?php echo $dlm_download->get_the_filetype(); ?></li>
					<?php the_tags('<li class="post-meta-tags"><i class="fi-pricetag-multiple"></i>&nbsp;', ', ', '</li>'); ?>
				</ul>
				<?php the_excerpt(); ?>
				<a href="<?php $download->the_download_link(); ?>" class="small button"><i class="fi-download leftset"></i>&nbsp;Download</a>
			</div> <!-- end .callout -->
			
		</div>

<?php if( 0 === ( $wp_query->current_post + 1 )  % $grid_columns ||  ( $wp_query->current_post + 1 ) ===  $wp_query->post_count ): ?>

   </div>  <!--End Row: --> 

<?php endif; ?>

