<?php
/**
 * Admin Class.
 *
 * @package WP_Last_Login_Tracker
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Admin loader class.
 *
 * Responsible for:
 * - Loading admin files.
 * - Initializing admin modules.
 *
 * @since 1.0.0
 */
class WPLL_Admin {

	/**
	 * Admin menu.
	 *
	 * @var WPLL_Admin_Menu
	 */
	public $menu;

	/**
	 * Dashboard widget.
	 *
	 * @var WPLL_Dashboard_Widget
	 */
	public $dashboard_widget;

	/**
	 * Settings.
	 *
	 * @var WPLL_Settings
	 */
	public $settings;

	/**
	 * Inactive users page.
	 *
	 * @var WPLL_Inactive_Users_Page
	 */
	public $inactive_users_page;

	/**
	 * Export.
	 *
	 * @var WPLL_Export
	 */
	public $export;

	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->includes();

		$this->init_classes();
	}

	/**
	 * Include admin files.
	 *
	 * @return void
	 */
	private function includes() {

		require_once WPLL_PLUGIN_DIR . '/admin/wpll-admin-menu.php';

		require_once WPLL_PLUGIN_DIR . '/admin/wpll-dashboard-widget.php';

		require_once WPLL_PLUGIN_DIR . '/admin/wpll-settings.php';

		require_once WPLL_PLUGIN_DIR . '/admin/wpll-inactive-users-page.php';

		require_once WPLL_PLUGIN_DIR . '/admin/wpll-export.php';
	}

	/**
	 * Initialize admin classes.
	 *
	 * @return void
	 */
	private function init_classes() {

		$this->menu = new WPLL_Admin_Menu();

		$this->dashboard_widget = new WPLL_Dashboard_Widget();

		$this->settings = new WPLL_Settings();

		$this->inactive_users_page = new WPLL_Inactive_Users_Page();

		$this->export = new WPLL_Export();
	}
}