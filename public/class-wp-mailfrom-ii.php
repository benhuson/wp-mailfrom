<?php

/**
 * WP MailFrom II Class
 *
 * This class should be used to work with the
 * public-facing side of the WordPress site.
 */
class WP_MailFrom_II {

	/**
	 * Plugin version, used for cache-busting of style and script file references and db upgrades.
	 *
	 * @since  1.1
	 *
	 * @var    string
	 */
	const VERSION = '1.1';

	/**
	 * Unique identifier for your plugin.
	 *
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * plugin file.
	 *
	 * @since  1.1
	 *
	 * @var    string
	 */
	protected $plugin_slug = 'wp-mailfrom-ii';

	/**
	 * Instance of this class.
	 *
	 * @since  1.1
	 *
	 * @var    object
	 */
	protected static $instance = null;

	/**
	 * Constructor
	 */
	private function __construct() {
		add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );
		
		// Name and email filter
		add_filter( 'wp_mail_from_name', array( $this, 'wp_mail_from_name' ), 100 );
		add_filter( 'wp_mail_from', array( $this, 'wp_mail_from' ), 100 );
		
		// Legacy support for old options - just in case someone used this directly!
		// (not really needed unless we can takeover the old plugin)
		//add_filter( 'pre_option_site_mail_from_name', 'get_option_site_mail_from_name', 1 );
		//add_filter( 'pre_option_site_mail_from_email', 'get_option_site_mail_from_email', 1 );
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
	 * Return the plugin slug.
	 *
	 * @since   1.1
	 *
	 * @return  Plugin slug variable.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

	/**
	 * Load Text Domain Language Support
	 */
	public function load_plugin_textdomain() {
		$plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_slug . '.php' );
		load_plugin_textdomain( $this->plugin_slug, false, dirname( $plugin_basename ) . '/languages/' );
	}
	
	/**
	 * Filter: wp_mail_from_name
	 *
	 * @param string $name Default name.
	 * @return string $name WP Mail From name.
	 */
	public function wp_mail_from_name( $name ) {
		$wp_mailfrom_ii_name = get_option( 'wp_mailfrom_ii_name', '' );
		if ( ! empty( $wp_mailfrom_ii_name ) && ! $this->is_default_from_name( $wp_mailfrom_ii_name ) ) {
			return $wp_mailfrom_ii_name;
		}
		return $name;
	}
	
	/**
	 * Filter: wp_mail_from
	 *
	 * @param string $name Default email.
	 * @return string $name WP Mail From email.
	 */
	public function wp_mail_from( $email ) {
		$wp_mailfrom_ii_email = get_option( 'wp_mailfrom_ii_email', '' );
		if ( ! empty( $wp_mailfrom_ii_email ) && ! $this->is_default_from( $wp_mailfrom_ii_email ) && ! $this->is_admin_from( $wp_mailfrom_ii_email ) ) {
			return $wp_mailfrom_ii_email;
		}
		return $email;
	}

	/**
	 * Is Default From Name
	 *
	 * Checks to see if the name is the default name assigned by WordPress.
	 * This is defined in wp_mail() in wp-includes/pluggable.php
	 *
	 * @param   string   $name  Name to check.
	 * @return  boolean
	 */
	public function is_default_from_name( $name ) {
		if ( $name == 'WordPress' )
			return true;
		return false;
	}

	/**
	 * Is Default From Email
	 *
	 * Checks to see if the email is the default address assigned by WordPress.
	 * This is defined in wp_mail() in wp-includes/pluggable.php
	 *
	 * Also note, some hosts may refuse to relay mail from an unknown domain. See
	 * http://trac.wordpress.org/ticket/5007
	 *
	 * @param   string   $email  Email to check.
	 * @return  boolean
	 */
	public function is_default_from( $email ) {

		// Get the default from email address
		$sitename = strtolower( $_SERVER['SERVER_NAME'] );
		if ( substr( $sitename, 0, 4 ) == 'www.' ) {
			$sitename = substr( $sitename, 4 );
		}
		$default_email = 'wordpress@' . $sitename;

		if ( $email == $default_email )
			return true;
		return false;
	}

	/**
	 * Is Admin From Email
	 *
	 * Checks to see if the email is the admin email address set in the WordPress options.
	 *
	 * Also note, some hosts may refuse to relay mail from an unknown domain. See
	 * http://trac.wordpress.org/ticket/5007
	 *
	 * @param   string   $email  Email to check.
	 * @return  boolean
	 */
	public function is_admin_from( $email ) {
		if ( $email == $admin_email )
			return true;
		return false;
	}
	
	/**
	 * Legacy support for get_option( 'site_mail_from_name' )
	 */
	public function get_option_site_mail_from_name( $option, $default = false ) {
		return get_option( 'wp_mailfrom_ii_name', $default );
	}
	
	/**
	 * Legacy support for get_option( 'site_mail_from_email' )
	 */
	public function get_option_site_mail_from_email( $option, $default = false ) {
		return get_option( 'wp_mailfrom_ii_email', $default );
	}
	
	/**
	 * Register Activation
	 * Perform upgrades etc.
	 */
	public static function activate() {
		
		// Temporarily remove our filter which provide support for legacy options
		// (is only really needed if we can takeover the old plugin, but leave in for now)
		remove_filter( 'pre_option_site_mail_from_name', 'get_option_site_mail_from_name', 1 );
		remove_filter( 'pre_option_site_mail_from_email', 'get_option_site_mail_from_email', 1 );
		
		// Get old option value and try to assign them to new options
		$name = get_option( 'site_mail_from_name', '' );
		$email = get_option( 'site_mail_from_email', '' );
		$new_name = get_option( 'wp_mailfrom_ii_name', '' );
		$new_email = get_option( 'wp_mailfrom_ii_email', '' );
		if ( ! empty( $name ) && empty( $new_name ) )
			$name_updated = add_option( 'wp_mailfrom_ii_name', $name );
		if ( ! empty( $email ) && empty( $new_email ) )
			$email_updated = add_option( 'wp_mailfrom_ii_email', $email );
		
		// If new options created delete old options
		// (don't do this at the moment, only if we can takeover the old plugin)
		/*
		if ( $name_updated )
			delete_option( 'site_mail_from_name' );
		if ( $email_updated )
			delete_option( 'site_mail_from_email' );
		*/
	}
	
}