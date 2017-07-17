<?php
/**
 * Admin functions
 *
 * @package Directory_Info
 */

/**
 * Register admin menu.
 *
 * @since 1.0.0
 */
function directory_info_admin_menu() {
	add_dashboard_page(
		esc_html__( 'Directory Info', 'directory-info' ),
		esc_html__( 'Directory Info', 'directory-info' ),
		'manage_options',
		'directory-info',
		'directory_info_render_admin_page'
	);
}
add_action( 'admin_menu', 'directory_info_admin_menu' );

/**
 * Callback for admin page.
 *
 * @since 1.0.0
 */
function directory_info_render_admin_page() {
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Directory Info', 'directory-info' ); ?></h1>
		<hr />
		<?php directory_info_render_form(); ?>

		<?php $current_wporg_id = get_option( 'di_wporg_id' ); ?>
		<?php if ( ! empty( $current_wporg_id ) ) : ?>
			<?php directory_info_render_themes_section(); ?>
			<?php directory_info_render_plugins_section(); ?>
		<?php endif; ?>
	</div>
	<?php
}

/**
 * Render themes section.
 *
 * @since 1.0.0
 */
function directory_info_render_themes_section() {

	$themes_info = directory_info_get_themes_info();
	$all_themes = ( isset( $themes_info['themes'] ) && ! empty( $themes_info['themes'] ) ) ? $themes_info['themes'] : array();
	?>
	<div class="directory-wrapper directory-theme-wrapper">

		<h2><?php esc_html_e( 'Themes', 'directory-info' ); ?></h2>

		<table>
			<tr>
				<th><?php esc_html_e( 'Sn', 'directory-info' ); ?></th>
				<th><?php esc_html_e( 'Name', 'directory-info' ); ?></th>
				<th><?php esc_html_e( 'Version', 'directory-info' ); ?></th>
				<th><?php esc_html_e( 'Last Updated', 'directory-info' ); ?></th>
				<th><?php esc_html_e( 'Downloads', 'directory-info' ); ?></th>
				<th><?php esc_html_e( 'Thumbnail', 'directory-info' ); ?></th>
			</tr>
			<?php if ( ! empty( $all_themes ) ) : ?>
				<?php $cnt = 1; ?>
				<?php foreach ( $all_themes as $theme ) : ?>
					<tr>
						<td><?php echo absint( $cnt ); ?></td>
						<td><a href="<?php echo esc_url( $theme['homepage'] ); ?>" target="_blank"><?php echo esc_html( $theme['name'] ); ?></a></td>
						<td><?php echo esc_html( $theme['version'] ); ?></td>
						<td><time class="timeago" datetime="<?php echo esc_attr( $theme['last_updated'] ); ?>"><?php echo esc_html( $theme['last_updated'] ); ?></time></td>
						<td><?php echo esc_html( $theme['downloaded'] ); ?></td>
						<td><img src="<?php echo esc_url( $theme['screenshot_url'] ); ?>" alt="" class="thumb" /></td>
					</tr>
					<?php $cnt++; ?>
				<?php endforeach; ?>

			<?php else : ?>

				<tr>
					<td colspan="6"><?php esc_html_e( 'No theme found.', 'directory-info' ); ?></td>
				</tr>

			<?php endif; ?>

		</table>

	</div><!-- .directory-wrapper .directory-theme-wrapper -->
	<?php

}

/**
 * Render plugins section.
 *
 * @since 1.0.0
 */
function directory_info_render_plugins_section() {

	$plugins_info = directory_info_get_plugins_info();
	$all_plugins = ( isset( $plugins_info['plugins'] ) && ! empty( $plugins_info['plugins'] ) ) ? $plugins_info['plugins'] : array();
	?>
	<div class="directory-wrapper directory-plugin-wrapper">

		<h2><?php esc_html_e( 'Plugins', 'directory-info' ); ?></h2>

		<table>
			<tr>
				<th><?php esc_html_e( 'Sn', 'directory-info' ); ?></th>
				<th><?php esc_html_e( 'Name', 'directory-info' ); ?></th>
				<th><?php esc_html_e( 'Version', 'directory-info' ); ?></th>
				<th><?php esc_html_e( 'Last Updated', 'directory-info' ); ?></th>
				<th><?php esc_html_e( 'Downloads', 'directory-info' ); ?></th>
				<th><?php esc_html_e( 'Thumbnail', 'directory-info' ); ?></th>
			</tr>
			<?php if ( ! empty( $all_plugins ) ) : ?>
				<?php $cnt = 1; ?>
				<?php foreach ( $all_plugins as $plugin ) : ?>
					<tr>
						<td><?php echo absint( $cnt ); ?></td>
						<td><a href="<?php echo esc_url( 'https://wordpress.org/plugins/' . $plugin['slug'] ) . '/'; ?>" target="_blank"><?php echo esc_html( $plugin['name'] ); ?></a></td>
						<td><?php echo esc_html( $plugin['version'] ); ?></td>
						<td><time class="timeago" datetime="<?php echo esc_attr( date( 'Y-m-d', strtotime( $plugin['last_updated'] ) ) ); ?>"><?php echo esc_html( date( 'Y-m-d', strtotime( $plugin['last_updated'] ) ) ); ?></time></td>
						<td><?php echo esc_html( $plugin['downloaded'] ); ?></td>
						<td>
						<?php $screenshots = ( isset( $plugin['screenshots'] ) && ! empty( $plugin['screenshots'] ) ) ? $plugin['screenshots'] : array(); ?>
						<?php if ( ! empty( $screenshots ) ) : ?>
							<?php $first_scr = array_shift( $screenshots ); ?>
							<img src="<?php echo esc_url( $first_scr['src'] ); ?>" alt="" class="thumb" />
						<?php endif; ?>
						</td>
					</tr>
					<?php $cnt++; ?>
				<?php endforeach; ?>

			<?php else : ?>

				<tr>
					<td colspan="6"><?php esc_html_e( 'No plugin found.', 'directory-info' ); ?></td>
				</tr>

			<?php endif; ?>

		</table>

	</div><!-- .directory-wrapper .directory-plugin-wrapper -->
	<?php

}

/**
 * Load admin scripts and styles.
 *
 * @since 1.0.0
 *
 * @param string $hook Admin hook name.
 */
function directory_info_admin_scripts( $hook ) {
	if ( 'dashboard_page_directory-info' !== $hook ) {
		return;
	}

	wp_enqueue_style( 'directory-info-admin', DIRECTORY_INFO_URL . '/css/admin.css', array(), '1.0.0' );
	wp_enqueue_script( 'directory-info-timeago', DIRECTORY_INFO_URL . '/third-party/timeago/jquery.timeago.js', array(), '1.6.0' );
	wp_enqueue_script( 'directory-info-custom', DIRECTORY_INFO_URL . '/js/custom.js', array(), '1.0.0' );
}

add_action( 'admin_enqueue_scripts', 'directory_info_admin_scripts' );

/**
 * Render form.
 *
 * @since 1.0.0
 */
function directory_info_render_form() {

	$current_wporg_id = get_option( 'di_wporg_id' );

	$force_refresh = 0;
	if ( isset( $_POST['force_refresh'] ) && 'true' === $_POST['force_refresh'] ) {
		$force_refresh = 1;
	}
	?>
	<form action="<?php echo esc_url( admin_url( 'index.php?page=directory-info' ) ); ?>" method="post" class="frm-directory-info">
		<?php wp_nonce_field( 'directory_info_run', 'directory_info_nonce' ); ?>
		<div class="theme-switcher-wrap">
			<p>
				<label for="themename">
					<?php esc_html_e( 'Enter WordPress.org ID', 'directory-info' ); ?>
					<input type="text" name="wporg_id" value="<?php echo esc_attr( $current_wporg_id ); ?>" />
				</label>
				<button class="button button-secondary" name="btn-save-di"><?php esc_attr_e( 'GO', 'directory-info' ); ?></button>
			</p>
		</div><!-- .theme-switcher-wrap -->
		<div class="options-wrap">
			<label for="force_refresh"><input type="checkbox" name="force_refresh" id="force_refresh" value="1" <?php checked( $force_refresh, 1 ); ?> /><?php esc_html_e( 'Forced Refresh', 'directory-info' ); ?></label>
		</div><!-- .options-wrap -->
	</form>
	<?php
}

/**
 * Save value.
 *
 * @since 1.0.0
 */
function directory_info_save() {

	if ( isset($_POST['btn-save-di'] ) ) {
		$wporg_id = wp_unslash( $_POST['wporg_id'] );
		update_option( 'di_wporg_id', sanitize_text_field( $wporg_id ) );
	}

}

add_action( 'init', 'directory_info_save' );

/**
 * Add info link on plugin page.
 *
 * @since 1.0.0
 *
 * @param array $links Array of plugin action links.
 * @return array Modified array of plugin action links.
 */
function directory_info_plugin_settings_link( $links ) {

	$directory_info_link = '<a href="index.php?page=directory-info">' . esc_attr__( 'Info Page', 'directory-info' ) . '</a>';
	array_unshift( $links, $directory_info_link );
	return $links;

}

add_filter( 'plugin_action_links_' . DIRECTORY_INFO_BASENAME, 'directory_info_plugin_settings_link' );
