<?php
$hidden_button_fields = true;

if ( !empty( $this->field['super_simple_slider_slide_button_' .$button_count. '_text'] ) ) {
	$hidden_button_fields = false;
	$active_button_count++;
}
?>

<li class="button-fields <?php echo( $hidden_button_fields ? 'hidden' : '' ); ?>">
	<div class="one-column">
		<!--
		<div class="button-sort-handle">
			<i class="icon sss-fa sss-fa-arrows"></i>
		</div>
		-->
		<div class="width-96">
			<div class="three-column even">
				<div class="column column-one">
					<?php $this->create_super_simple_form_control( 'super_simple_slider_slide_button_' .$button_count. '_text', $this->repeatable_fieldset_settings ); ?>
				</div>
				<div class="column column-two">
					<?php $this->create_super_simple_form_control( 'super_simple_slider_slide_button_' .$button_count. '_link_content', $this->repeatable_fieldset_settings ); ?>
				</div>
				<div class="column column-three">
					<?php $this->create_super_simple_form_control( 'super_simple_slider_slide_button_' .$button_count. '_link_target', $this->repeatable_fieldset_settings ); ?>
				</div>
			</div>
			
			<?php $this->create_super_simple_form_control( 'super_simple_slider_slide_button_' .$button_count. '_link_custom_url', $this->repeatable_fieldset_settings ); ?>
		</div>
		<div class="actions width-4">
			<a href="#" class="delete-button icon" title="Delete this button">
				<i class="sss-fa sss-fa-times"></i>
			</a>
		</div>
	</div>
</li>
