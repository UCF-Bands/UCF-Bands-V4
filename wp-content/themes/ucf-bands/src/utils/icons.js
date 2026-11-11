/**
 * Lazy-loaded Font Awesome kit icons
 *
 * The kit's icon modules are several MB. Never import them statically (including
 * `byPrefixAndName` from `@awesome.me/kit-c259465af1/icons`); doing so inlines the
 * whole kit into every entry that uses an icon. Dynamic imports here let webpack
 * split the kit into separate chunks that only load when an icon is needed.
 *
 * @since 4.0.0
 */

import { useState, useEffect } from '@wordpress/element';

// Module-level cache shared by every consumer in an entry.
let cachedIcons = null;
let cachedLookup = null;
let iconsPromise = null;

/**
 * Dynamically import the kit's icon modules and flatten them into a list.
 *
 * @return {Promise<Object[]>} Unique icon definitions from every imported module.
 */
const loadIcons = () =>
	Promise.all( [
		import(
			/* webpackChunkName: "font-awesome/sharp-regular" */ '@awesome.me/kit-c259465af1/icons/sharp/regular'
		),
		import(
			/* webpackChunkName: "font-awesome/classic-brands" */ '@awesome.me/kit-c259465af1/icons/classic/brands'
		),
	] ).then( ( modules ) => [
		// Set removes aliased exports (e.g. faAdd/faPlus) that reference the same icon object.
		...new Set(
			modules.flatMap( ( m ) =>
				Object.values( m ).filter( ( icon ) => icon?.iconName )
			)
		),
	] );

/**
 * Build a `prefix` → `name`/`alias` → icon lookup (like the kit's `byPrefixAndName`).
 *
 * @param {Object[]} icons Icon definitions.
 *
 * @return {Object} Icons keyed by prefix, then by name and each string alias.
 */
const buildLookup = ( icons ) => {
	const lookup = {};
	icons.forEach( ( icon ) => {
		lookup[ icon.prefix ] ??= {};
		icon.icon[ 2 ].forEach( ( alias ) => {
			if ( typeof alias === 'string' ) {
				lookup[ icon.prefix ][ alias ] = icon;
			}
		} );
		lookup[ icon.prefix ][ icon.iconName ] = icon;
	} );
	return lookup;
};

/**
 * Load all kit icons (once).
 *
 * @return {Promise<Object[]>} Unique icon definitions.
 */
export const getIcons = () => {
	iconsPromise ??= loadIcons().then(
		( icons ) => {
			cachedLookup = buildLookup( icons );
			cachedIcons = icons;
			return icons;
		},
		( error ) => {
			// Allow a retry on the next mount if the import fails.
			iconsPromise = null;
			throw error;
		}
	);
	return iconsPromise;
};

/**
 * Get all kit icons, loading them on first use.
 *
 * @return {Object[]|null} Unique icon definitions, or null while loading.
 */
export const useIcons = () => {
	const [ icons, setIcons ] = useState( cachedIcons );

	useEffect( () => {
		if ( icons ) {
			return;
		}
		let isMounted = true;
		getIcons().then( ( loaded ) => isMounted && setIcons( loaded ) );
		return () => {
			isMounted = false;
		};
	}, [ icons ] );

	return icons;
};

/**
 * Get a single icon definition by prefix and name (or alias).
 *
 * @param {string} prefix Font Awesome prefix (e.g. `fasr`).
 * @param {string} name   Font Awesome icon name (e.g. `music`).
 *
 * @return {Object|null|undefined} Icon definition, null if not found, or undefined while loading.
 */
export const useIcon = ( prefix, name ) => {
	const icons = useIcons();

	if ( ! icons ) {
		return undefined;
	}

	return cachedLookup[ prefix ]?.[ name ] ?? null;
};
