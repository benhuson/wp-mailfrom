<?php 

/*
Plugin Name: wp mail from
Version: 0.6
Plugin URI: http://wordpress.org/extend/plugins/wp-mailfrom/
Description: This plugin allows you to set the From header on emails sent by wordpress
Author: Tristan Aston

Copyright (c) 2009
Released under the GPL license
http://www.gnu.org/licenses/gpl.txt
*/

load_plugin_textdomain( 'wp-mailfrom', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
function site_mail_from_option_page() {
  ?>
  <div class="wrap">
  <h2><?php _e('mailfrom options', 'wp-mailfrom'); ?></h2>
  <i><?php _e('If set, these 2 options will override the email address and name in the <strong>From:</strong> header on all sent emails', 'wp-mailfrom'); ?></i>
  <form method="post" action="options.php">
  <?php wp_nonce_field('update-options'); ?>
  <table class="form-table">
  <tr><th scope="row"><? _e('From email address', 'wp-mailfrom'); ?></th>
  <td><input type="text" name="site_mail_from_email" value="<?php echo get_option('site_mail_from_email'); ?>" /></td></tr>
  <tr><th scope="row"><? _e('From email name', 'wp-mailfrom'); ?></th>
  <td><input type="text" name="site_mail_from_name" value="<?php echo get_option('site_mail_from_name'); ?>" /></td></tr>
  </table>
  <input type="hidden" name="action" value="update" />
  <input type="hidden" name="page_options" value="site_mail_from_email,site_mail_from_name" />
  <p class="submit">
  <input type="submit" name="Submit" value="<?php _e('Save Changes', 'wp-mailfrom'); ?>" />
  </p>
  </form>
  </div>
  <?php
}

function site_mail_from_menu () {
  add_options_page('mailfrom plugin', 'wp mail from', 9, __FILE__, 'site_mail_from_option_page');
}

function site_mail_from ($mail_from_email) {
  $site_mail_from_email = get_option('site_mail_from_email');
  if(empty($site_mail_from_email)) {
    return $mail_from_email;
  }
  else {
    return $site_mail_from_email;
  }
}

function site_mail_from_name ($mail_from_name) {
  $site_mail_from_name = get_option('site_mail_from_name');
  if(empty($site_mail_from_name)) {
    return $mail_from_name;
  }
  else {
    return $site_mail_from_name;
  }
}

add_action('admin_menu', 'site_mail_from_menu');
add_filter('wp_mail_from','site_mail_from',1);
add_filter('wp_mail_from_name','site_mail_from_name',1);
