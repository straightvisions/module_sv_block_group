<?php
	// common
	echo $_s->build_css(
		'.wp-block-group',
		array_merge(
			$module->get_setting('padding')->get_css_data('padding'),
			$module->get_setting('margin')->get_css_data()
		)
	);