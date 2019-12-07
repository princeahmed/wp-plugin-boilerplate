<?php

defined( 'ABSPATH' ) || exit();

class WP_Plugin_Boilerplate_CPT {

	/**
	 * Post_Types constructor.
	 */
	function __construct() {
		add_action( 'init', [ $this, 'register_post_types' ] );
		add_action( 'init', [ $this, 'register_taxonomies' ] );
		add_action( 'init', [ $this, 'flush_rewrite_rules' ], 99 );
	}

	/**
	 * register custom post types
	 *
	 * @since 1.0.0
	 */
	function register_post_types() {
		register_post_type( 'wp_plugin_boilerplate', array(
			'labels'        => $this::get_posts_labels( __( 'WP Plugin Boilerplates', 'wp-plugin-boilerplate' ), __( 'WP Plugin Boilerplate', 'wp-plugin-boilerplate' ), __( 'WP Plugin Boilerplate', 'wp-plugin-boilerplate' ) ),
			'supports'      => [ 'title', 'editor', 'thumbnail' ],
			'public'        => true,
			'menu_position' => 5,
			'menu_icon'     => 'format-post',
			'has_archive'   => true,
			'rewrite'       => [ 'slug' => apply_filters( 'wp_radio_radios_slug', 'station' ) ],
		) );
	}

	/**
	 * Register custom taxonomies
	 *
	 * @since 1.0.0
	 */
	public function register_taxonomies() {
		register_taxonomy( 'wp_plugin_boilerplate_category', [ 'wp_plugin_boilerplate' ], array(
			'hierarchical'      => true,
			'labels'            => $this::get_taxonomy_label( __( 'Categories', 'wp-plugin-boilerplate' ), __( 'Category', 'wp-plugin-boilerplate' ), __( 'Categories', 'wp-plugin-boilerplate' ) ),
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => [ 'slug' => 'wp_plugin_boilerplate_category' ],
		) );

		register_taxonomy( 'wp_plugin_boilerplate_tag', ['wp_plugin_boilerplate'] , array(
			'hierarchical'      => false,
			'labels'            => $this::get_taxonomy_label( __( 'Tags', 'wp-plugin-boilerplate' ), __( 'Tag', 'wp-plugin-boilerplate' ), __( 'Tags', 'wp-plugin-boilerplate' ) ),
			'show_ui'           => true,
			'show_admin_column' => true,
			'rewrite'           => [ 'slug' => 'wp_plugin_boilerplate_tag' ],
		) );

	}

	/**
	 * Get all labels from post types
	 *
	 * @param $menu_name
	 * @param $singular
	 * @param $plural
	 *
	 * @return array
	 * @since 1.0.0
	 */
	protected static function get_posts_labels( $menu_name, $singular, $plural, $type = 'plural' ) {
		$labels = array(
			'name'               => 'plural' == $type ? $plural : $singular,
			'all_items'          => sprintf( __( "All %s", 'wp-plugin-boilerplate' ), $plural ),
			'singular_name'      => $singular,
			'add_new'            => sprintf( __( 'Add New %s', 'wp-plugin-boilerplate' ), $singular ),
			'add_new_item'       => sprintf( __( 'Add New %s', 'wp-plugin-boilerplate' ), $singular ),
			'edit_item'          => sprintf( __( 'Edit %s', 'wp-plugin-boilerplate' ), $singular ),
			'new_item'           => sprintf( __( 'New %s', 'wp-plugin-boilerplate' ), $singular ),
			'view_item'          => sprintf( __( 'View %s', 'wp-plugin-boilerplate' ), $singular ),
			'search_items'       => sprintf( __( 'Search %s', 'wp-plugin-boilerplate' ), $plural ),
			'not_found'          => sprintf( __( 'No %s found', 'wp-plugin-boilerplate' ), $plural ),
			'not_found_in_trash' => sprintf( __( 'No %s found in Trash', 'wp-plugin-boilerplate' ), $plural ),
			'parent_item_colon'  => sprintf( __( 'Parent %s:', 'wp-plugin-boilerplate' ), $singular ),
			'menu_name'          => $menu_name,
		);

		return $labels;
	}

	/**
	 * Get all labels from taxonomies
	 *
	 * @param $menu_name
	 * @param $singular
	 * @param $plural
	 *
	 * @return array
	 * @since 1.0.0
	 */
	protected static function get_taxonomy_label( $menu_name, $singular, $plural ) {
		$labels = array(
			'name'              => sprintf( _x( '%s', 'taxonomy general name', 'wp-plugin-boilerplate' ), $plural ),
			'singular_name'     => sprintf( _x( '%s', 'taxonomy singular name', 'wp-plugin-boilerplate' ), $singular ),
			'search_items'      => sprintf( __( 'Search %', 'wp-plugin-boilerplate' ), $plural ),
			'all_items'         => sprintf( __( 'All %s', 'wp-plugin-boilerplate' ), $plural ),
			'parent_item'       => sprintf( __( 'Parent %s', 'wp-plugin-boilerplate' ), $singular ),
			'parent_item_colon' => sprintf( __( 'Parent %s:', 'wp-plugin-boilerplate' ), $singular ),
			'edit_item'         => sprintf( __( 'Edit %s', 'wp-plugin-boilerplate' ), $singular ),
			'update_item'       => sprintf( __( 'Update %s', 'wp-plugin-boilerplate' ), $singular ),
			'add_new_item'      => sprintf( __( 'Add New %s', 'wp-plugin-boilerplate' ), $singular ),
			'new_item_name'     => sprintf( __( 'New % Name', 'wp-plugin-boilerplate' ), $singular ),
			'menu_name'         => __( $menu_name, 'wp-plugin-boilerplate' ),
		);

		return $labels;
	}

	/**
	 * Flash The Rewrite Rules
	 *
	 * @since 2.0.2
	 */
	function flush_rewrite_rules() {
		if ( get_option( 'wp_plugin_boilerplate_flush_rewrite_rules' ) ) {
			flush_rewrite_rules();
			delete_option( 'wp_plugin_boilerplate_flush_rewrite_rules' );
		}
	}
}

new WP_Plugin_Boilerplate_CPT();