<?php

	// Section Visibility
	$properties						= array();
	$section_dynamic_visibility		= array_map(function ($val) { return $val ? '0' : '100%'; }, $module->get_setting('section_dynamic_visibility')->get_data());
	$properties['max-height']		= $module->get_setting('section_dynamic_visibility')->prepare_css_property_responsive($section_dynamic_visibility);
	$section_dynamic_visibility		= array_map(function ($val) { return $val ? '0' : '1'; }, $module->get_setting('section_dynamic_visibility')->get_data());
	$properties['transform']		= $module->get_setting('section_dynamic_visibility')->prepare_css_property_responsive($section_dynamic_visibility, 'scaleY(', ')');
	$section_dynamic_visibility		= array_map(function ($val) { return $val ? '0' : '100%'; }, $module->get_setting('section_dynamic_visibility')->get_data());
	$properties['height']			= $module->get_setting('section_dynamic_visibility')->prepare_css_property_responsive($section_dynamic_visibility);
	$section_dynamic_visibility		= array_map(function ($val) { return $val ? 'hidden' : 'visible'; }, $module->get_setting('section_dynamic_visibility')->get_data());
	$properties['overflow']			= $module->get_setting('section_dynamic_visibility')->prepare_css_property_responsive($section_dynamic_visibility);
	$section_dynamic_visibility		= array_map(function ($val) { return $val ? '0' : '1'; }, $module->get_setting('section_dynamic_visibility')->get_data());
	$properties['opacity']			= $module->get_setting('section_dynamic_visibility')->prepare_css_property_responsive($section_dynamic_visibility);

	echo $_s->build_css(
		is_admin() ?
			''
			// no admin styles wanted here
			//'.editor-styles-wrapper section.wp-block-group:not(:first-of-type):not(.section_active), '. // Default Section Visibility State per Responsive Setting
			//'.editor-styles-wrapper section.wp-block-group.section_not_active' // Default Section Not Visibility State when not active Class is added
			:
			'section.wp-block-group:not(.section_active), '. // Default Section Visibility State per Responsive Setting
			'section.wp-block-group.section_not_active', // Default Section Not Visibility State when not active Class is added
		array_merge(
			$properties
		)
	);

	// sticky style
	echo $_s->build_css(
		is_admin() ? '.editor-styles-wrapper .wp-block-group.is-style-sticky' : '.wp-block-group.is-style-sticky',
		array_merge(
			$module->get_setting('sticky_offset')->get_css_data('top', '', 'px')
		)
	);

	// common
	echo $_s->build_css(
		is_admin() ? '.editor-styles-wrapper .wp-block-group' : '.wp-block-group',
		array_merge(
			$module->get_setting('padding')->get_css_data('padding'),
			$module->get_setting('margin')->get_css_data(),
			$module->get_setting('border')->get_css_data()
		)
	);

	echo $_s->build_css(
		is_admin() ? '.editor-styles-wrapper .wp-block-group.has-background' : '.wp-block-group.has-background',
		array_merge(
			$module->get_setting('bg_padding')->get_css_data('padding')
		)
	);

	echo $module->get_setting('custom_css')->wrap_media_queries();