<?php
/**
 * Plugin Name: WP Last Login Tracker
 * Plugin URI: https://wordpress.org/plugins/last-login-tracker/
 * Description: Track user last login date, login IP address, inactive users and activity reports.
 * Version: 1.0.0
 * Author: Rita Kikani
 * License: GPL v2 or later
 * Text Domain: last-login-tracker
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main plugin class.
 *
 * Responsible for:
 * - Defining plugin constants.
 * - Loading required files.
 * - Initializing plugin modules.
 * - Registering activation hooks.
 *
 * @since 1.0.0
 */
class WPLL_Plugin {

	/**
	 * Plugin instance.
	 *
	 * @var self|null
	 */
	private static $_instance = null;

	/**
	 * Login tracker module.
	 *
	 * @var WPLL_Login_Tracker
	 */
	public $login_tracker;

	/**
	 * User columns module.
	 *
	 * @var WPLL_User_Columns
	 */
	public $user_columns;

	/**
	 * User profile module.
	 *
	 * @var WPLL_User_Profile
	 */
	public $user_profile;

	/**
	 * User filters module.
	 *
	 * @var WPLL_User_Filters
	 */
	public $user_filters;

	/**
	 * REST controller module.
	 *
	 * @var WPLL_REST_Controller
	 */
	public $rest_controller;

	/**
	 * Admin module.
	 *
	 * @var WPLL_Admin
	 */
	public $admin;

	/**
	 * Get plugin instance.
	 *
	 * Ensures only one instance of the plugin is loaded.
	 *
	 * @since 1.0.0
	 *
	 * @return self
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Constructor.
	 *
	 * Load plugin dependencies and initialize modules.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		$this->define_constants();

		$this->includes();

		$this->init_classes();

		$this->hooks();
	}

	/**
	 * Register plugin hooks.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function hooks() {

		register_activation_hook(
			__FILE__,
			array( $this, 'activate' )
		);

		add_action(
			'plugins_loaded',
			array( $this, 'load_textdomain' )
		);
	}

	/**
	 * Define plugin constants.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function define_constants() {

		if ( ! defined( 'WPLL_VERSION' ) ) {
			define( 'WPLL_VERSION', '1.0.0' );
		}

		if ( ! defined( 'WPLL_PLUGIN_FILE' ) ) {
			define( 'WPLL_PLUGIN_FILE', __FILE__ );
		}

		if ( ! defined( 'WPLL_PLUGIN_DIR' ) ) {
			define(
				'WPLL_PLUGIN_DIR',
				untrailingslashit(
					plugin_dir_path( __FILE__ )
				)
			);
		}

		if ( ! defined( 'WPLL_PLUGIN_URL' ) ) {
			define(
				'WPLL_PLUGIN_URL',
				untrailingslashit(
					plugin_dir_url( __FILE__ )
				)
			);
		}
	}

	/**
	 * Include required files.
	 *
	 * Keeping all includes in a single method
	 * makes maintenance easier.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function includes() {

		require_once WPLL_PLUGIN_DIR . '/includes/wpll-activator.php';
		require_once WPLL_PLUGIN_DIR . '/includes/wpll-helper.php';
		require_once WPLL_PLUGIN_DIR . '/includes/wpll-login-tracker.php';
		require_once WPLL_PLUGIN_DIR . '/includes/wpll-user-columns.php';
		require_once WPLL_PLUGIN_DIR . '/includes/wpll-user-profile.php';
		require_once WPLL_PLUGIN_DIR . '/includes/wpll-user-filters.php';
		require_once WPLL_PLUGIN_DIR . '/includes/wpll-rest-controller.php';

		if ( is_admin() ) {
			require_once WPLL_PLUGIN_DIR . '/admin/wpll-admin.php';
		}
	}
	/**
	 * Initialize plugin classes.
	 *
	 * Each module is responsible for registering
	 * its own actions and filters.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function init_classes() {

		$this->login_tracker = new WPLL_Login_Tracker();
		$this->user_columns = new WPLL_User_Columns();
		$this->user_profile = new WPLL_User_Profile();
		$this->user_filters = new WPLL_User_Filters();
		$this->rest_controller = new WPLL_REST_Controller();

		if ( is_admin() ) {
			$this->admin = new WPLL_Admin();
		}
	}
	/**
	 * Plugin activation callback.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function activate() {

		WPLL_Activator::activate();
	}

	/**
	 * Load plugin translations.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function load_textdomain() {

		load_plugin_textdomain(
			'last-login-tracker',
			false,
			dirname(
				plugin_basename(
					__FILE__
				)
			) . '/languages'
		);
	}
}

/**
 * Main plugin instance.
 *
 * Similar to WPEM() in WP Event Manager.
 *
 * @since 1.0.0
 *
 * @return WPLL_Plugin
 */
function WPLL() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid

	return WPLL_Plugin::instance();
}

/**
 * Global plugin object.
 */
$GLOBALS['wpll'] = WPLL();