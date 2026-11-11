/**
 * Inline icon + picker
 *
 * @since 4.0.0
 */

import { useState } from '@wordpress/element';

import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';

import { Button, Popover, Spinner } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import { close as closeIcon } from '@wordpress/icons';

import { useIcon } from '../../utils/icons';
import IconSearch from '../icon-search';

import './index.scss';

const InlineIconPicker = ( { prefix, name, onChange } ) => {
	const isSet = prefix && name;

	const [ isOpen, setIsOpen ] = useState( false );
	const [ anchor, setAnchor ] = useState( null );

	const selectedIcon = useIcon( prefix, name );
	const placeholderIcon = useIcon( 'fasr', 'circle-question' );
	const icon = ( isSet && selectedIcon ) || placeholderIcon;

	return (
		<>
			<Button
				className="ucf--inline-icon-picker__button"
				onClick={ setIsOpen }
				ref={ setAnchor }
			>
				{ icon ? (
					<FontAwesomeIcon icon={ icon } size="xl" />
				) : (
					<Spinner />
				) }
			</Button>
			{ isOpen && (
				<Popover
					className="ucf--inline-icon-picker__popover"
					anchor={ anchor }
					offset={ 8 }
					onFocusOutside={ () => setIsOpen( false ) }
				>
					{ isSet ? (
						<Button
							className="ucf--inline-icon-picker__reset-button"
							icon={ closeIcon }
							style={ { minWidth: '8rem' } }
							onClick={ () =>
								onChange( { name: '', prefix: '' } )
							}
						>
							{ __( 'Clear Icon', 'ucf' ) }
						</Button>
					) : (
						<IconSearch
							onChange={ ( value ) => {
								setIsOpen( false );
								onChange( value );
							} }
						/>
					) }
				</Popover>
			) }
		</>
	);
};

export default InlineIconPicker;
