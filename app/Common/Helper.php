<?php
/**
 * Helper
 *
 * @package DirectoryInfo
 */

namespace DirectoryInfo\Common;

/**
 * Helper class.
 *
 * @since 1.0.0
 */
class Helper {

	/**
	 * Get themes info.
	 *
	 * @since 1.0.0
	 */
	public static function get_themes_info( $wporg_id ) {
		$output = array();

		$transient_key = 'dit_' . sanitize_key( $wporg_id );

		$transient_period = 24 * HOUR_IN_SECONDS;

		$output = get_transient( $transient_key );

		if ( false === $output || 1 === 2 ) {
			$output = array();

			$wporgClient = \Rarst\Guzzle\WporgClient::getClient();

			$fields = array(
				'downloaded',
				'last_updated',
				'homepage',
			);

			$themes = $wporgClient->getThemesBy( 'author', esc_attr( $wporg_id ), 1, 100, $fields );

			if ( $themes ) {
				$output = $themes['themes'];
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
	public static function get_plugins_info( $wporg_id ) {
		$output = array();

		$transient_key = 'dip_' . sanitize_key( $wporg_id );

		$transient_period = 24 * HOUR_IN_SECONDS;

		$output = get_transient( $transient_key );

		if ( false === $output || 1 === 2 ) {
			$wporgClient = \Rarst\Guzzle\WporgClient::getClient();

			$fields = array(
				'downloaded',
				'last_updated',
				'homepage',
			);

			$plugins = $wporgClient->getPluginsBy( 'author', esc_attr( $wporg_id ), 1, 100, $fields );

			if ( $plugins ) {
				$output = $plugins['plugins'];
			}

			set_transient( $transient_key, $output, $transient_period );
		}

		return $output;
	}
}
