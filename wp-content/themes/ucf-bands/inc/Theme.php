<?php
/**
 * Main theme handler
 *
 * @since   4.0.0
 * @package UCF\Theme
 */

declare( strict_types = 1 );

namespace UCF\Theme;

use UCF\Utils\Singleton;

/**
 * Theme wrapper
 *
 * @since 4.0.0
 */
class Theme {
	use Singleton;

	/**
	 * Asset handle prefix
	 *
	 * @since 4.0.0
	 * @var   string
	 */
	const HANDLE_PREFIX = 'ucf-theme-';

	/**
	 * Set things up
	 *
	 * @since 4.0.0
	 */
	public function __construct() {
		Block_Types::get_instance();
		Editor::get_instance();
		Shared::get_instance();
	}
}
