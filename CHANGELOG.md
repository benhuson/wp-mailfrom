# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased]

## [1.1.1] - 2019-11-07

### Added
- Added Hungarian translation. Props Viktor Szépe.

### Changed
- Bump WordPress requirements.

## [1.1] - 2015-10-29

### Added
- Added options to override the default WordPress email address and admin email address.
- Added 'wp_mailfrom_ii_default_from' filter so you can add compatibility if the pluggable wp_mail() function is altered to use a different default email address.
- Delete plugin options when uninstalled.

### Changed
- Reworked as a singleton class.

### Removed
- Remove filter support for original WP MailFrom plugin.

## [1.0.2] - 2013-11-20

### Fixed
- Only set email address and name if overwriting the default WordPress values.

## [1.0.1] - 2012-11-29

### Fixed
- Correctly style "save settings" button.

## [1.0] - 2012-08-22

### Changed
- Pretty much re-coded from scratch - now based around a core WP_MailFrom_II class.
- Uses the [WordPress Settings API](http://codex.wordpress.org/Settings_API).
- Stores name and email as `wp_mailfrom_ii_name` and `wp_mailfrom_ii_email` options. Upgrade support is provided for old options.

## [0.6] - 2012-07-27

### Added
- Fork of original [WP Mail From](https://wordpress.org/plugins/wp-mailfrom/) plugin

[Unreleased]: https://github.com/benhuson/wp-mailfrom/compare/1.1.1...HEAD
[1.1.1]: https://github.com/benhuson/wp-mailfrom/compare/1.1...1.1.1
[1.1]: https://github.com/benhuson/wp-mailfrom/compare/1.0.2...1.1
[1.0.2]: https://github.com/benhuson/wp-mailfrom/compare/1.0.1...1.0.2
[1.0.1]: https://github.com/benhuson/wp-mailfrom/compare/1.0...1.0.1
[1.0]: https://github.com/benhuson/wp-mailfrom/compare/0.6...1.0
[0.6]: https://github.com/benhuson/wp-mailfrom/releases/tag/0.6
