<?php
/**
 * Main theme handler
 *
 * @since   4.0.0
 * @package UCF\Theme
 */

declare( strict_types = 1 );

namespace UCF\Theme;

use UCF\Theme\Block_Supports\Block_Supports;
use UCF\Theme\Block_Types\Block_Types;
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
	 * Customizer setting/control prefix
	 *
	 * @since 4.0.0
	 * @var   string
	 */
	const CUSTOMIZER_PREFIX = 'ucf_';

	/**
	 * Set things up
	 *
	 * @since 4.0.0
	 */
	public function __construct() {
		Block_Types::get_instance();
		Block_Supports::get_instance();
		Editor::get_instance();
		Shared::get_instance();
		SpaceU::get_instance();
	}
}
