<?php if ( current_user_can( 'activate_plugins' ) ) { ?>
	<div class="sv_setting_subpage">
		<h2><?php _e('Extra Styles', 'sv100'); ?></h2>
		<div class="sv_setting_flex">
			<?php
				echo $module->get_setting( 'extra_styles' )->form();
			?>
		</div>
	</div>
<?php } ?>