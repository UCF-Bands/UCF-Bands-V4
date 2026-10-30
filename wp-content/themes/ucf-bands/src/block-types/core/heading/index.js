/**
 * Core heading block
 *
 * @since 4.0.0
 */

import domReady from '@wordpress/dom-ready';
import { __ } from '@wordpress/i18n';

import { registerBlockExtension } from '@10up/block-components';

import { getStyle, registerStyle } from '../../../utils/block-style';

import './style.scss';

const BLOCK_NAME = 'core/heading';
const STYLE_DISPLAY = 'display';

domReady( () => {
	registerStyle( BLOCK_NAME, 'no-accent', __( 'No Accent', 'ucf' ) );
	registerStyle( BLOCK_NAME, STYLE_DISPLAY, __( 'Display', 'ucf' ) );
} );

const classNameGenerator = ( { className } ) => {
	return STYLE_DISPLAY === getStyle( className )
		? 'has-display-font-family'
		: '';
};

// Register block extension.
registerBlockExtension( BLOCK_NAME, {
	extensionName: 'ucf-heading',
	attributes: {},
	classNameGenerator,
	Edit: () => <></>,
} );
