<?php
/**
 * Admin
 *
 * @package DirectoryInfo
 */

namespace DirectoryInfo\Admin;

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
		add_action( 'admin_menu', array( $this, 'register_admin_page' ) );
		add_filter( 'plugin_action_links_' . DIRECTORY_INFO_BASE_FILENAME, array( $this, 'customize_plugin_action_links' ) );
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

			<form action="" method="post" class="frm-directory-info">
				<?php wp_nonce_field( 'directory_info_run', 'directory_info_nonce' ); ?>
				<div class="org-id-wrap">
					<label for="wporg_id">
						<?php esc_html_e( 'Enter WordPress.org ID', 'directory-info' ); ?>
						<input type="text" name="wporg_id" id="wporg_id" value="" />
					</label>
					<button class="button button-secondary" name="btn-submit-di"><?php esc_attr_e( 'GO', 'directory-info' ); ?></button>
				</div><!-- .org-id-wrap -->
			</form>
		</div><!-- .wrap -->
		<?php
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
}
