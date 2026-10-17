/**
 * Add extra block data attributes for the background/color/etc style chosen.
 *
 * Note: This only applies to "style" attributes in `attributes.style`, which do
 * not have the `has-%whatever%` helper classnames. For example, background
 * gradients will be handled here, but not background color because it's
 * `attributes.backgroundColor` instead of `attributes.style.background.color`.
 *
 * @since 4.0.0
 */

import { createHigherOrderComponent } from '@wordpress/compose';
import { addFilter } from '@wordpress/hooks';

// Whitelisted inline "style attributes".
const SUPPORTED_SCOPES = {
	background: [ 'gradient' ],
};

/**
 * Create HTML data attributes from block style attributes.
 *
 * @param {Object} props      Block properties.
 * @param {Object} attributes Block attributes.
 * @return {Object} props
 */
const parseStyleProps = ( props, attributes ) => {
	if ( attributes?.style ) {
		for ( const [ scope, style ] of Object.entries( attributes.style ) ) {
			if ( ! SUPPORTED_SCOPES[ scope ] ) {
				continue;
			}

			for ( const [ type, value ] of Object.entries( style ) ) {
				if ( ! SUPPORTED_SCOPES[ scope ].includes( type ) ) {
					continue;
				}

				const cleanValue = value.startsWith( 'var:' )
					? value.split( '|' ).pop()
					: value;

				props[ `data-ucf-${ scope }-${ type }` ] = cleanValue;
			}
		}
	}

	return props;
};

/**
 * Add extra block props for save.
 *
 * @param {Object} props      block properties
 * @param {Object} blockType  block type/registration details
 * @param {Object} attributes block's attributes
 * @return {Object} props
 */
const withExtraProps = ( props, blockType, attributes ) => {
	return parseStyleProps( props, attributes );
};

addFilter(
	'blocks.getSaveContent.extraProps',
	'ucf/style-class/extra-props',
	withExtraProps
);

/**
 * Add extra block props for editor.
 */
const withBlockListBlock = createHigherOrderComponent( ( BlockListBlock ) => {
	return ( props ) => (
		<BlockListBlock
			{ ...props }
			wrapperProps={ {
				...props.wrapperProps,
				...parseStyleProps( {}, props?.block?.attributes ),
			} }
		/>
	);
}, 'withBlockListBlock' );

addFilter(
	'editor.BlockListBlock',
	'ucf/style-class/block-list-block',
	withBlockListBlock
);
