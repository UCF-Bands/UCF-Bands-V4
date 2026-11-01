<?php
/**
 * Block type management
 *
 * @since   4.0.0
 * @package UCF\Theme
 */

declare( strict_types = 1 );

namespace UCF\Theme\Block_Types;

use UCF\Utils\Singleton;

/**
 * Block type registration/extension/management
 *
 * @since 4.0.0
 */
class Block_Types {
	use Singleton;

	/**
	 * Set things up
	 *
	 * @since 4.0.0
	 */
	public function __construct() {

		// Register custom block types and block type extensions.
		new Extension( 'core/cover' );
		new Extension( 'core/heading' );
		new Extension( 'core/paragraph' );
		new Heading();

		add_filter( 'register_block_type_args', [ $this, 'set_block_type_args' ] );
	}

	/**
	 * Set block type registration args
	 *
	 * @since 4.0.0
	 *
	 * @param  array $args  Block type args.
	 * @return array $args
	 */
	public function set_block_type_args( array $args ) {

		// Show font family control by default.
		if (
			( $args['supports']['typography']['__experimentalFontFamily'] ?? false )
			|| ( $args['supports']['typography']['fontFamily'] ?? false )
		) {
			$args['supports']['typography']['__experimentalDefaultControls']['fontFamily'] = true;
		}

		return $args;
	}
}
