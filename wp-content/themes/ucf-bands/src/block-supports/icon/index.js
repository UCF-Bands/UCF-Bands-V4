/**
 * Icon block support
 *
 * @since 4.0.0
 */

import { InspectorControls } from '@wordpress/block-editor';
import { hasBlockSupport } from '@wordpress/blocks';
import { PanelBody } from '@wordpress/components';
import { createHigherOrderComponent } from '@wordpress/compose';
import { addFilter } from '@wordpress/hooks';

import IconControl from '../../components/icon-control';
import IconBlockControl from '../../components/icon-block-control';

const SUPPORT_KEY = 'ucfIcon';

const addAttributes = ( settings ) =>
	hasBlockSupport( settings, SUPPORT_KEY )
		? {
				...settings,
				attributes: {
					...settings.attributes,
					ucfIconPrefix: {
						type: 'string',
					},
					ucfIconName: {
						type: 'string',
					},
				},
			}
		: settings;

addFilter(
	'blocks.registerBlockType',
	'ucf/icon/add-attributes',
	addAttributes
);

const withIconControls = createHigherOrderComponent(
	( BlockEdit ) => ( props ) => {
		const { name, attributes, setAttributes } = props;

		if ( ! hasBlockSupport( name, SUPPORT_KEY ) ) {
			return <BlockEdit { ...props } />;
		}

		const { ucfIconPrefix, ucfIconName } = attributes;

		const onChange = ( { prefix, name: iconName } ) =>
			setAttributes( { ucfIconPrefix: prefix, ucfIconName: iconName } );

		return (
			<>
				<BlockEdit { ...props } />
				<IconBlockControl
					onChange={ onChange }
					prefixValue={ ucfIconPrefix }
					nameValue={ ucfIconName }
				/>
				<InspectorControls>
					<PanelBody>
						<IconControl
							prefixValue={ ucfIconPrefix }
							nameValue={ ucfIconName }
							onChange={ onChange }
						/>
					</PanelBody>
				</InspectorControls>
			</>
		);
	},
	'withIconControls'
);

addFilter( 'editor.BlockEdit', 'ucf/icon/with-controls', withIconControls );
