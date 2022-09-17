<?php
/**
 * Admin
 *
 * @package DirectoryInfo
 */

namespace DirectoryInfo\Admin;

use \DirectoryInfo\Common\Helper;

/**
 * Admin class.
 *
 * @since 1.0.0
 */
class Admin {

	/**
	 * Register.
	 *
	 * @since 1.0.0
	 */
	public function register() {
		add_action( 'admin_enqueue_scripts', array( $this, 'load_assets' ) );
		add_action( 'admin_menu', array( $this, 'register_admin_page' ) );
		add_filter( 'plugin_action_links_' . DIRECTORY_INFO_BASE_FILENAME, array( $this, 'customize_plugin_action_links' ) );

		add_action( 'wp_ajax_get_wporg_id_detail', array( $this, 'get_details_ajax_callback' ) );
		add_action( 'wp_ajax_nopriv_get_wporg_id_detail', array( $this, 'get_details_ajax_callback' ) );
	}

	public function register_admin_page() {
		add_submenu_page(
			'tools.php',
			esc_html__( 'Directory Info', 'directory-info' ),
			esc_html__( 'Directory Info', 'directory-info' ),
			'manage_options',
			DIRECTORY_INFO_SLUG,
			[ $this, 'render_admin_page' ]
		);

	}

	public function render_admin_page() {
		?>
		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<hr />

			<form action="" method="post" class="frm-directory-info" id="frm-directory-info">
				<div class="org-id-wrap">
					<label for="wporg_id">
						<?php esc_html_e( 'Enter WordPress.org ID', 'directory-info' ); ?>
						<input type="text" name="wporg_id" id="wporg_id" value="" />
					</label>
					<button class="button button-secondary" name="btn-submit-di"><?php esc_attr_e( 'GO', 'directory-info' ); ?></button>
					<div id="di-loading" style="display:none;">Processing</div>
				</div><!-- .org-id-wrap -->
			</form>

			<div class="directory-wrapper directory-theme-wrapper">

				<div id="di-themes-output" class="directory-wrapper"></div>
				<div id="di-plugins-output" class="directory-wrapper"></div>

			</div><!-- .directory-wrapper -->

		</div><!-- .wrap -->
		<?php
	}

	public function load_assets( $hook ) {
		if ( 'tools_page_directory-info' !== $hook ) {
			return;
		}

		wp_enqueue_style( 'directory-info-admin', DIRECTORY_INFO_URL . '/assets/directory.css', array(), DIRECTORY_INFO_VERSION );
		wp_enqueue_script( 'directory-info-admin', DIRECTORY_INFO_URL . '/assets/directory.js', array( 'jquery' ), DIRECTORY_INFO_VERSION, true );

		$data = array(
			'placeholder_url' => DIRECTORY_INFO_URL . '/assets/static/no-image.png',
		);

		wp_localize_script( 'directory-info-admin', 'diObject', $data );
	}

	/**
	 * Customize plugin action links.
	 *
	 * @since 1.0.0
	 *
	 * @param array $actions Action links.
	 * @return array Modified action links.
	 */
	public function customize_plugin_action_links( $actions ) {
		$url = add_query_arg(
			array(
				'page' => DIRECTORY_INFO_SLUG,
			),
			admin_url( 'tools.php' )
		);

		$actions = array_merge(
			array(
				'welcome' => '<a href="' . esc_url( $url ) . '">' . esc_html__( 'Info Page', 'directory-info' ) . '</a>',
			),
			$actions
		);

		return $actions;
	}

	public function get_details_ajax_callback() {
		$output = array();

		$id = ( isset( $_POST['wporg_id'] ) && ! empty( $_POST['wporg_id'] ) ) ? esc_attr( $_POST['wporg_id'] ) : null;

		if ( ! $id ) {
			wp_send_json_error( new \WP_Error( 'Invalid ID.' ) );
		}

		$error = false;

		$all_themes = Helper::get_themes_info( $id );
		$all_plugins = Helper::get_plugins_info( $id );

		if ( empty( $all_themes ) && empty( $all_plugins ) ) {
			$error = true;
		}

		$output['themes'] = $all_themes;
		$output['plugins'] = $all_plugins;

		if ( ! $error ) {
			wp_send_json_success( $output );
		} else {
			wp_send_json_error( $output );
		}
	}
}
