<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

global $wp_version;

?>

<div class="wrap">
	<?php screen_icon(); ?>
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
	<form action="options.php" method="post">
		<?php
		settings_fields( 'wp_mailfrom_ii' );
		do_settings_sections( 'wp_mailfrom_ii' );
		?>
		<p class="submit"><input name="submit" type="submit" class="button button-primary" value="<?php esc_attr_e( 'Save Changes', 'wp-mailfrom-ii' ); ?>" /></p>
	</form>
</div>
