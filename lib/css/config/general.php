<?php
	$settings = $module->get_settings();
	echo reset($settings)->build_css(
		is_admin() ? '.editor-styles-wrapper ul, .editor-styles-wrapper .wp-block-group' : '.sv100_sv_content_wrapper article .wp-block-group',
		array_merge(
			$module->get_setting('padding')->get_css_data('padding'),
			$module->get_setting('margin')->get_css_data(),
			$module->get_setting('border')->get_css_data()
		)
	);

	echo $module->get_setting('custom_css')->wrap_media_queries();