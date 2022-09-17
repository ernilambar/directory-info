<?php
/**
 * Plugin Name: Directory Info
 * Plugin URI: https://github.com/ernilambar/directory-info/
 * Description: Info of themes and plugins.
 * Version: 1.0.1
 * Author: Nilambar Sharma
 * Author URI: https://www.nilambar.net/
 * Text Domain: directory-info
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package Directory_Info
 */

namespace DirectoryInfo;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'DIRECTORY_INFO_VERSION', '1.0.1' );
define( 'DIRECTORY_INFO_SLUG', 'directory-info' );
define( 'DIRECTORY_INFO_BASENAME', plugin_basename( __FILE__ ) );
define( 'DIRECTORY_INFO_BASE_FILENAME', plugin_basename( __FILE__ ) );
define( 'DIRECTORY_INFO_DIR', rtrim( plugin_dir_path( __FILE__ ), '/' ) );
define( 'DIRECTORY_INFO_URL', rtrim( plugin_dir_url( __FILE__ ), '/' ) );

// Include autoload.
if ( file_exists(  DIRECTORY_INFO_DIR . '/vendor/autoload.php' ) ) {
	require_once DIRECTORY_INFO_DIR . '/vendor/autoload.php';
}

if ( class_exists( 'DirectoryInfo\Init' ) ) {
	\DirectoryInfo\Init::register_services();
}
