<?php

/**
 * @package     WP Mail From II
 * @subpackage  Uninstall
 *
 * Fired when the plugin is uninstalled.
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit;  // If uninstall not called from WordPress, then exit

// Delete options
delete_option( 'wp_mailfrom_ii_name' );
delete_option( 'wp_mailfrom_ii_email' );
delete_option( 'wp_mailfrom_ii_override_default' );
delete_option( 'wp_mailfrom_ii_override_admin' );
