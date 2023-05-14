<?php
/**
 * Option
 *
 * @package DirectoryInfo
 */

namespace DirectoryInfo\Core;

/**
 * Option class.
 *
 * @since 1.0.0
 */
class Option {

	/**
	 * Return plugin option.
	 *
	 * @since 1.0.0
	 *
	 * @param string $key Option key.
	 * @return mixed Option value.
	 */
	public static function get( $key ) {
		$default_options = self::get_defaults();

		if ( empty( $key ) ) {
			return;
		}

		$current_options = (array) get_option( 'directory_info_options' );
		$current_options = wp_parse_args( $current_options, $default_options );

		$value = null;

		if ( isset( $current_options[ $key ] ) ) {
			$value = $current_options[ $key ];
		}

		return $value;
	}

	/**
	 * Update plugin option.
	 *
	 * @since 1.0.0
	 *
	 * @param string $key Option key.
	 * @param mixed  $value Option value.
	 * @return void
	 */
	public static function set( $key, $value ) {
		$current_options = (array) get_option( 'directory_info_options' );

		$current_options[ $key ] = $value;

		update_option( 'directory_info_options', $current_options );
	}

	/**
	 * Return default options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Default options.
	 */
	public static function get_defaults() {
		return apply_filters(
			'directory_info_option_defaults',
			array(
				'username' => '',
			)
		);
	}

	/**
	 * Return default value of given key.
	 *
	 * @since 1.0.0
	 *
	 * @param string $key Option key.
	 * @return mixed Default option value.
	 */
	public static function defaults( $key ) {
		$value = null;

		$defaults = self::get_defaults();

		if ( ! empty( $key ) && isset( $defaults[ $key ] ) ) {
			$value = $defaults[ $key ];
		}

		return $value;
	}
}
