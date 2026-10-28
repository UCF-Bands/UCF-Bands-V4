<?php
/**
 * Block type management
 *
 * @since   4.0.0
 * @package UCF\Theme
 */

declare( strict_types = 1 );

namespace UCF\Theme;

use UCF\Utils\Singleton;

/**
 * Block type registration/extension/management
 *
 * @since 4.0.0
 */
class Block_Types {
	use Singleton;

	/**
	 * Block type extension registry
	 *
	 * @since 4.0.0
	 * @var   string[]
	 */
	private const EXTENSIONS = [
		'core/cover',
	];

	/**
	 * Set things up
	 *
	 * @since 4.0.0
	 */
	public function __construct() {

		foreach ( self::EXTENSIONS as $block_type ) {
			new Block_Type_Extension( $block_type );
		}
	}
}
