<?php
/**
 * "View" trait for handling assets
 *
 * @since   1.0.0
 * @package UCF\Utils
 */

declare( strict_types = 1 );

namespace UCF\Utils;

use UCF\Utils\Singleton;

/**
 * "View" trait for CSS/JS assets
 *
 * @since 1.0.0
 */
trait View {
	use Singleton;

	/**
	 * Get script/style handle prefix
	 *
	 * @since  1.0.0
	 * @return string
	 */
	protected static function get_handle_prefix(): string {
		return 'ucf-';
	}

	/**
	 * Get asset build directory path
	 *
	 * @since  1.0.0
	 * @return string
	 */
	protected static function get_build_dir(): string {
		return UCF_UTILS_DIR . '/build';
	}

	/**
	 * Get asset build directory URL
	 *
	 * @since  1.0.0
	 * @return string
	 */
	protected static function get_build_url(): string {
		return UCF_UTILS_URL . '/build';
	}

	/**
	 * Hook things in
	 *
	 * @since 1.0.0
	 */
	protected function __construct() {
		$this->add_enqueue_hook();
	}

	/**
	 * Is the current request for the view?
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	protected function is_view(): bool {
		return false;
	}

	/**
	 * Get view name
	 *
	 * It should line up with an asset in ./build/views/%name%.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	protected static function get_view_name(): string {
		return '';
	}

	/**
	 * Is this view supposed to be manually printed?
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	protected static function is_printed(): bool {
		return false;
	}

	/**
	 * Get default CSS dependency handles
	 *
	 * Use for "global" CSS depdency checks that don't need to be overwritten
	 * at the View-extended class level.
	 *
	 * @since 1.0.0
	 */
	protected function get_default_css_dependencies(): array {
		return [];
	}

	/**
	 * Get CSS dependency handles
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	protected function get_css_dependencies(): array {
		return [];
	}

	/**
	 * Get style media scope/type
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	protected function get_style_media(): string {
		return 'all';
	}

	/**
	 * Get non-bundled JS dependency handles
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	protected function get_js_dependencies(): array {
		return [];
	}

	/**
	 * Get wp_enqueue_scripts hook priority.
	 *
	 * @since 1.0.0
	 *
	 * @return int
	 */
	protected function get_enqueue_scripts_priority(): int {
		return 10;
	}

	/**
	 * Add enqueue_scripts hook
	 *
	 * @since 1.0.0
	 */
	protected function add_enqueue_hook(): void {

		add_action(
			'enqueue_block_assets',
			[ $this, 'enqueue_assets' ],
			$this->get_enqueue_scripts_priority()
		);

		add_filter( 'style_loader_tag', [ $this, 'set_style_tag' ], 10, 4 );
	}

	/**
	 * Get asset handle
	 *
	 * @since 1.0.0
	 */
	public static function get_handle(): string {

		return static::get_view_name()
			? self::get_handle_prefix() . 'view-' . static::get_view_name()
			: '';
	}

	/**
	 * Enqueue CSS and/or JS assets
	 *
	 * @since 1.0.0
	 */
	public function enqueue_assets(): void {

		$name       = self::get_view_name();
		$is_printed = self::is_printed();

		// Bounce if there's no name or it's not the view and can't be printed.
		if ( ! $name || ( ! $is_printed && ! $this->is_view() ) ) {
			return;
		}

		$build_dir  = self::get_build_dir() . "/views/{$name}";
		$build_url  = self::get_build_url() . "/views/{$name}";
		$asset_path = "{$build_dir}/index.asset.php";

		if ( ! file_exists( $asset_path ) ) {
			_doing_it_wrong(
				__METHOD__,
				wp_kses_post( "\"{$name}\" view doesn't have a @wordpress/scripts asset PHP file." ),
				'ucf-bands'
			);
		}

		$asset  = require $asset_path;
		$handle = self::get_handle();

		// Check for JS.
		if ( file_exists( "{$build_dir}/index.js" ) ) {
			wp_register_script(
				$handle,
				"{$build_url}/index.js",
				array_merge(
					$asset['dependencies'],
					$this->get_js_dependencies()
				),
				$asset['version'],
				[ 'in_footer' => true ]
			);

			if ( ! $is_printed ) {
				wp_enqueue_script( $handle );
			}
		}

		// Check for front-end CSS (style.scss).
		if ( file_exists( "{$build_dir}/style-index.css" ) ) {
			wp_register_style(
				$handle,
				"{$build_url}/style-index.css",
				array_merge(
					$this->get_default_css_dependencies(),
					$this->get_css_dependencies()
				),
				$asset['version'],
				$this->get_style_media()
			);

			// Add path to style data so it can potentially be inlined via
			// wp_maybe_inline_styles().
			wp_style_add_data( $handle, 'path', "{$build_dir}/style-index.css" );

			if ( ! $is_printed ) {
				wp_enqueue_style( $handle );
			}
		}

		$this->enqueue_extra_assets();
	}

	/**
	 * Enqueue extra assets.
	 *
	 * @since 1.0.0
	 */
	protected function enqueue_extra_assets(): void {}

	/**
	 * Should the style be deferred?
	 *
	 * @since 1.0.0
	 * @var   bool
	 */
	protected function is_style_deferred(): bool {
		return true;
	}

	/**
	 * Set style <link> tag HTML/attributes.
	 *
	 * @since 1.0.0
	 *
	 * @param  string $tag     The link tag for the enqueued style.
	 * @param  string $handle  The style's registered handle.
	 * @param  string $href    The stylesheet's source URL.
	 * @param  string $media   The stylesheet's media attribute.
	 * @return string
	 */
	public function set_style_tag( string $tag, string $handle, string $href, string $media ): string {

		return ! is_admin()
			&& $this->is_style_deferred()
			&& self::get_handle() === $handle
			? Assets::set_defer_on_style_tag( $tag, $media, $href )
			: $tag;
	}

	/**
	 * Print the scripts (manually)
	 *
	 * @since 1.0.0
	 */
	public static function print(): void {

		if ( ! static::is_printed() ) {
			_doing_it_wrong(
				__METHOD__,
				"View assets are being printed manually even though it's not configured to do so.",
				'ucf-utils'
			);
		}

		$handle = self::get_handle_prefix() . 'view-' . static::get_view_name();

		wp_print_styles( $handle );
		wp_print_scripts( $handle );
	}
}
