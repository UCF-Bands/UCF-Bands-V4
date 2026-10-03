<?php
/**
 * Theme entry point
 *
 * @package UCF\Theme
 * @since   4.0.0
 */

declare( strict_types = 1 );

namespace UCF\Theme;

use function UCF\Utils\autoload_register;

define( 'UCF_THEME_DIR', get_stylesheet_directory() );
define( 'UCF_THEME_URL', get_stylesheet_directory_uri() );

require_once __DIR__ . '/dependencies.php';
if ( ! check_dependencies( [ 'ucf-bands-utils/ucf-bands-utils.php' => 'UCF Bands Utils' ] ) ) {
	return;
}

// Utils does not need to be loaded manually here since thmes load after plugins.

// Setup autoloader (via Composer or custom).
if ( file_exists( UCF_THEME_DIR . '/vendor/autoload.php' ) ) {
	require UCF_THEME_DIR . '/vendor/autoload.php';
} else {
	autoload_register( __NAMESPACE__, UCF_THEME_DIR );
}
