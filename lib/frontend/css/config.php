<?php
	// ##### SETTINGS #####

	// Fetches all settings and creates new variables with the setting ID as name and setting data as value.
	// This reduces the lines of code for the needed setting values.
	foreach ( $script->get_parent()->get_settings() as $setting ) {
		if ( $setting->get_type() !== false ) {
			${ $setting->get_ID() } = $setting->get_data();
		}
	}

	require($script->get_parent()->get_path( 'lib/frontend/css/config/general.php' ));
	require($script->get_parent()->get_path( 'lib/frontend/css/config/extra_styles.php' ));