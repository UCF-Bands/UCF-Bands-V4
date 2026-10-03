<?php
/**
 * Content editor adjustments
 *
 * @since   4.0.0
 * @package UCF\Theme
 */

declare( strict_types = 1 );

namespace UCF\Theme;

use UCF\Utils\Singleton;

/**
 * General block/content editor adjustments
 *
 * @since 4.0.0
 */
class Editor {
	use Singleton;

	/**
	 * Set things up
	 *
	 * @since 4.0.0
	 */
	public function __construct() {
		add_filter( 'block_editor_settings_all', [ $this, 'set_settings' ] );
	}

	/**
	 * Set editor settings
	 *
	 * @since 4.0.0
	 *
	 * @param array $settings  Existing editor settings.
	 */
	public function set_settings( array $settings ): array {

		/**
		 * Disable font library.
		 *
		 * @todo Use potental "font-library" theme support, once available
		 * @see  https://github.com/WordPress/gutenberg/pull/79027
		 */
		$settings['fontLibraryEnabled'] = false;

		return $settings;
	}
}
