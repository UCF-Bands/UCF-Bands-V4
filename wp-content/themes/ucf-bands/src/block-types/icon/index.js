/**
 * Icon block
 *
 * @since 4.0.0
 */

import { registerBlockType } from '@wordpress/blocks';
import { starFilled as icon } from '@wordpress/icons';

import './style.scss';
import './index.scss';

import Edit from './edit';
import metadata from './block.json';

registerBlockType( metadata.name, {
	icon,
	edit: Edit,
	save: () => null,
} );
