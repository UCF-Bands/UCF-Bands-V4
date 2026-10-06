import wordpress from '@wordpress/eslint-plugin';

export default [
	{ ignores: [ 'vendor/**' ] },
	...wordpress.configs.recommended,
	{
		rules: {
			'import/no-extraneous-dependencies': 'off',
		},
	},
];
