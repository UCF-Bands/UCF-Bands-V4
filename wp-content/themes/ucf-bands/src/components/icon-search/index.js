/**
 * Icon search
 *
 * @since 4.0.0
 */

import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { Button, SearchControl } from '@wordpress/components';
import { useState, useMemo } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

import { useIcons } from '../../utils/icons';

import './index.scss';

const MAX_RESULTS = 120;

const IconSearch = ( { onChange, showLabel = false } ) => {
	const icons = useIcons();
	const [ search, setSearch ] = useState( '' );

	const results = useMemo( () => {
		if ( ! icons ) {
			return [];
		}
		const query = search.trim().toLowerCase();
		const matches = query
			? icons.filter(
					( icon ) =>
						icon.iconName.includes( query ) ||
						icon.icon[ 2 ].some( ( alias ) =>
							String( alias ).includes( query )
						)
				)
			: icons;
		return matches.slice( 0, MAX_RESULTS );
	}, [ icons, search ] );

	return (
		<>
			<SearchControl
				className="ucf--icon-search__control"
				label={ __( 'Icon', 'nba' ) }
				hideLabelFromVision={ ! showLabel }
				value={ search }
				onChange={ setSearch }
			/>
			{ search && (
				<div className="ucf--icon-search__results">
					{ results.map( ( icon ) => (
						<Button
							className="ucf--icon-search__result"
							key={ `${ icon.prefix }:${ icon.iconName }` }
							label={ icon.iconName }
							// showTooltip // TODO: Add a user meta-based "mode" toggle!
							value={ icon.iconName }
							onClick={ () =>
								onChange( {
									prefix: icon.prefix,
									name: icon.iconName,
								} )
							}
						>
							<FontAwesomeIcon icon={ icon } size="lg" />
							<span className="ucf--icon-search__result-label">
								{ icon.iconName }
							</span>
						</Button>
					) ) }
				</div>
			) }
		</>
	);
};

export default IconSearch;
