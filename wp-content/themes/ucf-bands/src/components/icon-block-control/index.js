/**
 * Icon picker block control
 *
 * @since 4.0.0
 */

import { __ } from '@wordpress/i18n';
import { BlockControls } from '@wordpress/block-editor';
import { Popover, ToolbarButton, ToolbarGroup } from '@wordpress/components';
import { useState } from '@wordpress/element';

import IconSearch from '../icon-search';

import './index.scss';

const IconBlockControl = ( { onChange, prefixValue, nameValue } ) => {
	const isSet = prefixValue && nameValue;

	const [ isOpen, setIsOpen ] = useState( false );
	const [ anchor, setAnchor ] = useState( null );

	return (
		<>
			<BlockControls>
				<ToolbarGroup>
					<ToolbarButton
						className="ucf--icon-block-control__button"
						onClick={ () =>
							isSet
								? onChange( { name: '', prefix: '' } )
								: setIsOpen( ! isOpen )
						}
						ref={ setAnchor }
					>
						{ isSet
							? __( 'Clear Icon', 'ucf' )
							: __( 'Set Icon', 'ucf' ) }
					</ToolbarButton>
				</ToolbarGroup>
			</BlockControls>
			{ isOpen && (
				<Popover
					className="ucf--icon-block-control__popover"
					anchor={ anchor }
					offset={ { mainAxis: 6, crossAxis: -4 } }
					onFocusOutside={ () => setIsOpen( false ) }
				>
					<IconSearch
						onChange={ ( value ) => {
							setIsOpen( false );
							onChange( value );
						} }
					/>
				</Popover>
			) }
		</>
	);
};

export default IconBlockControl;
