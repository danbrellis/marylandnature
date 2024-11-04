
<ul class="fieldset">
	<li>
		<?php $this->create_super_simple_form_control( 'super_simple_slider_speed', $this->settings ); ?>
	</li>
	
	<li>
		<?php $this->create_super_simple_form_control( 'super_simple_slider_has_min_width', $this->settings ); ?>
		
		<div class="super_simple_slider_min_width_settings settings-container">
			<ul class="fieldset">
				<li>
					<?php $this->create_super_simple_form_control( 'super_simple_slider_min_width', $this->settings ); ?>
				</li>
			</ul>
		</div>
	</li>
</ul>
