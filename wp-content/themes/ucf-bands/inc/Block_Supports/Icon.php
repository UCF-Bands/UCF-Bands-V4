<?php
/**
 * Icon "block support"
 *
 * @since   4.0.0
 * @package UCF\Theme
 */

declare( strict_types = 1 );

namespace UCF\Theme\Block_Supports;

use WP_Block_Type;

/**
 * Abstract for a custom "block support"
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-supports/
 * @see https://github.com/WordPress/gutenberg/discussions/71012
 * @see https://github.com/theaminulai/animate-support/blob/main/includes/animate-block-support.php
 *
 * @since 4.0.0
 */
class Icon {
	use Support;

	/**
	 * Block support name.
	 *
	 * Note: This will be prefixed with "ucf" and automaticaly be camel-cased.
	 *
	 * @since 4.0.0
	 *
	 * @return string
	 */
	protected static function get_name(): string {
		return 'icon';
	}

	/**
	 * Do block attribute registration
	 *
	 * At this point, the block type has already been checked for support and
	 * $block_type->attributes should be an (potentially empty) array.
	 *
	 * @see example: wp_register_aria_label_support()
	 */
	protected function do_attribute_registration( WP_Block_Type $block_type ): void {

		if ( ! array_key_exists( 'ucfIconPrefix', $block_type->attributes ) ) {
			$block_type->attributes['ucfIconPrefix'] = [
				'type' => 'string',
			];
		}

		if ( ! array_key_exists( 'ucfIconName', $block_type->attributes ) ) {
			$block_type->attributes['ucfIconName'] = [
				'type' => 'string',
			];
		}
	}
}
