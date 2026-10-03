<?php
/**
 * Singleton trait
 *
 * @since   1.0.0
 * @package UCF\Utils
 */

declare( strict_types = 1 );

namespace UCF\Utils;

/**
 * Singleton trait
 */
trait Singleton {
	/**
	 * The instance
	 */
	// phpcs:ignore Squiz.Commenting.VariableComment.MissingVar, Squiz.Commenting.VariableComment.Missing
	protected static $instance = [];

	/**
	 * Constructor
	 */
	protected function __construct() {}

	/**
	 * Get the instance
	 *
	 * @return object|static
	 */
	final public static function get_instance() {

		// Allow for compatibility with sub-classes (those extending something
		// that uses this trait).
		$called_class = get_called_class();

		if ( ! isset( static::$instance[ $called_class ] ) ) {
			static::$instance[ $called_class ] = new $called_class();
		}

		return static::$instance[ $called_class ];
	}
}
