<?php
/**
 * Helper functions
 *
 * @package Directory_Info
 */

/**
 * Get themes info.
 *
 * @since 1.0.0
 */
function directory_info_get_themes_info() {

	$output = array();

	$current_wporg_id = get_option( 'di_wporg_id' );

	$transient_key = 'dit_' . sanitize_key( $current_wporg_id );
	$transient_period = 24 * HOUR_IN_SECONDS;

	$output = get_transient( $transient_key );

	$force_refresh = 0;
	if ( isset( $_POST['force_refresh'] ) && 1 === absint( $_POST['force_refresh'] ) ) {
		$force_refresh = 1;
	}

	if ( false === $output || 1 === $force_refresh ) {
		$wporgClient = \Rarst\Guzzle\WporgClient::getClient();
		$fields = array(
			'downloaded',
			'last_updated',
			'homepage',
		);

		$themes = $wporgClient->getThemesBy( 'author', esc_attr( $current_wporg_id ), 1, 100, $fields );

		if ( $themes ) {
			$output = $themes;
		}

		set_transient( $transient_key, $output, $transient_period );
	}

	return $output;

}

/**
 * Get plugins info.
 *
 * @since 1.0.0
 */
function directory_info_get_plugins_info() {

	$output = array();

	$current_wporg_id = get_option( 'di_wporg_id' );

	$transient_key = 'dip_' . sanitize_key( $current_wporg_id );
	$transient_period = 24 * HOUR_IN_SECONDS;

	$output = get_transient( $transient_key );

	$force_refresh = 0;
	if ( isset( $_POST['force_refresh'] ) && 1 === absint( $_POST['force_refresh'] ) ) {
		$force_refresh = 1;
	}

	if ( false === $output || 1 === $force_refresh ) {
		$wporgClient = \Rarst\Guzzle\WporgClient::getClient();
		$fields = array(
			'downloaded',
			'last_updated',
			'homepage',
		);

		$current_wporg_id = get_option( 'di_wporg_id' );
		$plugins = $wporgClient->getPluginsBy( 'author', esc_attr( $current_wporg_id ), 1, 100, $fields );

		if ( $plugins ) {
			$output = $plugins;
		}

		set_transient( $transient_key, $output, $transient_period );
	}

	return $output;

}
