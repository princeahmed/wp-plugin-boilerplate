<?php

/**
 * Plugin Name: WP Plugin Boilerplate
 * Plugin URI:  https://princeboss.com
 * Description: Make WordPress plugin Quickly.
 * Version:     1.0.0
 * Author:      Prince
 * Author URI:  http://princeboss.com
 * Text Domain: wp-plugin-boilerplate
 * Domain Path: /languages/
 */

defined( 'ABSPATH' ) || exit();


/**
 * Main initiation class
 *
 * @since 1.0.0
 */
final class WP_Plugin_Boilerplate {

	public $version = '1.0.0';

	public $min_php = '5.6.0';

	public $name = 'WP Plugin Boilerplate';

	protected static $instance = null;

	public function __construct() {

		if ( $this->check_environment() ) {
			$this->define_constants();
			$this->includes();
			$this->init_hooks();
			do_action( 'wp_plugin_boilerplate_loaded' );
		}

	}

	function check_environment() {

		$return = true;

		if ( version_compare( PHP_VERSION, $this->min_php, '<=' ) ) {
			$return = false;

			$notice = sprintf(
			/* translators: %s: Min PHP version */
				esc_html__( 'Unsupported PHP version Min required PHP Version: "%s"', 'wp-radio-updater' ),
				$this->min_php
			);
		}

		if ( ! $return ) {
		    // Add notice and deactivate the plugin
			add_action( 'admin_notices', function () use ( $notice ) { ?>
                <div class="notice is-dismissible notice-error">
                    <p><?php echo $notice; ?></p>
                </div>
			<?php } );

			if ( ! function_exists( 'deactivate_plugins' ) ) {
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			}

			deactivate_plugins( plugin_basename( __FILE__ ) );
		}

		return $return;

	}

	function define_constants() {
		define( 'WP_PLUGIN_BOILERPLATE_VERSION', $this->version );
		define( 'WP_PLUGIN_BOILERPLATE_FILE', __FILE__ );
		define( 'WP_PLUGIN_BOILERPLATE_PATH', dirname( WP_PLUGIN_BOILERPLATE_FILE ) );
		define( 'WP_PLUGIN_BOILERPLATE_INCLUDES', WP_PLUGIN_BOILERPLATE_PATH . '/includes' );
		define( 'WP_PLUGIN_BOILERPLATE_URL', plugins_url( '', WP_PLUGIN_BOILERPLATE_FILE ) );
		define( 'WP_PLUGIN_BOILERPLATE_ASSETS', WP_PLUGIN_BOILERPLATE_URL . '/assets' );
		define( 'WP_PLUGIN_BOILERPLATE_TEMPLATES', WP_PLUGIN_BOILERPLATE_PATH . '/templates' );
	}

	function includes() {

		/* core includes */
		include_once WP_PLUGIN_BOILERPLATE_INCLUDES . '/class-cpt.php';
		include_once WP_PLUGIN_BOILERPLATE_INCLUDES . '/class-shortcodes.php';
		include_once WP_PLUGIN_BOILERPLATE_INCLUDES . '/class-enqueue.php';
		include_once WP_PLUGIN_BOILERPLATE_INCLUDES . '/class-ajax.php';
		include_once WP_PLUGIN_BOILERPLATE_INCLUDES . '/functions.php';
		include_once WP_PLUGIN_BOILERPLATE_INCLUDES . '/prince-settings/prince-loader.php';

		/* admin includes */
		if(is_admin()){
			include_once WP_PLUGIN_BOILERPLATE_INCLUDES . '/admin/class-admin.php';
			include_once WP_PLUGIN_BOILERPLATE_INCLUDES . '/admin/class-install.php';
			include_once WP_PLUGIN_BOILERPLATE_INCLUDES . '/admin/class-metabox.php';
			include_once WP_PLUGIN_BOILERPLATE_INCLUDES . '/admin/class-ajax.php';
		}

	}

	function init_hooks() {

		/* Localize our plugin */
		add_action( 'init', [ $this, 'localization_setup' ] );

		/* action_links */
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), [ $this, 'plugin_action_links' ] );

	}

	function localization_setup() {
		load_plugin_textdomain( 'wp-plugin-boilerplate', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	function plugin_action_links( $links ) {
		$links[] = '<a href="' . admin_url( 'edit.php?post_type=post_type&page=settings' ) . '">' . __( 'Settings', 'wp-plugin-boilerplate' ) . '</a>';

		return $links;
	}

	static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

}

function wp_plugin_boilerplate() {
	return WP_Plugin_Boilerplate::instance();
}

wp_plugin_boilerplate();
