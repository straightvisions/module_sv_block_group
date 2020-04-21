<?php
	if($extra_styles && count($extra_styles) > 0) {
		foreach($extra_styles as $extra_style) {

			// Margin
			if ($extra_style['margin']) {
				$margin = $extra_style['margin'];

				$imploded = false;
				foreach ($margin as $breakpoint => $val) {
					$top = (isset($val['top']) && strlen($val['top']) > 0) ? $val['top'] : false;
					$right = (isset($val['right']) && strlen($val['right']) > 0) ? $val['right'] : false;
					$bottom = (isset($val['bottom']) && strlen($val['bottom']) > 0) ? $val['bottom'] : false;
					$left = (isset($val['left']) && strlen($val['left']) > 0) ? $val['left'] : false;

					if($top !== false || $right !== false || $bottom !== false || $left !== false) {
						$imploded[$breakpoint] = $top . ' ' . $right . ' ' . $bottom . ' ' . $left;
					}
				}
				if ($imploded) {
					$properties['margin'] = $setting->prepare_css_property_responsive($imploded, '', '');
				}
			}

			// Padding
			// @todo: same as margin, refactor to avoid doubled code
			if ($extra_style['padding']) {
				$padding = $extra_style['padding'];

				$imploded = false;
				foreach ($padding as $breakpoint => $val) {
					$top = (isset($val['top']) && strlen($val['top']) > 0) ? $val['top'] : false;
					$right = (isset($val['right']) && strlen($val['right']) > 0) ? $val['right'] : false;
					$bottom = (isset($val['bottom']) && strlen($val['bottom']) > 0) ? $val['bottom'] : false;
					$left = (isset($val['left']) && strlen($val['left']) > 0) ? $val['left'] : false;

					if($top !== false || $right !== false || $bottom !== false || $left !== false) {
						$imploded[$breakpoint] = $top . ' ' . $right . ' ' . $bottom . ' ' . $left;
					}
				}
				if ($imploded) {
					$properties['padding'] = $setting->prepare_css_property_responsive($imploded, '', '');
				}
			}

			// border
			if ($extra_style['border']) {
				$border = $extra_style['border'];

				if ($border['top_width']) {
					$val = $border['top_width'] . ' ' . $border['top_style'] . ' rgba(' . $border['color'] . ')';
					$properties['border-top'] = $setting->prepare_css_property_responsive($val, '', '');
				}
				if ($border['right_width']) {
					$val = $border['right_width'] . ' ' . $border['right_style'] . ' rgba(' . $border['color'] . ')';
					$properties['border-right'] = $setting->prepare_css_property_responsive($val, '', '');
				}
				if ($border['bottom_width']) {
					$val = $border['bottom_width'] . ' ' . $border['bottom_style'] . ' rgba(' . $border['color'] . ')';
					$properties['border-bottom'] = $setting->prepare_css_property_responsive($val, '', '');
				}
				if ($border['left_width']) {
					$val = $border['left_width'] . ' ' . $border['left_style'] . ' rgba(' . $border['color'] . ')';
					$properties['border-left'] = $setting->prepare_css_property_responsive($val, '', '');
				}

				if ($border['top_left_radius'] + $border['top_right_radius'] + $border['bottom_right_radius'] + $border['bottom_left_radius'] !== 0) {
					$border_radius = $border['top_left_radius'] . ' ' . $border['top_right_radius'] . ' ' . $border['bottom_right_radius'] . ' ' . $border['bottom_left_radius'];
					$properties['border-radius'] = $setting->prepare_css_property_responsive($border_radius, '', '');
				}
			}

			echo $setting->build_css(
				is_admin() ? '.edit-post-visual-editor.editor-styles-wrapper .wp-block-group.is-style-' . $extra_style['slug'] : '.sv100_sv_content_wrapper article .wp-block-group.is-style-' . $extra_style['slug'],
				$properties
			);
		}
	}