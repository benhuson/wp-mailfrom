<?php 

/**
 * Plugin Name:        WP Mail From II
 * Plugin URI:         https://wordpress.org/plugins/wp-mailfrom-ii/
 * Description:        Allows you to configure the default email address and name used for emails sent by WordPress.
 * Version:            1.2
 * Author:             Ben Huson
 * Author URI:         https://github.com/benhuson/
 * Minimum WordPress Version Required: 4.3
 * Tested up to:       5.4.4
 * Text Domain:        wp-mailfrom-ii
 * Domain Path:        /languages
 * License:            GPL-2.0+
 * License URI:        http://www.gnu.org/licenses/gpl-2.0.txt
 * GitHub Plugin URI:  https://github.com/benhuson/wp-mailfrom
 *
 * An updated and fully re-worked version of the WP Mail From plugin by Tristan Aston.
 * http://wordpress.org/extend/plugins/wp-mailfrom/
 */

if ( ! defined( 'ABSPATH' ) ) exit;  // Exit if accessed directly

// Require public files.
require_once( plugin_dir_path( __FILE__ ) . 'public/class-wp-mailfrom-ii.php' );

// Register hooks that are fired when the plugin is activated.
register_activation_hook( __FILE__, array( 'WP_MailFrom_II', 'activate' ) );

// Init.
add_action( 'plugins_loaded', array( 'WP_MailFrom_II', 'get_instance' ) );

// Only load admin functionality in admin.
if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-wp-mailfrom-ii-admin.php' );
	add_action( 'plugins_loaded', array( 'WP_MailFrom_II_Admin', 'get_instance' ) );

}
