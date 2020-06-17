<?php
	$settings = $script->get_parent()->get_settings();
	echo reset($settings)->build_css(
		is_admin() ? '.editor-styles-wrapper ul, .editor-styles-wrapper .wp-block-group' : '.sv100_sv_content_wrapper article ul, .sv100_sv_content_wrapper article .wp-block-group',
		array_merge(
			$script->get_parent()->get_setting('padding')->get_css_data('padding'),
			$script->get_parent()->get_setting('margin')->get_css_data(),
			$script->get_parent()->get_setting('border')->get_css_data()
		)
	);

	echo $script->get_parent()->get_setting('custom_css')->wrap_media_queries();