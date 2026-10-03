<?php
/**
 * Plugin wrapper
 *
 * @since   1.0.0
 * @package UCF\Utils
 */

declare( strict_types = 1 );

namespace UCF\Utils;

use UCF\Utils\Structures\Admin_Tag;

/**
 * Plugin wrapper
 *
 * @since 1.0.0
 */
class Plugin {
	use Singleton;

	/**
	 * Hook things in
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		Admin_Tag::get_instance();
	}
}
