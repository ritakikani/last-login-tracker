class WPLL_Plugin {

	public $login_tracker;
	public $user_columns;
	public $user_profile;
	public $user_filters;
	public $rest_controller;
	public $admin;

	private static $_instance = null;

	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function __construct() {

		$this->define_constants();

		$this->includes();

		$this->init_classes();

		$this->hooks();
	}

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

	private function init_classes() {

		$this->login_tracker  = new WPLL_Login_Tracker();
		$this->user_columns   = new WPLL_User_Columns();
		$this->user_profile   = new WPLL_User_Profile();
		$this->user_filters   = new WPLL_User_Filters();
		$this->rest_controller = new WPLL_REST_Controller();

		if ( is_admin() ) {
			$this->admin = new WPLL_Admin();
		}
	}

	private function hooks() {

		register_activation_hook(
			WPLL_PLUGIN_FILE,
			array( $this, 'activate' )
		);

		add_action(
			'plugins_loaded',
			array( $this, 'load_textdomain' )
		);
	}

	public function activate() {

		WPLL_Activator::activate();
	}

	public function load_textdomain() {

		load_plugin_textdomain(
			'last-login-tracker',
			false,
			dirname( plugin_basename( WPLL_PLUGIN_FILE ) ) . '/languages'
		);
	}
}