<?php
/**
 * Block "support" that can be used during block type registration/extension
 *
 * @since   4.0.0
 * @package UCF\Theme
 */

declare( strict_types = 1 );

namespace UCF\Theme\Block_Supports;

use UCF\Theme\Theme;
use UCF\Theme\View;
use WP_Block_Supports;
use WP_Block_Type;

use function UCF\Utils\get_camel_case;

/**
 * Abstract for a custom "block support"
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-supports/
 * @see https://github.com/WordPress/gutenberg/discussions/71012
 * @see https://github.com/theaminulai/animate-support/blob/main/includes/animate-block-support.php
 *
 * @since 4.0.0
 */
trait Support {
	use View;

	/**
	 * Block support name.
	 *
	 * @since 4.0.0
	 *
	 * @return string
	 */
	protected static function get_name(): string {
		return '';
	}

	/**
	 * Get prefixed/namespaced name
	 *
	 * @since 4.0.0
	 *
	 * @return string
	 */
	protected static function get_prefixed_name(): string {
		return 'ucf-' . self::get_name();
	}

	/**
	 * Get prefixed camel-case name
	 *
	 * Used for registration + attribute(s).
	 *
	 * @since 4.0.0
	 *
	 * @return string
	 */
	protected static function get_camel_case_name(): string {
		return get_camel_case( self::get_prefixed_name() );
	}

	/**
	 * Get asset handle prefix
	 *
	 * @since 4.0.0
	 *
	 * @return string
	 */
	protected static function get_handle_prefix(): string {
		return Theme::HANDLE_PREFIX . 'block-support-';
	}

	/**
	 * Get asset build sub-directory path
	 *
	 * @since 4.0.0
	 *
	 * @return string
	 */
	protected static function get_build_sub_dir(): string {
		return 'block-supports';
	}

	/**
	 * Get view name
	 *
	 * @since 4.0.0
	 *
	 * @return string
	 */
	protected static function get_view_name(): string {
		return self::get_name();
	}

	/**
	 * Is the current request for the view?
	 *
	 * @since 4.0.0
	 *
	 * @return bool
	 */
	protected function is_view(): bool {
		return true;
	}

	/**
	 * Register the block support
	 *
	 * @since 4.0.0
	 */
	protected function do_additional_setup(): void {

		WP_Block_Supports::get_instance()->register(
			self::get_prefixed_name(),
			[
				'register_attribute' => [ $this, 'do_registration' ],
				'apply'              => [ $this, 'apply' ],
			]
		);
	}

	/**
	 * Do support registration
	 *
	 * @see example: register_aria_label_support()
	 *
	 * @since 4.0.0
	 *
	 * @param WP_Block_Type $block_type  Block type.
	 */
	public function do_registration( WP_Block_Type $block_type ): void {

		if ( ! block_has_support( $block_type, [ self::get_camel_case_name() ], false ) ) {
			return;
		}

		if ( ! $block_type->attributes ) {
			$block_type->attributes = [];
		}

		$this->do_attribute_registration( $block_type );
	}

	/**
	 * Do block attribute registration
	 *
	 * At this point, the block type has already been checked for support and
	 * $block_type->attributes should be an (potentially empty) array.
	 *
	 * @see example: wp_register_aria_label_support()
	 */
	protected function do_attribute_registration( WP_Block_Type $block_type ): void {}

	/**
	 * Apply attributes to the block output
	 *
	 * @see example: wp_apply_aria_label_support()
	 *
	 * @since 4.0.0
	 *
	 * @param  WP_Block_Type $block_type        Block type.
	 * @param  array         $block_attributes  Block attributes.
	 * @return array
	 */
	public function apply( WP_Block_Type $block_type, array $block_attributes ): array {

		// Do sanity checks.
		if (
			! $block_attributes
			|| ! block_has_support( $block_type, [ self::get_camel_case_name() ], false )
			|| wp_should_skip_block_supports_serialization( $block_type, self::get_camel_case_name() )
		) {
			return [];
		}

		return $this->get_attributes_to_apply( $block_type, $block_attributes );
	}

	/**
	 * Get HTML attributes to apply to block
	 *
	 * @since 4.0.0
	 *
	 * @param  WP_Block_Type $block_type        Block type.
	 * @param  array         $block_attributes  Block attributes.
	 * @return array
	 */
	protected function get_attributes_to_apply( WP_Block_Type $block_type, array $block_attributes ): array {
		return [];
	}
}
