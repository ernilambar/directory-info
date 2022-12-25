<?php
/**
 * Admin
 *
 * @package DirectoryInfo
 */

namespace DirectoryInfo\Admin;

use \DirectoryInfo\Common\Helper;
use Nilambar\Welcome\Welcome;

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
		add_filter( 'plugin_action_links_' . DIRECTORY_INFO_BASE_FILENAME, array( $this, 'customize_plugin_action_links' ) );

		add_action( 'wp_ajax_get_wporg_id_detail', array( $this, 'get_details_ajax_callback' ) );
		add_action( 'wp_ajax_nopriv_get_wporg_id_detail', array( $this, 'get_details_ajax_callback' ) );

		add_action( 'wp_welcome_init', array( $this, 'add_admin_page' ) );
	}

	/**
	 * Add admin page.
	 *
	 * @since 1.0.1
	 */
	public function add_admin_page() {
		$obj = new Welcome( 'plugin', 'directory-info' );

		$obj->set_page(
			array(
				'page_title'    => esc_html__( 'Directory Info', 'directory-info' ),
				'page_subtitle' => sprintf( esc_html__( 'Version: %s', 'directory-info' ), DIRECTORY_INFO_VERSION ),
				'menu_title'    => esc_html__( 'Directory Info', 'directory-info' ),
				'menu_slug'     => 'directory-info',
				'parent_page'   => 'tools.php',
			)
		);

		$obj->add_tab(
			array(
				'id'              => 'get-info',
				'title'           => esc_html__( 'Get Info', 'directory-info' ),
				'type'            => 'custom',
				'render_callback' => array( $this, 'render_di_form' ),
			)
		);

		$obj->set_sidebar(
			array(
				'render_callback' => array( $this, 'render_sidebar' ),
			)
		);

		$obj->run();
	}

	public function render_di_form() {
		?>
		<form action="" method="post" class="frm-directory-info" id="frm-directory-info">
			<div class="org-id-wrap">
				<label for="wporg_id">
					<?php esc_html_e( 'Enter WordPress.org ID', 'directory-info' ); ?>
					<input type="text" name="wporg_id" id="wporg_id" value="" />
				</label>
				<button class="button button-secondary" name="btn-submit-di"><?php esc_attr_e( 'GO', 'directory-info' ); ?></button>
				<div id="di-loading"><?php echo Helper::get_icon( 'spinner' ); ?></div>
			</div><!-- .org-id-wrap -->
		</form>

		<div class="directory-wrapper directory-theme-wrapper">

			<div id="di-themes-output" class="directory-wrapper"></div>
			<div id="di-plugins-output" class="directory-wrapper"></div>

		</div><!-- .directory-wrapper -->
		<?php
	}

	/**
	 * Render admin page sidebar.
	 *
	 * @since 1.0.1
	 *
	 * @param Welcome $object Instance of Welcome.
	 */
	public function render_sidebar( $object ) {
		$object->render_sidebar_box(
			array(
				'title'   => 'Help &amp; Support',
				'icon'    => 'dashicons-editor-help',
				'content' => '<h4>Questions, bugs or great ideas?</h4>
				<p><a href="https://github.com/ernilambar/directory-info/issues" target="_blank">Create issue in the repo</a></p>',
			),
			$object
		);
	}

	public function load_assets( $hook ) {
		if ( 'tools_page_directory-info' !== $hook ) {
			return;
		}

		wp_enqueue_style( 'directory-info-admin', DIRECTORY_INFO_URL . '/build/directory.css', array(), DIRECTORY_INFO_VERSION );
		wp_enqueue_script( 'directory-info-admin', DIRECTORY_INFO_URL . '/build/directory.js', array( 'jquery' ), DIRECTORY_INFO_VERSION, true );

		$data = array(
			'placeholder_url' => DIRECTORY_INFO_URL . '/' . Helper::get_asset_by_glob_path( DIRECTORY_INFO_DIR . '/build/images/no-image.*.png' ),
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
