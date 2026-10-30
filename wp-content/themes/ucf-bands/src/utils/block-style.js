/**
 * Block style helpers
 *
 * @since 4.0.0
 */

import { registerBlockStyle } from '@wordpress/blocks';

/**
 * Register a "block style" with the "ucf-" prefix
 *
 * @since 4.0.0
 *
 * @param {string} blockName Block name to register the style for (e.g. "core/heading").
 * @param {string} name      Style slug without prefix (e.g. "foo" registers "ucf-foo").
 * @param {string} label     Style label shown in the editor.
 */
export function registerStyle( blockName, name, label ) {
	registerBlockStyle( blockName, {
		name: `ucf-${ name }`,
		label,
	} );
}

/**
 * Get block's "block style" value without prefix
 *
 * @since 4.0.0
 *
 * @param {string} [className] Block's className attribute (e.g. "is-style-ucf-foo").
 * @return {string} Block style slug without the "is-style-ucf-" prefix, or an empty string.
 */
export function getStyle( className ) {
	return className && className.startsWith( 'is-style-ucf-' )
		? className.replace( 'is-style-ucf-', '' )
		: '';
}
