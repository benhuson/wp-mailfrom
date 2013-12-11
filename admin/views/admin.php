<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

?>

<div class="wrap">
	<?php screen_icon(); ?>
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
	<form action="options.php" method="post">
		<?php
		settings_fields( 'wp_mailfrom_ii' );
		do_settings_sections( 'wp_mailfrom_ii' );
		?>
		<p class="submit"><input name="submit" type="submit" class="button button-primary" value="<?php esc_attr_e( 'Save Changes', $this->plugin_slug ); ?>" /></p>
	</form>
</div>
