<?php

/**
 * WP MailFrom II Admin Class
 *
 * This class is used to work with the
 * administrative side of the WordPress site.
 */
class WP_MailFrom_II_Admin {

	/**
	 * Instance of this class.
	 *
	 * @since    1.1
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.1
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since     1.1
	 */
	private function __construct() {

		/**
		 * Call $plugin_slug from public plugin class.
		 */
		$plugin = WP_MailFrom_II::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();

		// Add the options page and menu item.
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );

		// Register settings fields
		add_action( 'admin_init', array( $this, 'settings' ) );

		// Add an action link pointing to the options page.
		$plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_slug . '.php' );
		add_filter( 'plugin_action_links_' . $plugin_basename, array( $this, 'add_action_links' ) );

	}

	/**
	 * Return an instance of this class.
	 *
	 * @since   1.1
	 *
	 * @return  object  A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Register the administration menu.
	 *
	 * @since  1.1
	 */
	public function add_plugin_admin_menu() {

		/*
		 * Add a settings page to the Settings menu.
		 */
		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'WP Mail From Plugin', $this->plugin_slug ),
			__( 'Mail From', $this->plugin_slug ),
			'manage_options',
			$this->plugin_slug,
			array( $this, 'display_plugin_admin_page' )
		);

	}

	/**
	 * Render the settings page.
	 *
	 * @since  1.1
	 */
	public function display_plugin_admin_page() {
		include_once( 'views/admin.php' );
	}
	
	/**
	 * Settings API
	 */
	public function settings() {
		add_settings_section(
			'wp_mailfrom_ii',
			'',
			array( $this, 'settings_section' ),
			'wp_mailfrom_ii'
		);
		add_settings_field(
			'wp_mailfrom_ii_name',
			__( 'From Name', $this->plugin_slug ),
			array( $this, 'wp_mailfrom_ii_name_field' ),
			'wp_mailfrom_ii',
			'wp_mailfrom_ii'
		);
		add_settings_field(
			'wp_mailfrom_ii_email',
			__( 'From Email Address', $this->plugin_slug ),
			array( $this, 'wp_mailfrom_ii_email_field' ),
			'wp_mailfrom_ii',
			'wp_mailfrom_ii'
		);
 		register_setting( 'wp_mailfrom_ii', 'wp_mailfrom_ii_name', array( $this, 'sanitize_wp_mailfrom_ii_name' ) );
 		register_setting( 'wp_mailfrom_ii', 'wp_mailfrom_ii_email', 'is_email' );
	}

	/**
	 * Sanitize Mail From Name
	 * Strips out all HTML, scripts...
	 *
	 * @param string $val Name.
	 * @return string Sanitized name.
	 */
	public function sanitize_wp_mailfrom_ii_name( $val ) {
		return wp_kses( $val, array() );
	}

	/**
	 * Mail From Settings Section
	 */
	public function settings_section() {
		echo '<p>' . __( 'If set, these 2 options will override the name and email address in the <strong>From:</strong> header on all sent emails.', $this->plugin_slug ) . '</p>';
	}

	/**
	 * Mail From Name Field
	 */
	public function wp_mailfrom_ii_name_field() {
		echo '<input name="wp_mailfrom_ii_name" type="text" id="wp_mailfrom_ii_name" value="' . get_option( 'wp_mailfrom_ii_name', '' ) . '" class="regular-text" />';
	}

	/**
	 * Mail From Email Field
	 */
	public function wp_mailfrom_ii_email_field() {
		echo '<input name="wp_mailfrom_ii_email" type="text" id="wp_mailfrom_ii_email" value="' . get_option( 'wp_mailfrom_ii_email', '' ) . '" class="regular-text" />';
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since  1.1
	 */
	public function add_action_links( $links ) {

		return array_merge(
			array(
				'settings' => '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_slug ) . '">' . __( 'Settings', $this->plugin_slug ) . '</a>'
			),
			$links
		);

	}

}
