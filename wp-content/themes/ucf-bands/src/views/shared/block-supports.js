/**
 * Filter global/core block "supports"
 *
 * @since 4.0.0
 */

import { addFilter } from '@wordpress/hooks';

// eslint-disable-next-line no-unused-vars
const setRegistration = ( settings, name ) => {
	return settings;
};

addFilter(
	'blocks.registerBlockType',
	'ucf/register-block-type',
	setRegistration
);
