/**
 * Icon control
 *
 * @since 4.0.0
 */

import {
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis
	__experimentalHStack as HStack,
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis
	__experimentalSpacer as Spacer,
	BaseControl,
	Button,
	useBaseControlProps,
} from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import { close as closeIcon } from '@wordpress/icons';

import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { byPrefixAndName } from '@awesome.me/kit-c259465af1/icons';

import IconSearch from '../icon-search';

/**
 * Font Awesome icon picker control.
 *
 * Shows the selected icon with a reset button. If no icon is selected, shows
 * an icon search field instead.
 *
 * @since 4.0.0
 *
 * @param {Object}   props             Component props.
 * @param {Function} props.onChange    Called with `{ name, prefix }` when an icon is selected or reset.
 * @param {string}   props.prefixValue Selected icon's Font Awesome prefix (e.g. `fas`).
 * @param {string}   props.nameValue   Selected icon's Font Awesome name (e.g. `music`).
 *
 * @return {Element} Icon preview with reset button, or icon search field.
 */
const IconControl = ( { onChange, prefixValue, nameValue } ) => {
	const { baseControlProps } = useBaseControlProps( {
		label: __( 'Icon', 'ucf' ),
	} );

	return prefixValue && nameValue ? (
		<BaseControl { ...baseControlProps }>
			<HStack justify="flex-start">
				<FontAwesomeIcon
					icon={ byPrefixAndName[ prefixValue ][ nameValue ] }
					size="xl"
				/>
				<span>{ nameValue }</span>
				<Spacer />
				<Button
					onClick={ () => onChange( { name: '', prefix: '' } ) }
					type=""
					icon={ closeIcon }
					isDestructive
				>
					{ __( 'Clear', 'ucf' ) }
				</Button>
			</HStack>
		</BaseControl>
	) : (
		<IconSearch onChange={ onChange } showLabel />
	);
};

export default IconControl;
