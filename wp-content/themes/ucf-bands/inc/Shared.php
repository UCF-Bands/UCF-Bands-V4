<?php
/**
 * Global/shared CSS/JS handling
 *
 * @since   4.0.0
 * @package UCF\Theme
 */

namespace UCF\Theme;

use FortAwesome\FontAwesome;

use function FortAwesome\fa;

/**
 * Global CSS/JS handling
 *
 * @since 4.0.0
 */
class Shared {
	use View;

	/**
	 * View name
	 *
	 * @since 4.0.0
	 * @var   string
	 */
	public const NAME = 'shared';

	/**
	 * Hook things in
	 *
	 * @since 4.0.0
	 */
	public function __construct() {
		// We may not need this.
		// phpcs:ignore Squiz.PHP.CommentedOutCode.Found
		// add_action( 'after_setup_theme', [ $this, 'add_editor_styles' ] );.
		$this->add_enqueue_hook();
	}

	/**
	 * Get wp_enqueue_scripts hook priority.
	 *
	 * Elevated so gform_basic can potentially be enqueued.
	 */
	protected function get_enqueue_scripts_priority(): int {
		return 15;
	}

	/**
	 * Get view directory name
	 *
	 * @since 4.0.0
	 *
	 * @return string
	 */
	protected static function get_view_name(): string {
		return self::NAME;
	}

	/**
	 * Is the request for this view?
	 *
	 * @since 4.0.0
	 *
	 * @return bool
	 */
	protected function is_view(): bool {
		return true;
	}

	/**
	 * Get CSS dependency handles
	 *
	 * @since 4.0.0
	 *
	 * @return array
	 */
	protected function get_css_dependencies(): array {

		return array_filter(
			[
				wp_style_is( 'gform_basic' ) ? 'gform_basic' : null,
				wp_style_is( 'select2' ) ? 'select2' : null,
			]
		);
	}

	/**
	 * Should the style be deferred?
	 *
	 * @since 4.0.0
	 * @var   bool
	 */
	protected function is_style_deferred(): bool {
		return false;
	}

	/**
	 * Enqueue extra assets.
	 *
	 * @since 4.0.0
	 */
	protected function enqueue_extra_assets(): void {

		// // Globally-available block styles.
		// Blocks::enqueue_core_block_styles( 'heading' );
		// Blocks::enqueue_core_block_styles( 'button' );

		// Enqueue backup FontAwesome kit if plugin isn't configured.
		// init is too early for this check.
		if ( ! class_exists( FontAwesome::class ) || ! fa()->using_kit() ) {
			// phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion, WordPress.WP.EnqueuedResourceParameters.NotInFooter
			wp_enqueue_script(
				Theme::HANDLE_PREFIX . 'font-awesome',
				'https://kit.fontawesome.com/bfd47f16db.js'
			);
		}
	}

	/**
	 * Enqueue editor styles
	 *
	 * This is used instead of enqueue_block_assets because it gets us around
	 * the annoying .editor-styles-wrapper CSS scoping issue.
	 *
	 * @since 4.0.0
	 */
	public function add_editor_styles(): void {

		// This is automatic in block themes but required in our hybrid.
		add_theme_support( 'editor-styles' );

		add_editor_style( 'build/views/shared/index.css' );
		add_editor_style( 'build/views/shared/style-index.css' );
	}
}
