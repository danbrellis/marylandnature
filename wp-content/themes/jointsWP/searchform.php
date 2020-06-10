<?php $search_field_id = 'search-field_' . microtime(true); ?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
  <div class="input-group">
		<label class="input-group-label" for="<?php echo $search_field_id; ?>">Search for:</label>
		<input type="search" class="search-field input-group-field" id="<?php echo $search_field_id; ?>" placeholder="Try 'mammals', 'minerals', 'moss', or more!" value="<?php echo get_search_query() ?>" name="s" title="Search for:" />
		<div class="input-group-button">
			<input type="submit" class="search-submit button" value="<?php echo esc_attr_x( 'Search', 'jointswp' ) ?>" />
		</div>
	</div>
  
</form>


