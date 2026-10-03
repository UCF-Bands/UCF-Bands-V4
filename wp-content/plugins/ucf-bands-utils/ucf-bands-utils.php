<?php
/**
 * Plugin Name: UCF Bands Utils
 * Plugin URI: https://ucfbands.com
 * Description: Global utilities for UCF Bands.
 * Author: Jordan Pakrosnis <jpak@jordanpak.com>
 * Author URI: https://jordanpak.com
 * Version: 1.0.0
 * License: Proprietary
 * Text Domain: ucf
 *
 * @package UCF\Utils
 */

namespace UCF\Utils;

define( 'UCF_UTILS_DIR', plugin_dir_path( __FILE__ ) );
define( 'UCF_UTILS_URL', plugin_dir_url( __FILE__ ) );

if ( ! defined( 'UCF_UTILS_ERROR_EMAIL' ) ) {
	define( 'UCF_UTILS_ERROR_EMAIL', 'jpakmedia@gmail.com' );
}

require __DIR__ . '/inc/functions.php';

// Setup autoloader (via Composer or custom).
if ( file_exists( UCF_UTILS_DIR . 'vendor/autoload.php' ) ) {
	require UCF_UTILS_DIR . 'vendor/autoload.php';
} else {
	autoload_register( __NAMESPACE__, UCF_UTILS_DIR );
}

Plugin::get_instance();
