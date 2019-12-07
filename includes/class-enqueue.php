<?php

defined( 'ABSPATH' ) || exit();

class WP_Plugin_Boilerplate_Enqueue {

	function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'frontend_scripts' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_scripts' ] );
	}

	function frontend_scripts() {

	}

	function admin_scripts() {
		wp_enqueue_style( 'wp-plugin-boilerplate', WP_PLUGIN_BOILERPLATE_ASSETS . '/css/admin.min.css', [], WP_PLUGIN_BOILERPLATE_VERSION );

		wp_enqueue_script( 'wp-plugin-boilerplate', WP_PLUGIN_BOILERPLATE_ASSETS . '/js/admin.min.js', [ 'jquery' ], WP_PLUGIN_BOILERPLATE_VERSION, true );

		/* Create localized JS array */
		$localized_array = [
			'nonce' => wp_create_nonce('wp_plugin_boilerplate'),
			'i18n' => [
				'' => '',
			]
		];

		wp_localize_script( 'wp-plugin-boilerplate', 'wpPluginBoilerplate', $localized_array );

	}

}

new WP_Plugin_Boilerplate_Enqueue();