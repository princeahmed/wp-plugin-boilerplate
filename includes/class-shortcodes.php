<?php

defined('ABSPATH') || exit();

class WP_Plugin_Boilerplate_Shortcodes{

	public function __construct() {
		add_shortcode('wp_plugin_boilerplate', [$this, 'wp_plugin_boilerplate']);
	}

	public function wp_plugin_boilerplate(){
		//include shortcode template file
	}

}

new WP_Plugin_Boilerplate_Shortcodes();