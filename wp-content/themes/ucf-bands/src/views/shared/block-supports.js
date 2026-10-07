/**
 * Filter global/core block "supports"
 *
 * @since 4.0.0
 */

import { addFilter } from '@wordpress/hooks';

const setRegistration = ( settings, name ) => {
	// if ( 'core/paragraph' === name ) {
		console.log( 'BLOCK TYPE', name, settings.supports );
	// }

	if ( settings.supports?.className ) {
		console.log( 'IT SUPPORTS CLASSNAME' );
		// THIS ISN'T WORKING
		settings.supports.className = false;
	}

	return settings;
};

addFilter(
	'blocks.registerBlockType',
	'ucf/register-block-type',
	setRegistration
);
