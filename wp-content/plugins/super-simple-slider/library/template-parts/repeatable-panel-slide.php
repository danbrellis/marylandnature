<tr class="panel <?php echo ( $hidden_panel ? 'hidden' : '' ); ?>">

	<td class="sort-handle">
		<i class="icon sss-fa sss-fa-arrows"></i>
	</td>
	
	<td class="image-container">
		<?php $this->create_super_simple_form_control( 'super_simple_slider_slide_image', $this->repeatable_fieldset_settings ); ?>
	</td>
	
	<td class="width-65 no-padding">
		
		<!-- Tabs -->
		<div class="otb-tabs-container">
			<ul class="tabs">
				<li><a data-tab="content" class="active"><?php esc_html_e( 'Content', 'super-simple-slider' ); ?></a></li>
				<li><a data-tab="seo"><?php esc_html_e( 'SEO', 'super-simple-slider' ); ?></a></li>
				<li><a data-tab="styling"><?php esc_html_e( 'Styling', 'super-simple-slider' ); ?></a></li>
			</ul>

			<!-- Content -->
			<div class="tab-content content active">
				<?php $this->create_super_simple_form_control( 'super_simple_slider_slide_title', $this->repeatable_fieldset_settings ); ?>
				<?php $this->create_super_simple_form_control( 'super_simple_slider_slide_text', $this->repeatable_fieldset_settings ); ?>

				<ul class="buttons sortable">
					<?php
					$max_buttons  		 = 1;
					$button_count 		 = 0;
					$active_button_count = 0;
					
					while ( $button_count < $max_buttons ) {
						$button_count++;
						include( $this->parent->assets_dir .'/template-parts/repeatable-panel-button.php' );
					}
					?>
					
					<li class="footer alignright">
						<a class="button add-button <?php echo ( $active_button_count == $max_buttons ) ? 'disabled' : ''; ?>" href="#"><?php esc_html_e( 'Add a Button', 'super-simple-slider' ); ?></a>
					</li>
				</ul>
			</div>
			
			<!-- SEO -->
			<div class="tab-content seo">
				<?php $this->create_super_simple_form_control( 'super_simple_slider_slide_image_alt', $this->repeatable_fieldset_settings ); ?>
				<?php $this->create_super_simple_form_control( 'super_simple_slider_slide_image_title', $this->repeatable_fieldset_settings ); ?>
			</div>
			
			<!-- Styling -->
			<div class="tab-content styling">
	
				<ul class="fieldset">
					<li>
						<?php $this->create_super_simple_form_control( 'super_simple_slider_slide_overlay_opacity', $this->repeatable_fieldset_settings ); ?>
					</li>
			
					<li>
						<?php $this->create_super_simple_form_control( 'super_simple_slider_slide_text_overlay_opacity', $this->repeatable_fieldset_settings ); ?>
					</li>
					
					<li>
						<?php $this->create_super_simple_form_control( 'super_simple_slider_slide_text_overlay_text_shadow', $this->repeatable_fieldset_settings ); ?>
					</li>
				</ul>
							
			</div>
			
		</div>
	</td>
	
	<td class="remove-repeatable-panel">
		<a href="#" class="icon" title="Delete this slide">
			<i class="sss-fa sss-fa-times"></i>
		</a>
	</td>
	
</tr>
