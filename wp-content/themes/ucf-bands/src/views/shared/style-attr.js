/**
 * Add extra block data attributes for the background/color/etc style chosen.
 *
 * @since 4.0.0
 */

import { createHigherOrderComponent } from '@wordpress/compose';
import { addFilter } from '@wordpress/hooks';

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
			for ( const [ type, value ] of Object.entries( style ) ) {
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
