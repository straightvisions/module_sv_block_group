<?php
	// common
	echo $_s->build_css(
		'.wp-block-group',
		array_merge(
			$module->get_setting('padding')->get_css_data('padding'),
			$module->get_setting('margin')->get_css_data(),
			$module->get_setting('border')->get_css_data()
		)
	);

	echo $_s->build_css(
		'.wp-block-group.has-background',
		array_merge(
			$module->get_setting('bg_padding')->get_css_data('padding')
		)
	);

	echo $module->get_setting('custom_css')->wrap_media_queries();