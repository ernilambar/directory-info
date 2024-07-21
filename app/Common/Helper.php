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
	 * Return themes by author from WPORG API.
	 *
	 * @since 1.0.0
	 *
	 * @param string $slug WordPress.org username.
	 * @return array Themes details.
	 */
	public static function get_themes_by_author( $slug ) {
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
	public static function get_plugins_by_author( $slug ) {
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
	public static function get_themes_info( $wporg_id ) {
		$output = array();

		$transient_key = 'dit_' . sanitize_key( $wporg_id );

		$transient_period = 24 * HOUR_IN_SECONDS;

		$output = get_transient( $transient_key );

		if ( false === $output || 1 === 2 ) {
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
	public static function get_plugins_info( $wporg_id ) {
		$output = array();

		$transient_key = 'dip_' . sanitize_key( $wporg_id );

		$transient_period = 24 * HOUR_IN_SECONDS;

		$output = get_transient( $transient_key );

		if ( false === $output || 1 === 2 ) {
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
	public static function get_icon( $key ) {
		$output = null;

		$icons = array(
			'spinner' => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: rgb(255, 255, 255); display: block; shape-rendering: auto; animation-play-state: running; animation-delay: 0s;" width="200px" height="200px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
			<g transform="rotate(0 50 50)" style="animation-play-state: running; animation-delay: 0s;">
				<rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#006cb5" style="animation-play-state: running; animation-delay: 0s;">
					<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.9166666666666666s" repeatCount="indefinite" style="animation-play-state: running; animation-delay: 0s;"></animate>
				</rect>
			</g><g transform="rotate(30 50 50)" style="animation-play-state: running; animation-delay: 0s;">
				<rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#006cb5" style="animation-play-state: running; animation-delay: 0s;">
					<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.8333333333333334s" repeatCount="indefinite" style="animation-play-state: running; animation-delay: 0s;"></animate>
				</rect>
			</g><g transform="rotate(60 50 50)" style="animation-play-state: running; animation-delay: 0s;">
				<rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#006cb5" style="animation-play-state: running; animation-delay: 0s;">
					<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.75s" repeatCount="indefinite" style="animation-play-state: running; animation-delay: 0s;"></animate>
				</rect>
			</g><g transform="rotate(90 50 50)" style="animation-play-state: running; animation-delay: 0s;">
				<rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#006cb5" style="animation-play-state: running; animation-delay: 0s;">
					<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.6666666666666666s" repeatCount="indefinite" style="animation-play-state: running; animation-delay: 0s;"></animate>
				</rect>
			</g><g transform="rotate(120 50 50)" style="animation-play-state: running; animation-delay: 0s;">
				<rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#006cb5" style="animation-play-state: running; animation-delay: 0s;">
					<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.5833333333333334s" repeatCount="indefinite" style="animation-play-state: running; animation-delay: 0s;"></animate>
				</rect>
			</g><g transform="rotate(150 50 50)" style="animation-play-state: running; animation-delay: 0s;">
				<rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#006cb5" style="animation-play-state: running; animation-delay: 0s;">
					<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.5s" repeatCount="indefinite" style="animation-play-state: running; animation-delay: 0s;"></animate>
				</rect>
			</g><g transform="rotate(180 50 50)" style="animation-play-state: running; animation-delay: 0s;">
				<rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#006cb5" style="animation-play-state: running; animation-delay: 0s;">
					<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.4166666666666667s" repeatCount="indefinite" style="animation-play-state: running; animation-delay: 0s;"></animate>
				</rect>
			</g><g transform="rotate(210 50 50)" style="animation-play-state: running; animation-delay: 0s;">
				<rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#006cb5" style="animation-play-state: running; animation-delay: 0s;">
					<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.3333333333333333s" repeatCount="indefinite" style="animation-play-state: running; animation-delay: 0s;"></animate>
				</rect>
			</g><g transform="rotate(240 50 50)" style="animation-play-state: running; animation-delay: 0s;">
				<rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#006cb5" style="animation-play-state: running; animation-delay: 0s;">
					<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.25s" repeatCount="indefinite" style="animation-play-state: running; animation-delay: 0s;"></animate>
				</rect>
			</g><g transform="rotate(270 50 50)" style="animation-play-state: running; animation-delay: 0s;">
				<rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#006cb5" style="animation-play-state: running; animation-delay: 0s;">
					<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.16666666666666666s" repeatCount="indefinite" style="animation-play-state: running; animation-delay: 0s;"></animate>
				</rect>
			</g><g transform="rotate(300 50 50)" style="animation-play-state: running; animation-delay: 0s;">
				<rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#006cb5" style="animation-play-state: running; animation-delay: 0s;">
					<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.08333333333333333s" repeatCount="indefinite" style="animation-play-state: running; animation-delay: 0s;"></animate>
				</rect>
			</g><g transform="rotate(330 50 50)" style="animation-play-state: running; animation-delay: 0s;">
				<rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#006cb5" style="animation-play-state: running; animation-delay: 0s;">
					<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="0s" repeatCount="indefinite" style="animation-play-state: running; animation-delay: 0s;"></animate>
				</rect>
			</g>
			</svg>
			',
		);

		if ( isset( $icons[ $key ] ) ) {
			$output = $icons[ $key ];
		}

		return $output;
	}
}
