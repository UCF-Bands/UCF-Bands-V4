<?php
/**
 * Plugin dependencies check
 *
 * @since   4.0.0
 * @package UCF\Theme
 */

declare( strict_types = 1 );

namespace UCF\Theme;

/**
 * Check dependent plugins, registering notices for each.
 *
 * @since 4.0.0
 *
 * @param array<string, string> $plugins  Required WordPress plugin paths, keyed by plugin path pointing to the plugin name.
 */
function check_dependencies( array $plugins ): bool {

	$missing = [];
	foreach ( $plugins as $path => $name ) {

		if ( ! is_plugin_active( $path ) ) {
			$missing[] = $name;
		}
	}

	if ( $missing ) {
		$callback = function () use ( $missing ) {
			?>
			<div class="notice notice-error">
				<p><?php esc_html_e( 'The following plugins are required for the UCF Bands theme to load properly:', 'ucf' ); ?></p>
				<ul style="list-style-type: disc; padding-left: 1.333rem; margin: 0.5rem 0 0.75rem;">
					<li>
						<?php echo wp_kses_post( implode( '</li><li>', $missing ) ); ?>
					</li>
				</ul>
			</div>
			<?php
		};

		add_action( 'admin_notices', $callback );
	}

	return empty( $missing );
}
