/**
 * Icon picker
 *
 * @since 4.0.0
 */

import { __ } from '@wordpress/i18n';
import { BlockControls } from '@wordpress/block-editor';
import { IconPickerToolbarButton, registerIcons } from '@10up/block-components';

import { icon } from '@fortawesome/fontawesome-svg-core';
import * as sharp from '@awesome.me/kit-c259465af1/icons/sharp/regular';
import * as brands from '@awesome.me/kit-c259465af1/icons/classic/brands';

const SET_NAME = 'font-awesome';

// Format the icons for the 10up <IconPicker>.
const icons = [
	...new Map(
		[ ...Object.values( sharp ), ...Object.values( brands ) ].map(
			( i ) => [
				i.iconName,
				{
					name: i.iconName,
					label: i.iconName,
					source: icon( i ).html[ 0 ],
				},
			]
		)
	).values(),
];

registerIcons( {
	name: SET_NAME,
	label: __( 'Font Awesome', 'ucf' ),
	icons,
} );

const IconPickerBlockControl = () => {
	return (
		<BlockControls>
			<IconPickerToolbarButton
				value={ null }
				onChange={ ( e ) => console.log( 'CHANGED', e ) }
			/>
		</BlockControls>
	);
};

export default IconPickerBlockControl;
