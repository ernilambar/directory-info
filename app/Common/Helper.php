<?php
/**
 * Helper
 *
 * @package DirectoryInfo
 */

declare(strict_types=1);

namespace DirectoryInfo\Common;

/**
 * Helper class.
 *
 * @since 1.0.0
 */
class Helper {

	/**
	 * Return themes by author from WPORG API.
	 *
	 * @since 1.0.0
	 *
	 * @param string $slug WordPress.org username.
	 * @return array Themes details.
	 */
	public static function get_themes_by_author( string $slug ): array {
		$url = 'https://api.wordpress.org/themes/info/1.1/';

		$data = array(
			'action'            => 'query_themes',
			'request[author]'   => $slug,
			'request[page]'     => 1,
			'request[per_page]' => 100,
			'request[fields]'   => array(
				'downloaded'   => true,
				'last_updated' => true,
				'homepage'     => true,
			),
		);

		$url = $url . '?' . http_build_query( $data );

		$response = wp_remote_get( $url );

		$output = array();

		if ( ! is_wp_error( $response ) ) {
			$output = wp_remote_retrieve_body( $response );
			$output = json_decode( $output, true );
		}

		return $output;
	}

	/**
	 * Return plugins by author from WPORG API.
	 *
	 * @since 1.0.0
	 *
	 * @param string $slug WordPress.org username.
	 * @return array Plugins details.
	 */
	public static function get_plugins_by_author( string $slug ): array {
		$url = 'https://api.wordpress.org/plugins/info/1.1/';

		$data = array(
			'action'            => 'query_plugins',
			'request[author]'   => $slug,
			'request[page]'     => 1,
			'request[per_page]' => 100,
			'request[fields]'   => array(
				'downloaded'   => true,
				'last_updated' => true,
				'homepage'     => true,
			),
		);

		$url = $url . '?' . http_build_query( $data );

		$response = wp_remote_get( $url );

		$output = array();

		if ( ! is_wp_error( $response ) ) {
			$output = wp_remote_retrieve_body( $response );
			$output = json_decode( $output, true );
		}

		return $output;
	}

	/**
	 * Get themes info.
	 *
	 * @since 1.0.0
	 *
	 * @param string $wporg_id WordPress.org username.
	 * @return array Themes details.
	 */
	public static function get_themes_info( string $wporg_id ): array {
		$output = array();

		$transient_key = 'dit_' . sanitize_key( $wporg_id );

		$transient_period = 24 * HOUR_IN_SECONDS;

		$output = get_transient( $transient_key );

		$is_transient_disabled = defined( 'DISABLE_TRANSIENT' ) && true === DISABLE_TRANSIENT;

		if ( false === $output || true === $is_transient_disabled ) {
			$output = array();

			$themes = self::get_themes_by_author( $wporg_id );

			if ( $themes ) {
				$all_themes = $themes['themes'];

				if ( ! empty( $all_themes ) ) {
					$all_themes = array_map(
						function ( $el ) {
							$item = $el;

							$item['last_updated_w3c'] = gmdate( DATE_W3C, strtotime( $el['last_updated_time'] ) );
							return $item;
						},
						$all_themes
					);

					$output = $all_themes;
				}
			}

			set_transient( $transient_key, $output, $transient_period );
		}

		return $output;
	}

	/**
	 * Get plugins info.
	 *
	 * @since 1.0.0
	 *
	 * @param string $wporg_id WordPress.org username.
	 * @return array Plugins details.
	 */
	public static function get_plugins_info( string $wporg_id ): array {
		$output = array();

		$transient_key = 'dip_' . sanitize_key( $wporg_id );

		$transient_period = 24 * HOUR_IN_SECONDS;

		$output = get_transient( $transient_key );

		$is_transient_disabled = defined( 'DISABLE_TRANSIENT' ) && true === DISABLE_TRANSIENT;

		if ( false === $output || true === $is_transient_disabled ) {
			$plugins = self::get_plugins_by_author( $wporg_id );

			if ( $plugins ) {
				$all_plugins = $plugins['plugins'];

				if ( ! empty( $all_plugins ) ) {
					$all_plugins = array_map(
						function ( $el ) {
							$item = $el;

							$item['last_updated_w3c'] = gmdate( DATE_W3C, strtotime( $el['last_updated'] ) );
							return $item;
						},
						$all_plugins
					);

					$output = $all_plugins;
				}
			}

			set_transient( $transient_key, $output, $transient_period );
		}

		return $output;
	}

	/**
	 * Return SVG icon markup.
	 *
	 * @since 1.0.0
	 *
	 * @param string $key Icon key.
	 * @return string Icon markup.
	 */
	public static function get_icon( string $key ): string {
		$svg = '';

		if ( file_exists( DIRECTORY_INFO_DIR . "/build/img/{$key}.svg" ) ) {
			$svg = file_get_contents( DIRECTORY_INFO_DIR . "/build/img/{$key}.svg" ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		}

		return $svg;
	}
}
