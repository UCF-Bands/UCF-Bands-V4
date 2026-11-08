/**
 * Icon search
 *
 * @since 4.0.0
 */

import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { Button, SearchControl } from '@wordpress/components';
import { useState, useEffect, useMemo } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

import './index.scss';

const MAX_RESULTS = 120;

const loadIcons = () =>
	Promise.all( [
		import( '@awesome.me/kit-c259465af1/icons/sharp/regular' ),
		import( '@awesome.me/kit-c259465af1/icons/classic/brands' ),
	] ).then( ( modules ) => [
		// Set removes aliased exports (e.g. faAdd/faPlus) that reference the same icon object.
		...new Set( modules.flatMap( ( m ) => Object.values( m ) ) ),
	] );

let iconsPromise;

const IconSearch = ( { onChange } ) => {
	const [ icons, setIcons ] = useState( null );
	const [ search, setSearch ] = useState( '' );

	useEffect( () => {
		if ( ! icons ) {
			iconsPromise ??= loadIcons();
			iconsPromise.then( setIcons );
		}
	}, [ icons ] );

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
				label={ __( 'Icon', 'nba' ) }
				hideLabelFromVision={ false }
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
								onChange( [ icon.prefix, icon.iconName ] )
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
