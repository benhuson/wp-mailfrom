=== wp mail from ===
Contributors: Tristan Aston
Tags: mail from, from email, email from, from address, mail, email, smtp, from address, email address, from header
Requires at least: 2.3
Tested up to: 3.1
Stable tag: 0.6

Allows you to configure the default email address and name used on email sent by wordpress.

== Description ==

This plugin allows you to set the email address and name used on email sent by wordpress by setting the *From:* header.

* Adds a "wp mail from" section in the "settings" menu
* The plugin uses the filter hooks **wp\_mail\_from** and **wp\_mail\_from\_name**. I believe these are both available in WordPress 2.3+
* The priority for the hooks is set to 1 to allow for other plugins that may hook these with the default priority of 10 to override this plugin.

== Installation ==

1. Unzip `wp-mailfrom.zip` in the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= Why does the From address still show as the default or show up as 'sent on behalf of' the default address =

Possibly your mail server has added a *Sender:* header or is configured to always set the *envelope sender* to the user calling it.

== Screenshots ==

1. The settings menu

== Changelog ==

= 0.6 =
readme.txt change to reflect compatibility with recent versions of wordpress.

== Upgrade Notice ==

= 0.6 =
This version just updates compatibility information
