<?php
/**
 * Block type "extension"
 *
 * @since   4.0.0
 * @package UCF\Theme
 */

declare( strict_types = 1 );

namespace UCF\Theme;

/**
 * Adjustment + additional assets manager for external block type
 *
 * @since 4.0.0
 */
class Block_Type_Extension {

	/**
	 * Scripts to enqueue in editor
	 *
	 * @since 4.0.0
	 * @var  array
	 */
	private $editor_scripts = [];

	/**
	 * Set things up
	 *
	 * @since 4.0.0
	 *
	 * @param string $name  Block type name.
	 */
	public function __construct( private string $name ) {
		add_filter( 'register_block_type_args', [ $this, 'add_assets' ], 10, 2 );
		add_action( 'enqueue_block_editor_assets', [ $this, 'enqueue_editor_assets' ] );
	}

	/**
	 * Add CSS/JS assets to (third-party) block type
	 *
	 * @since 4.0.0
	 *
	 * @param  array  $args        Array of arguments for registering a block type.
	 * @param  string $block_type  Block type name including namespace.
	 */
	public function add_assets( array $args, string $block_type ): array {

		// Sanity-check block type name.
		if ( $this->name !== $block_type ) {
			return $args;
		}

		$build_dir  = UCF_THEME_DIR . "/build/block-types/{$this->name}";
		$build_url  = UCF_THEME_URL . "/build/block-types/{$this->name}";
		$asset_path = "{$build_dir}/index.asset.php";
		$extra_args = [];

		if ( ! file_exists( $asset_path ) ) {
			_doing_it_wrong(
				__METHOD__,
				wp_kses_post( "\"{$this->name}\" block type extension doesn't have a @wordpress/scripts asset PHP file." ),
				'ucf-bands'
			);
			return $args;
		}

		$asset  = require $asset_path;
		$handle = Theme::HANDLE_PREFIX . 'block-' . str_replace( '/', '-', $this->name );

		// Editor-only JS. $args doesn't have a spot for this so we're saving it for enqueue_block_editor_assets.
		if ( file_exists( "{$build_dir}/index.js" ) ) {
			$this->editor_scripts[ $handle ] = [
				"{$build_url}/index.js",
				$asset['dependencies'],
				$asset['version']
			];
		}

		// Shared CSS (style.scss).
		if ( file_exists( "{$build_dir}/style-index.css" ) ) {
			wp_register_style(
				$handle,
				"{$build_url}/style-index.css",
				[ 'wp-block-library' ], // Should this also have the specific block type? (see metro).
			);
			$extra_args['style_handles'] = [ $handle ];
		}

		$args = array_merge_recursive( $args, $extra_args );

		return $args;
	}

	/**
	 * Enqueue block editor assets
	 *
	 * @since 4.0.0
	 */
	public function enqueue_editor_assets(): void {

		foreach ( $this->editor_scripts as $handle => $args ) {
			wp_enqueue_script( $handle, $args[0], $args[1], $args[2], true );
		}
	}
}
