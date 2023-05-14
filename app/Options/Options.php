<?php
/**
 * Options
 *
 * @package DirectoryInfo
 */

namespace DirectoryInfo\Options;

use Nilambar\Optioner\Optioner;

/**
 * Options class.
 *
 * @since 1.0.0
 */
class Options {

	/**
	 * Register.
	 *
	 * @since 1.0.0
	 */
	public function register() {
		add_action( 'optioner_admin_init', array( $this, 'register_plugin_options' ) );
	}

	/**
	 * Register plugin options.
	 *
	 * @since 1.0.0
	 */
	public function register_plugin_options() {
		$obj = new Optioner();

		$obj->set_page(
			array(
				'page_title'     => esc_html__( 'Directory Info Settings', 'directory-info' ),
				/* translators: %s: version. */
				'page_subtitle'  => sprintf( esc_html__( 'Version: %s', 'directory-info' ), DIRECTORY_INFO_VERSION ),
				'menu_title'     => esc_html__( 'Directory Info Settings', 'directory-info' ),
				'capability'     => 'manage_options',
				'menu_slug'      => 'directory-info-settings',
				'option_slug'    => 'directory_info_options',
				'top_level_menu' => false,
			)
		);

		// Tab: directory_info_general.
		$obj->add_tab(
			array(
				'id'    => 'directory_info_general',
				'title' => esc_html__( 'Settings', 'directory-info' ),
			)
		);

		// Field: username.
		$obj->add_field(
			'directory_info_general',
			array(
				'id'    => 'username',
				'type'  => 'text',
				'title' => esc_html__( 'Username', 'directory-info' ),
			)
		);



		$obj->set_sidebar(
			array(
				'render_callback' => array( $this, 'render_sidebar' ),
			)
		);

		$obj->run();
	}

	/**
	 * Render admin sidebar.
	 *
	 * @since 1.0.0
	 *
	 * @param Optioner $optioner_object Optioner object.
	 */
	public function render_sidebar( $optioner_object ) {
		$optioner_object->render_sidebar_box(
			array(
				'title'   => 'Help &amp; Support',
				'icon'    => 'dashicons-editor-help',
				'content' => '<h4>Questions, bugs or great ideas?</h4>
				<p><a href="https://github.com/ernilambar/directory-info/issues" target="_blank">Create issue in the repo</a></p>',
			),
			$optioner_object
		);
	}
}
