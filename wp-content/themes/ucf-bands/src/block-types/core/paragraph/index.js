/**
 * Core paragraph block
 *
 * @since 4.0.0
 */

import domReady from '@wordpress/dom-ready';
import { __ } from '@wordpress/i18n';

import { registerStyle } from '../../../utils/block-style';

import './style.scss';

const BLOCK_NAME = 'core/paragraph';

domReady( () => {
	registerStyle( BLOCK_NAME, 'detail', __( 'Small / Detail', 'ucf' ) );
} );
