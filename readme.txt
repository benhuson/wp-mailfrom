=== WP Mail From II ===
Contributors: husobj
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=3DMFEA5C6ABCL
Tags: mail from, from email, email from, from address, mail, email, smtp, from address, email address, from header
Requires at least: 4.3
Tested up to: 5.2.3
Stable tag: 1.1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Allows you to configure the default email address and name used for emails sent by WordPress.

== Description ==

This plugin allows you to set the email address and name used for emails sent by WordPress by setting the *From:* header.

It is an updated and fully re-worked version of the [WP Mail From](http://wordpress.org/extend/plugins/wp-mailfrom/) plugin by Tristan Aston and now works with the latest versions of WordPress.

* Adds a "Mail From" section in the "Settings" menu.
* The plugin uses the filter hooks `wp_mail_from` and `wp_mail_from_name`.
* The priority for the hooks is set to 1 to allow for other plugins that may hook these with the default priority of 10 to override this plugin.

Danish translation by Frederik Svarre ([www.fslab.dk](http://www.fslab.dk/))

== Installation ==

Either install via the WordPress admin plugin installer or...

1. Unzip `wp-mailfrom-ii.zip` in the `/wp-content/plugins/` directory, making sure the folder is called `wp-mailfrom-ii`.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Visit the admin settings page `Settings > Mail From` and save your preferred name and email address.

= Upgrading from the old WP Mail From plugin =

This version is pretty much a complete re-write, fixes loads of bugs and works with the most recent versions of WordPress.

If upgrading from the [WP Mail From](http://wordpress.org/extend/plugins/wp-mailfrom/) plugin your current name an email settings should be copied across but please check.
To upgrade simply activate this plugin then deactivate the old WP Mail From plugin.

Option naming conventions have changed in this version of the plugin.
If you accessed either of the options directly for any reason you will need to re-factor you code as support for the old options will be removed in a future version.

The old options used to be retrieved as follows:

`get_option( 'site_mail_from_name' );
get_option( 'site_mail_from_email' );`

You should now use:

`get_option( 'wp_mailfrom_ii_name' );
get_option( 'wp_mailfrom_ii_email' );`


== Frequently Asked Questions ==

= Why does the From address still show as the default or show up as 'sent on behalf of' the default address? =

Possibly your mail server has added a *Sender:* header or is configured to always set the *envelope sender* to the user calling it.

= Why are emails not being sent? =

Some hosts may refuse to relay mail from an unknown domain. See [http://trac.wordpress.org/ticket/5007](http://trac.wordpress.org/ticket/5007) for more details.

== Screenshots ==

1. The settings page

== Changelog ==

= 1.1.1 =
* Update translations.
* Bump WordPress requirements.

= 1.1 =
* Added options to override the default WordPress email address and admin email address.
* Added 'wp_mailfrom_ii_default_from' filter so you can add compatibility if the pluggable wp_mail() function is altered to use a different default email address.
* Delete plugin options when uninstalled.
* Reworked as a singleton class.
* Remove filter support for original WP MailFrom plugin.

= 1.0.2 =
* Only set email address and name if overwriting the default WordPress values.

= 1.0.1 =
* Correctly style "save settings" button.

= 1.0 =
* Pretty much re-coded from scratch - now based around a core WP_MailFrom_II class.
* Uses the [WordPress Settings API](http://codex.wordpress.org/Settings_API).
* Stores name and email as `wp_mailfrom_ii_name` and `wp_mailfrom_ii_email` options. Upgrade support is provided for old options.

== Upgrade Notice ==

= 1.1.1 =
Update translations and bumped WordPress requirements.

= 1.1 =
Added options to override default WordPress email addresses and added 'wp_mailfrom_ii_default_from' filter.

= 1.0.2 =
Only set email address and name if overwriting the default WordPress values.

= 1.0.1 =
Correctly style save settings button.

= 1.0 =
This version is pretty much a complete re-write, fixes loads of bugs and works with the most recent versions of WordPress.
If upgrading from the [WP Mail From](http://wordpress.org/extend/plugins/wp-mailfrom/) plugin your current name an email settings should be copied across but please check.