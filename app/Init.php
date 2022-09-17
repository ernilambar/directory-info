<?php
/**
 * Init
 *
 * @package DirectoryInfo
 */

namespace DirectoryInfo;

/**
 * Init class.
 *
 * @since 1.0.0
 */
final class Init {

	/**
	 * Store all the classes inside an array.
	 *
	 * @return array Full list of classes.
	 */
	public static function get_services() {
		return array(
			Core\Core::class,
			Admin\Admin::class,
		);
	}

	/**
	 * Loop through the classes, initialize them,
	 * and call the register() method if it exists
	 */
	public static function register_services() {
		foreach ( self::get_services() as $class ) {
			$service = self::instantiate( $class );
			if ( method_exists( $service, 'register' ) ) {
				$service->register();
			}
		}
	}

	/**
	 * Initialize the class.
	 *
	 * @param  class $class    Class from the services array.
	 * @return class instance  New instance of the class.
	 */
	private static function instantiate( $class ) {
		$service = new $class();

		return $service;
	}
}
