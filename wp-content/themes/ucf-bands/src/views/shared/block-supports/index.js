/**
 * Filter global/core block "supports"
 *
 * @since 4.0.0
 */

import { addFilter } from '@wordpress/hooks';

const setRegistration = ( settings ) => {
	if ( settings?.supports ) {
		settings.supports.customCSS = false;
	}

	return settings;
};

addFilter(
	'blocks.registerBlockType',
	'ucf/register-block-type',
	setRegistration
);
