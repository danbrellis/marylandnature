<?php
update_option( 'otb_new_theme', false );
?>

<h2><?php echo __( 'Check out our themes!', 'super-simple-slider' ); ?></h2>

<p>
	<?php
	echo __( 'If you like this plugin you might like our themes!', 'super-simple-slider' );
	?>
<p>


<ul class="vanilla themes">

<?php 
foreach ($this->themes as $theme) {
	$theme = (object) $theme; 
	$new = true === $theme->new;

	if ($new && !get_option( 'otb_new_theme_' .$theme->slug. '_viewed' ) ) {
		update_option( 'otb_new_theme_' .$theme->slug. '_viewed', true );
	}
?>

	<li>
	
		<a href="https://www.outtheboxthemes.com/go/plugin-super-simple-slider-<?php echo $theme->slug; ?>" target="_blank"><?php echo '<img src="'. $theme->thumbnail .'" title="' .$theme->title. ' WordPress theme" />'; ?></a>
	
		<div class="details">
			<h2>
			<?php 
				echo '<a href="https://www.outtheboxthemes.com/go/plugin-super-simple-slider-' .$theme->slug. '" target="_blank" title="' .$theme->title. ' WordPress theme">' . $theme->title . '</a>';
				if ( $new ) {
					echo '<span class="new">NEW!</span>';
				}
			?>
			</h2>
			
<?php
	if ( $theme->coming_soon == false ) {
	} else {
?>
	<span class="color-text"><?php echo __( 'Coming soon!', 'super-simple-slider' ); ?></span>
<?php 
	}
?>
		</div>

	</li>
	
<?php
}
?>

</ul>