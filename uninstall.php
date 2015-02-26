<?php

	//if uninstall not called from WordPress exit
	if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
		exit ();

	$option_name = 'gabfire_taxonomies_settings';
	$version_option_name = 'gabfire_custom_taxonomies_version';

	if (is_multisite()) {
		delete_site_option($option_name);
		delete_site_option($version_option_name);
	}else {
		delete_option($option_name);
		delete_option($version_option_name);
	}
?>