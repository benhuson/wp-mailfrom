=== WP Mail From II ===
Contributors: husobj
Tags: mail from, from email, email from, from address, mail, email, smtp, from address, email address, from header
Requires at least: 2.9
Tested up to: 3.4.1
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Allows you to configure the default email address and name used for emails sent by WordPress.

== Description ==

This plugin allows you to set the email address and name used on email sent by WordPress by setting the *From:* header.

It is an updated and fully re-worked version of the [WP Mail From](http://wordpress.org/extend/plugins/wp-mailfrom/) plugin by Tristan Aston and now works with the latest versions of WordPress.

* Adds a "Mail From" section in the "Settings" menu.
* The plugin uses the filter hooks `wp_mail_from` and `wp_mail_from_name`.
* The priority for the hooks is set to 1 to allow for other plugins that may hook these with the default priority of 10 to override this plugin.

== Installation ==

Either install via the WordPress admin plugin installer or...

1. Unzip `wp-mailfrom.zip` in the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.

== Frequently Asked Questions ==

= Why does the From address still show as the default or show up as 'sent on behalf of' the default address? =

Possibly your mail server has added a *Sender:* header or is configured to always set the *envelope sender* to the user calling it.

== Screenshots ==

1. The settings page

== Changelog ==

= 1.0 =
* Pretty much re-coded from scratch - now based around a core WP_MailFrom class.
* Uses the [WordPress Settings API](http://codex.wordpress.org/Settings_API).
* Stores name and email as `wp_mailfrom_name` and `wp_mailfrom_email` options. Legacy support provided for old options.

= 0.6 =
* readme.txt changed to reflect compatibility with recent versions of WordPress.

== Upgrade Notice ==

= 1.0 =
This version is pretty much a complete re-write, fixes loads of bugs and works with the most recent versions of WordPress.

= 0.6 = 
This version just updates compatibility information.

== Theme/Plugin Authors ==

= 1.0 =
This version is pretty much a complete re-write.
If you have been using a previous version of this plugin it should just work.

However, for naming consistency, the option names have changed.
If you accessed either of the options directly for any reason you will need to re-factor you code as support for the old options will be removed in a future version.

The old options could be retrieved as follows:

`get_option( 'site_mail_from_name' );
get_option( 'site_mail_from_email' );`

You should now use:

`get_option( 'wp_mailfrom_name' );
get_option( 'wp_mailfrom_email' );`
