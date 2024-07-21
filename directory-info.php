<?php
/**
 * Plugin Name: Directory Info
 * Plugin URI: https://github.com/ernilambar/directory-info/
 * Description: Info of themes and plugins.
 * Version: 1.0.6
 * Author: Nilambar Sharma
 * Author URI: https://www.nilambar.net/
 * Text Domain: directory-info
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package Directory_Info
 */

namespace DirectoryInfo;

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'DIRECTORY_INFO_VERSION', '1.0.6' );
define( 'DIRECTORY_INFO_SLUG', 'directory-info' );
define( 'DIRECTORY_INFO_BASE', basename( __DIR__ ) );
define( 'DIRECTORY_INFO_BASENAME', plugin_basename( __FILE__ ) );
define( 'DIRECTORY_INFO_BASE_FILENAME', plugin_basename( __FILE__ ) );
define( 'DIRECTORY_INFO_DIR', rtrim( plugin_dir_path( __FILE__ ), '/' ) );
define( 'DIRECTORY_INFO_URL', rtrim( plugin_dir_url( __FILE__ ), '/' ) );

if ( ! defined( 'WP_WELCOME_DIR' ) ) {
	define( 'WP_WELCOME_DIR', DIRECTORY_INFO_DIR . '/vendor/ernilambar/wp-welcome' );
}

if ( ! defined( 'WP_WELCOME_URL' ) ) {
	define( 'WP_WELCOME_URL', DIRECTORY_INFO_URL . '/vendor/ernilambar/wp-welcome' );
}

// Include autoload.
if ( file_exists( DIRECTORY_INFO_DIR . '/vendor/autoload.php' ) ) {
	require_once DIRECTORY_INFO_DIR . '/vendor/autoload.php';
	require_once DIRECTORY_INFO_DIR . '/vendor/ernilambar/optioner/optioner.php';
	require_once DIRECTORY_INFO_DIR . '/vendor/ernilambar/wp-welcome/init.php';
}

if ( class_exists( 'DirectoryInfo\Init' ) ) {
	Init::register_services();
}

$di_update_checker = PucFactory::buildUpdateChecker( 'https://github.com/ernilambar/directory-info', __FILE__, DIRECTORY_INFO_SLUG );
$di_update_checker->getVcsApi()->enableReleaseAssets();
