<?php
/**
 * "View" trait for handling assets
 *
 * @since   4.0.0
 * @package UCF\Theme
 */

declare( strict_types = 1 );

namespace UCF\Theme;

/**
 * "View" trait for CSS/JS assets
 *
 * @since 4.0.0
 */
trait View {
	use \UCF\Utils\View;

	/**
	 * Get script/style handle prefix
	 *
	 * @since  4.0.0
	 * @return string
	 */
	protected static function get_handle_prefix(): string {
		return Theme::HANDLE_PREFIX;
	}

	/**
	 * Get asset build directory path
	 *
	 * @since  4.0.0
	 * @return string
	 */
	protected static function get_build_dir(): string {
		return UCF_THEME_DIR . '/build';
	}

	/**
	 * Get asset build directory URL
	 *
	 * @since  4.0.0
	 * @return string
	 */
	protected static function get_build_url(): string {
		return UCF_THEME_URL . '/build';
	}


	/**
	 * Get default CSS dependency handles
	 *
	 * Use for "global" CSS depdency checks that don't need to be overwritten
	 * at the View-extended class level.
	 *
	 * @since 1.0.0
	 */
	protected function get_default_css_dependencies(): array {

		return Shared::NAME === self::get_view_name()
			? []
			: [ Shared::get_handle() ];
	}
}
