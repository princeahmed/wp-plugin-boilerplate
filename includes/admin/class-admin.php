<?php

defined( 'ABSPATH' ) || exit();

class WP_Plugin_Boilerplate_Admin {

	public function __construct() {
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue' ] );

	}

	function enqueue( $hook ) {

		wp_enqueue_style( 'wp-plugin-boilerplate-admin', WP_RADIO_ASSETS_URL . '/css/admin.min.css', false, WP_RADIO_VERSION );

		wp_enqueue_script( 'wp-plugin-boilerplate-admin', WP_RADIO_ASSETS_URL . '/js/admin.min.js', [ 'jquery', 'wp-util' ], WP_RADIO_VERSION, true );

		$localize_array = [
			'nonce' => '',
			'i18n'  => [
				'' => '',
			]
		];

		wp_localize_script( 'wp-plugin-boilerplate-admin', 'wpPluginBoilerplate', $localize_array );

	}

}

new WP_Plugin_Boilerplate_Admin();