<?php
/**
 * CSS/JS modifications handler.
 *
 * @since   1.0.0
 * @package UCF\Utils
 */

namespace UCF\Utils;

use UCF\Utils\Singleton;

/**
 * CSS/JS actions and modifications.
 *
 * @since 1.0.0
 */
class Assets {
	use Singleton;

	/**
	 * Hook things in
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_filter( 'wp_resource_hints', [ $this, 'add_hints' ], 10, 2 );
	}

	/**
	 * Add resource hints
	 *
	 * @since 1.0.0
	 *
	 * @param  array  $urls           URLs.
	 * @param  string $relation_type  The relation type the URLs are printed for.
	 * @return array
	 */
	public function add_hints( array $urls, string $relation_type ): array {

		if ( 'preconnect' === $relation_type ) {
			$urls[] = home_url( '', 'https' );
		}

		return $urls;
	}

	/**
	 * Modify HTML <link> to defer its loading
	 *
	 * @since 1.0.0
	 *
	 * @see https://web.dev/articles/defer-non-critical-css#optimize
	 *
	 * @param  string $tag    Style <link> tag.
	 * @param  string $media  Media attribute.
	 * @param  string $href   Source URL.
	 * @return string
	 */
	public static function set_defer_on_style_tag( string $tag, string $media, string $href ): string {

		$tag = str_replace(
			"rel='stylesheet'",
			"rel='preload'",
			$tag
		);

		$tag = str_replace(
			"media='{$media}'",
			"media='{$media}' as='style' onload='this.onload=null;this.rel=\"stylesheet\"'",
			$tag
		);

		// phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedStylesheet
		$tag .= "<noscript><link rel='stylesheet' href='{$href}'></noscript>";

		return $tag;
	}
}
