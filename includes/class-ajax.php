<?php

defined('ABSPATH') || exit();

class WP_Plugin_Boilerplate_Ajax{

	public function __construct() {
		add_action('wp_ajax_wp_plugin_boilerplate', [$this, 'wp_plugin_boilerplate']);
		add_action('wp_ajax_nopriv_wp_plugin_boilerplate', [$this, 'wp_plugin_boilerplate']);
	}

	public function wp_plugin_boilerplate(){
		//do the ajax stuffs
	}

}

new WP_Plugin_Boilerplate_Ajax();