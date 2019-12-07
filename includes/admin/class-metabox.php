<?php

defined( 'ABSPATH' ) || exit;

class WP_Plugin_Boilerplate_Metabox {

	function __construct() {
		add_action( 'add_meta_boxes', [ $this, 'register_meta_boxes' ] );
		add_action( 'admin_init', array( $this, 'setting_meta_boxes' ) );
	}

	function register_meta_boxes() {
		add_meta_box( 'wp_plugin_boilerplate_metabox', __( 'WP Plugin Boilerplate', 'wp-plugin-boilerplate' ), [
			$this,
			'wp_plugin_boilerplate_metabox'
		], 'wp_plugin_boilerplate', 'normal', 'default' );
	}

	function setting_meta_boxes() {

		$metaboxes = [];

		$metaboxes['wp_popup_settings_metabox'] = array(
			'id'       => 'wp_popup_settings_metabox',
			'title'    => __( 'Popup Settings', 'wp-plugin-boilerplate' ),
			'pages'    => [ 'wp_plugin_boilerplate' ],
			'context'  => 'normal',
			'priority' => 'default',
			'fields'   => [
				[
					'id'    => 'wp_plugin_boilerplate_tab',
					'label' => __( 'WP Plugin Boilerplate Tab', 'wp-plugin-boilerplate' ),
					'type'  => 'tab',
				],
				[
					'id'    => 'wp_plugin_boilerplate',
					'label' => __( 'WP Plugin Boilerplate', 'wp-plugin-boilerplate' ),
					'desc'  => __( 'Awesome Framework for developing WordPress Plugin.', 'wp-plugin-boilerplate' ),
					'type'  => 'radio_image'
				],
			]
		);

		if ( function_exists( 'prince_register_meta_box' ) ) {
			foreach ( $metaboxes as $metabox ) {
				prince_register_meta_box( $metabox );
			}
		}

	}

	function wp_plugin_boilerplate_metabox() {
		include WP_PLUGIN_BOILERPLATE_INCLUDES . '/admin/views/metabox/wp-plugin-boilerplate-metabox.php';
	}


}

new WP_Plugin_Boilerplate_Metabox();