// eslint-disable-next-line import/no-extraneous-dependencies
import wordpress from '@wordpress/eslint-plugin';

export default [
	{ ignores: [ 'vendor/**' ] },
	...wordpress.configs.recommended,
];
