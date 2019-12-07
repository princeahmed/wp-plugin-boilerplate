<?php

defined( 'ABSPATH' ) || exit;

/**
 * Class WP_Plugin_Boilerplate_Install
 * Do the activate stuffs
 */
class WP_Plugin_Boilerplate_Install {

	public function __construct() {
		register_activation_hook( WP_PLUGIN_BOILERPLATE_FILE, [ $this, 'activate' ] );
		register_deactivation_hook( WP_PLUGIN_BOILERPLATE_FILE, [ $this, 'deactivate' ] );
	}

	public static function activate() {
		update_option( 'wp_plugin_boilerplate_flush_rewrite_rules', true );
		update_option( 'wp_plugin_boilerplate_install_date', current_time( 'timestamp' ) );
	}

}

new WP_Plugin_Boilerplate_Install();