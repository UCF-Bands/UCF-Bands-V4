/**
 * <RichText> formatting adjustments
 *
 * @since 4.0.0
 */

import { select } from '@wordpress/data';
import domReady from '@wordpress/dom-ready';
import { registerFormatType, unregisterFormatType } from '@wordpress/rich-text';

const getFormatType = ( format ) =>
	select( 'core/rich-text' ).getFormatType( format );

/**
 * Completely remove some format types
 */
const FORMAT_EXCLUSIONS = [ 'core/text-color', 'core/language' ];

domReady( () => {
	FORMAT_EXCLUSIONS.forEach( ( type ) => {
		const registeredFormat = getFormatType( type );

		if ( registeredFormat ) {
			unregisterFormatType( type );
		}
	} );
} );

/**
 * Re-register some formats so certain blocks are excluded.
 *
 * @see https://salferrarello.com/unregisterformattype-for-specific-block-type-in-gutenberg/
 */

// Mapping: formatType: [ 'ns/blockType1', 'ns/blockType2', … ].
const FORMAT_BLOCK_TYPE_EXCLUSIONS = {
	'core/bold': [ 'core/heading' ],
	'core/italic': [ 'core/heading' ],
};

domReady( () => {
	for ( const format in FORMAT_BLOCK_TYPE_EXCLUSIONS ) {
		// Store a copy of the original format type.
		const originalFormatType = getFormatType( format );

		if ( originalFormatType ) {
			// Unregister the format "globally".
			unregisterFormatType( format );

			// Re-register format but with certain block types excluded this time.
			registerFormatType( format, {
				...originalFormatType,
				edit: ( props ) => {
					if (
						FORMAT_BLOCK_TYPE_EXCLUSIONS[ format ].includes(
							select( 'core/block-editor' ).getSelectedBlock()
								?.name
						)
					) {
						return null;
					}

					// Render the original format type.
					return originalFormatType.edit( props );
				},
			} );
		}
	}
} );
