<?php
	$extra_styles			= $module->get_setting('extra_styles');
	$extra_styles_data		= $extra_styles->get_data();

	if($extra_styles_data && is_array($extra_styles_data) && count($extra_styles_data) > 0) {
		// loop through saved group setting values
		foreach($extra_styles_data as $extra_style) {
			if($extra_style) {
				$properties				= array();

				$fields					= array('padding','margin','border','custom_css');

				// retrieve saved data
				foreach($extra_style as $ID => $data){
					// only for group fields needed (no label or ID fields are used for output)
					if(in_array($ID,$fields)) {
						// create a new setting object and clone it to avoid cross-interferences with more than one setting group items
						$temp = clone $module->get_setting('temp_'.$ID);

						// define temporary setting and create properties
						if($ID == 'padding'){
							$temp
								->set_is_responsive(true)
								->load_type( 'margin' )
								->set_data($data);

							$properties		= array_merge($properties, $temp->get_css_data($ID));
						}elseif($ID == 'margin'){
							$temp
								->set_is_responsive(true)
								->load_type( 'margin' )
								->set_data($data);

							$properties		= array_merge($properties, $temp->get_css_data());
						}elseif($ID == 'border'){
							$temp
								->set_is_responsive(true)
								->load_type( 'border' )
								->set_data($data);

							$properties		= array_merge($properties, $temp->get_css_data());
						}elseif($ID == 'custom_css'){
							$temp
								->set_is_responsive(true)
								->load_type( 'textarea' )
								->set_data($data);

							echo $temp->wrap_media_queries();
						}
					}
				}
				echo $_s->build_css(
					is_admin() ? '.editor-styles-wrapper .wp-block-group.is-style-' . $extra_style['slug'] : '.wp-block-group.is-style-' . $extra_style['slug'],
					$properties
				);
			}
		}
	}