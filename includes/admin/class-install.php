<?php

defined( 'ABSPATH' ) || exit;

/**
 * Class WP_Plugin_Boilerplate_Install
 * Do the activate stuffs
 */
class WP_Plugin_Boilerplate_Install {

	public static function init() {
		register_activation_hook( WP_PLUGIN_BOILERPLATE_FILE, [ __CLASS__, 'activate' ] );
		//register_deactivation_hook( WP_PLUGIN_BOILERPLATE_FILE, [ __CLASS__, 'deactivate' ] );
	}

	public static function activate() {
		$key = sanitize_key( wp_plugin_boilerplate()->name );
		update_option( $key . '_version', wp_plugin_boilerplate()->version );
		update_option( 'wp_plugin_boilerplate_flush_rewrite_rules', true );
		update_option( 'wp_plugin_boilerplate_install_date', current_time( 'timestamp' ) );
	}

}