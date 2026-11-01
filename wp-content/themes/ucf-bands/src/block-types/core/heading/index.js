/**
 * Core heading block
 *
 * @since 4.0.0
 */

import domReady from '@wordpress/dom-ready';
import { __ } from '@wordpress/i18n';

import { registerStyle } from '../../../utils/block-style';

import './style.scss';

const BLOCK_NAME = 'core/heading';

domReady( () => {
	registerStyle( BLOCK_NAME, 'no-accent', __( 'No Accent', 'ucf' ) );
} );
