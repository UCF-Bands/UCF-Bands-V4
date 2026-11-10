<?php
/**
 * Block supports management
 *
 * @since   4.0.0
 * @package UCF\Theme
 */

declare( strict_types = 1 );

namespace UCF\Theme\Block_Supports;

use UCF\Utils\Singleton;

/**
 * Block type "supports" registration/management
 *
 * @since 4.0.0
 */
class Block_Supports {
	use Singleton;

	/**
	 * Set things up
	 *
	 * @since 4.0.0
	 */
	public function __construct() {
		Icon::get_instance();
	}
}
