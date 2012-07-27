<?php 

/*
Plugin Name: WP Mail From
Version: 1.0
Plugin URI: http://wordpress.org/extend/plugins/wp-mailfrom/
Description: Allows you to configure the default email address and name used for emails sent by WordPress.
Author: Tristan Aston, updated by Ben Huson

Copyright (c) 2009-2012, 
Released under the GPL license
http://www.gnu.org/licenses/gpl.txt
*/

class WP_MailFrom {

	/**
	 * Constructor
	 */
	function WP_MailFrom() {
		add_action( 'admin_init', array( $this, 'wp_mailfrom_settings' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
		
		// Name and email filter
		add_filter( 'wp_mail_from_name', array( $this, 'wp_mail_from_name' ), 1 );
		add_filter( 'wp_mail_from', array( $this, 'wp_mail_from' ), 1 );
		
		// Legacy support for old options - just in case someone used this directly!
		add_filter( 'pre_option_site_mail_from_name', 'get_option_site_mail_from_name', 1 );
		add_filter( 'pre_option_site_mail_from_email', 'get_option_site_mail_from_email', 1 );
	}
	
	/**
	 * Load Text Domain Language Support
	 */
	function load_textdomain() {
		load_plugin_textdomain( 'wp-mailfrom', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
	}
	
	/**
	 * Filter: wp_mail_from_name
	 *
	 * @param string $name Default name.
	 * @return string $name WP Mail From name.
	 */
	function wp_mail_from_name( $name ) {
		$wp_mailfrom_name = get_option( 'wp_mailfrom_name', '' );
		if ( ! empty( $wp_mailfrom_name ) ) {
			return $wp_mailfrom_name;
		}
		return $name;
	}
	
	/**
	 * Filter: wp_mail_from
	 *
	 * @param string $name Default email.
	 * @return string $name WP Mail From email.
	 */
	function wp_mail_from( $email ) {
		$wp_mailfrom_email = get_option( 'wp_mailfrom_email', '' );
		if ( ! empty( $wp_mailfrom_email ) ) {
			return $wp_mailfrom_email;
		}
		return $email;
	}
	
	/**
	 * Admin Menu
	 */
	function admin_menu() {
		add_options_page( __( 'WP Mail From Plugin', 'wp-mailfrom' ), __( 'Mail From', 'wp-mailfrom' ), 'manage_options', 'wp_mailfrom', array( $this, 'settings_page' ) );
	}
	
	/**
	 * Settings Page
	 */
	function settings_page() {
		?>
		<div class="wrap">
			<div id="icon-options-general" class="icon32"><br></div>
			<h2><?php _e( 'Mail From Settings', 'wp-mailfrom' ); ?></h2>
			<form action="options.php" method="post">
				<?php
				settings_fields( 'wp_mailfrom' );
				do_settings_sections( 'wp_mailfrom' );
				?>
				<p class="submit"><input name="submit" type="submit" value="<?php esc_attr_e( 'Save Changes', 'wp-mailfrom' ); ?>" /></p>
			</form>
		</div>
		<?php
	}
	
	/**
	 * Settings API
	 */
	function wp_mailfrom_settings() {
		add_settings_section(
			'wp_mailfrom',
			'',
			array( $this, 'wp_mailfrom_settings_section' ),
			'wp_mailfrom'
		);
		add_settings_field(
			'wp_mailfrom_name',
			__( 'From Name', 'wp-mailfrom' ),
			array( $this, 'wp_mailfrom_name_field' ),
			'wp_mailfrom',
			'wp_mailfrom'
		);
		add_settings_field(
			'wp_mailfrom_email',
			__( 'From Email Address', 'wp-mailfrom' ),
			array( $this, 'wp_mailfrom_email_field' ),
			'wp_mailfrom',
			'wp_mailfrom'
		);
 		register_setting( 'wp_mailfrom', 'wp_mailfrom_name', array( $this, 'sanitize_wp_mailfrom_name' ) );
 		register_setting( 'wp_mailfrom', 'wp_mailfrom_email', 'is_email' );
	}

	/**
	 * Sanitize Mail From Name
	 * Strips out all HTML, scripts...
	 *
	 * @param string $val Name.
	 * @return string Sanitized name.
	 */
	function sanitize_wp_mailfrom_name( $val ) {
		return wp_kses( $val, array() );
	}

	/**
	 * Mail From Settings Section
	 */
	function wp_mailfrom_settings_section() {
		echo '<p>' . __( 'If set, these 2 options will override the name and email address in the <strong>From:</strong> header on all sent emails.', 'wp-mailfrom' ) . '</p>';
	}

	/**
	 * Mail From Name Field
	 */
	function wp_mailfrom_name_field() {
		echo '<input name="wp_mailfrom_name" type="text" id="wp_mailfrom_name" value="' . get_option( 'wp_mailfrom_name', '' ) . '" class="regular-text" />';
	}

	/**
	 * Mail From Email Field
	 */
	function wp_mailfrom_email_field() {
		echo '<input name="wp_mailfrom_email" type="text" id="wp_mailfrom_email" value="' . get_option( 'wp_mailfrom_email', '' ) . '" class="regular-text" />';
	}
	
	/**
	 * Legacy support for get_option( 'site_mail_from_name' )
	 */
	function get_option_site_mail_from_name( $option, $default = false ) {
		return get_option( 'wp_mailfrom_name', $default );
	}
	
	/**
	 * Legacy support for get_option( 'site_mail_from_email' )
	 */
	function get_option_site_mail_from_email( $option, $default = false ) {
		return get_option( 'wp_mailfrom_email', $default );
	}
	
	/**
	 * Register Activation
	 * Perform upgrades etc.
	 */
	function register_activation() {
		
		// Temporarily remove our filter which provide support for legacy options
		remove_filter( 'pre_option_site_mail_from_name', 'get_option_site_mail_from_name', 1 );
		remove_filter( 'pre_option_site_mail_from_email', 'get_option_site_mail_from_email', 1 );
		
		// Get old option value and try to assign them to new options
		$name = get_option( 'site_mail_from_name', '' );
		$email = get_option( 'site_mail_from_email', '' );
		$name_updated = add_option( 'wp_mailfrom_name', $name );
		$email_updated = add_option( 'wp_mailfrom_email', $email );
		
		// If new options created delete old options
		if ( $name_updated )
			delete_option( 'site_mail_from_name' );
		if ( $email_updated )
			delete_option( 'site_mail_from_email' );
	}
	
}

global $WP_MailFrom;
$WP_MailFrom = new WP_MailFrom();
register_activation_hook( __FILE__, array( $WP_MailFrom, 'register_activation' ) );
