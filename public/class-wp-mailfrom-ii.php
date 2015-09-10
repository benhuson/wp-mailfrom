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
	 *
	 * @since  1.1
	 */
	private function __construct() {
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Name and email filter
		add_filter( 'wp_mail_from_name', array( $this, 'wp_mail_from_name' ), 100 );
		add_filter( 'wp_mail_from', array( $this, 'wp_mail_from' ), 100 );
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
	 *
	 * @since  1.1
	 */
	public function load_plugin_textdomain() {
		$plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_slug . '.php' );
		load_plugin_textdomain( $this->plugin_slug, false, dirname( $plugin_basename ) . '/languages/' );
	}

	/**
	 * Filter: wp_mail_from_name
	 *
	 * @since   1.1
	 *
	 * @param   string  $name  Default name.
	 * @return  string         WP Mail From name.
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
	 * @since   1.1
	 *
	 * @param   string $name  Default email.
	 * @return  string        WP Mail From email.
	 */
	public function wp_mail_from( $email ) {
		$wp_mailfrom_ii_email = get_option( 'wp_mailfrom_ii_email', '' );
		if ( ! empty( $wp_mailfrom_ii_email ) ) {
			$override_default = get_option( 'wp_mailfrom_ii_override_default', 0 );
			$override_admin = get_option( 'wp_mailfrom_ii_override_admin', 0 );

			if ( $override_default == 1 && $this->is_default_from( $email ) ) {
				return $email;
			}
			if ( $override_admin == 1 && $this->is_admin_from( $email ) ) {
				return $email;
			}
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
	 * @since   1.1
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
	 * @since   1.1
	 *
	 * @param   string   $email  Email to check.
	 * @return  boolean
	 */
	public function is_default_from( $email ) {
		$default_email = $this->get_default_from();
		if ( $email == $default_email )
			return true;
		return false;
	}

	/**
	 * Get Default From Email
	 *
	 * Checks to see if the email is the default address assigned by WordPress.
	 * This is defined in wp_mail() in wp-includes/pluggable.php
	 *
	 * Also note, some hosts may refuse to relay mail from an unknown domain. See
	 * http://trac.wordpress.org/ticket/5007
	 *
	 * @since   1.1
	 *
	 * @return  string  Default from email.
	 */
	public function get_default_from() {

		global $current_blog;

		/**
		 * Note: $_SERVER['SERVER_NAME'] not a reliable when generating email host names.
		 * This method will likely be deprecated at some point.
		 * See https://core.trac.wordpress.org/ticket/25239
		 */
		$sitename = strtolower( $_SERVER['SERVER_NAME'] );
		if ( substr( $sitename, 0, 4 ) == 'www.' ) {
			$sitename = substr( $sitename, 4 );
		}
		$email = 'wordpress@' . $sitename;

		// If email is invalid, probably due to $_SERVER['SERVER_NAME']
		// use the stored site URL instead.
		if ( ! is_email( $email ) ) {

			if ( is_multisite() ) {
				$sitename = strtolower( $current_blog->domain );
			} else {
				$sitename = strtolower( parse_url( home_url(), PHP_URL_HOST ) );
			}

			$email = 'wordpress@' . preg_replace( '#^www\.#', '', $sitename );

		}

		return $email;

	}

	/**
	 * Is Admin From Email
	 *
	 * Checks to see if the email is the admin email address set in the WordPress options.
	 *
	 * Also note, some hosts may refuse to relay mail from an unknown domain. See
	 * http://trac.wordpress.org/ticket/5007
	 *
	 * @since   1.1
	 *
	 * @param   string   $email  Email to check.
	 * @return  boolean
	 */
	public function is_admin_from( $email ) {
		$admin_email = get_option( 'admin_email' );
		if ( $email == $admin_email )
			return true;
		return false;
	}

	/**
	 * Register Activation
	 *
	 * Called when plugin is activated. Not called when plugin is auto-updated.
	 *
	 * @since  1.1
	 */
	public static function activate() {

		// Copy values from original WP MailFrom if present and plugin optionsnot yet set.
		// http://wordpress.org/plugins/wp-mailfrom/
		$name = get_option( 'site_mail_from_name', '' );
		$email = get_option( 'site_mail_from_email', '' );
		$new_name = get_option( 'wp_mailfrom_ii_name', '' );
		$new_email = get_option( 'wp_mailfrom_ii_email', '' );
		if ( ! empty( $name ) && empty( $new_name ) )
			$name_updated = add_option( 'wp_mailfrom_ii_name', $name );
		if ( ! empty( $email ) && empty( $new_email ) )
			$email_updated = add_option( 'wp_mailfrom_ii_email', $email );
	}

}
