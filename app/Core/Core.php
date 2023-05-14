<?php
/**
 * Core
 *
 * @package DirectoryInfo
 */

namespace DirectoryInfo\Core;

/**
 * Core class.
 *
 * @since 1.0.0
 */
class Core {
	/**
	 * Register.
	 *
	 * @since 1.0.0
	 */
	public function register() {
		// Textdomain.
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );

		// Assets.
		add_action( 'wp_enqueue_scripts', array( $this, 'load_assets' ) );

		// Shortcode.
		add_shortcode( 'directory-info', array( $this, 'render_shortcode' ) );
	}

	/**
	 * Load plugin textdomain.
	 *
	 * @since 1.0.0
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'directory-info' );
	}

	/**
	 * Render shortcode.
	 *
	 * @since 1.0.0
	 */
	public function render_shortcode() {
		return '<div id="di-app"></div>';
	}

	/**
	 * Load assets.
	 *
	 * @since 1.0.0
	 */
	public function load_assets() {
		$script_asset_path = DIRECTORY_INFO_DIR . '/build/index.asset.php';
		$script_asset      = file_exists( $script_asset_path ) ? require $script_asset_path : array(
			'dependencies' => array(),
			'version'      => filemtime( __FILE__ ),
		);

		wp_enqueue_style( 'dashboard-info-app', DIRECTORY_INFO_URL . '/build/index.css', array(), $script_asset['version'] );

		wp_enqueue_script( 'dashboard-info-app', DIRECTORY_INFO_URL . '/build/index.js', $script_asset['dependencies'], $script_asset['version'], true );

		// wp_localize_script( 'dashboard-info-app', 'GITBOARD', Helper::get_ajax_data() );
	}
}
