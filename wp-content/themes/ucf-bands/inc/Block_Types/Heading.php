<?php
/**
 * Heading block type "extension"
 *
 * @since   4.0.0
 * @package UCF\Theme
 */

declare( strict_types = 1 );

namespace UCF\Theme\Block_Types;

/**
 * Adjustment + additional assets manager for core heading block type
 *
 * @since 4.0.0
 */
class Heading extends Extension {

	/**
	 * Block type name
	 *
	 * @since 4.0.0
	 * @var   string
	 */
	protected string $name = 'core/heading';

	/**
	 * Available font families in typography settings
	 *
	 * @var string[]
	 */
	protected array $font_families = [ 'body-alt', 'display' ];
}
