<?php
/**
 * Plugin Name:       Directory Info
 * Plugin URI:        https://github.com/ernilambar/directory-info
 * Description:       Info of themes and plugins.
 * Version:           1.0.0
 * Author:            Nilambar Sharma
 * Author URI:        http://nilambar.net
 * Text Domain:       directory-info
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package Theme_Sniffer
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'DIRECTORY_INFO_BASENAME', plugin_basename( __FILE__ ) );
define( 'DIRECTORY_INFO_DIR', rtrim( plugin_dir_path( __FILE__ ), '/' ) );
define( 'DIRECTORY_INFO_URL', rtrim( plugin_dir_url( __FILE__ ), '/' ) );

// Load helpers.
require_once DIRECTORY_INFO_DIR . '/inc/helpers.php';

// Load admin.
require_once DIRECTORY_INFO_DIR . '/inc/admin.php';

require_once DIRECTORY_INFO_DIR . '/vendor/autoload.php';
