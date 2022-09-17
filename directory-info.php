<?php
/**
 * Plugin Name:       Directory Info
 * Plugin URI:        https://github.com/ernilambar/directory-info/
 * Description:       Info of themes and plugins.
 * Version:           1.0.0
 * Author:            Nilambar Sharma
 * Author URI:        http://www.nilambar.net/
 * Text Domain:       directory-info
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package Directory_Info
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'DIRECTORY_INFO_VERSION', '1.0.0' );
define( 'DIRECTORY_INFO_BASENAME', plugin_basename( __FILE__ ) );
define( 'DIRECTORY_INFO_DIR', rtrim( plugin_dir_path( __FILE__ ), '/' ) );
define( 'DIRECTORY_INFO_URL', rtrim( plugin_dir_url( __FILE__ ), '/' ) );

// Load autoload.
if ( file_exists(  DIRECTORY_INFO_DIR . '/vendor/autoload.php' ) ) {
	require_once DIRECTORY_INFO_DIR . '/vendor/autoload.php';
}

// Load helpers.
require_once DIRECTORY_INFO_DIR . '/inc/helpers.php';

// Load admin.
require_once DIRECTORY_INFO_DIR . '/inc/admin.php';

