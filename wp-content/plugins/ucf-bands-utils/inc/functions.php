<?php
/**
 * Misc. global helper functions
 *
 * @since   1.0.0
 * @package UCF\Utils
 */

declare( strict_types = 1 );

namespace UCF\Utils;

/**
 * Class autoloader registration
 *
 * @since 1.0.0
 *
 * @param string $ns   Namespace.
 * @param string $dir  Directory to load from.
 */
function autoload_register( string $ns, string $dir ): void {

	spl_autoload_register(
		function ( string $class_name ) use ( $ns, $dir ) {

			if ( strpos( $class_name, $ns . '\\' ) !== 0 ) {
				return false;
			}

			$parts = explode( '\\', substr( $class_name, strlen( $ns . '\\' ) ) );

			$path = "{$dir}/inc";
			foreach ( $parts as $part ) {
				$path .= '/' . $part;
			}
			$path .= '.php';

			if ( ! file_exists( $path ) ) {
				return false;
			}

			require_once $path;

			return true;
		}
	);
}

/**
 * Log error notice in NewRelic
 *
 * @since 1.0.0
 */
function log_error(): void {

	if ( extension_loaded( 'newrelic' ) ) {
		$args = func_get_args();
		call_user_func_array( 'newrelic_notice_error', $args );
	}
}

/**
 * Send an error email
 *
 * @since 1.0.0
 *
 * @param string $subject_description  Email subject description.
 * @param string $message              Message.
 *
 * @return bool  Email sent successfully.
 */
function do_error_email( string $subject_description, string $message ): bool {

	return wp_mail(
		UCF_UTILS_ERROR_EMAIL,
		"UCF Bands Error: {$subject_description}",
		$message,
		[ 'Content-Type: text/html; charset=UTF-8' ]
	);
}

/**
 * Sanitize a value with array fallback
 *
 * @since 1.0.0
 *
 * @param  mixed $value  Input value.
 * @return mixed
 */
function sanitize( $value ) {
	return is_array( $value ) ? array_map( __FUNCTION__, $value ) : sanitize_text_field( $value );
}

/**
 * Returns a $_GET value
 *
 * @since  1.0.0
 * @see    https://github.com/WordPress/WordPress-Coding-Standards/wiki/Fixing-errors-for-input-data
 *
 * @param  string $key  $_GET superglobal key.
 * @return mixed
 */
function get( string $key ) {
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
	return isset( $_GET[ $key ] ) ? sanitize( wp_unslash( $_GET[ $key ] ) ) : null;
}

/**
 * Returns a posted value
 *
 * Nonce verification should happen before this.
 *
 * @since 1.0.0
 * @see   https://github.com/WordPress/WordPress-Coding-Standards/wiki/Fixing-errors-for-input-data
 *
 * @param  string $key  $_POST superglobal key.
 * @return mixed
 */
function postval( string $key ) {
	// phpcs:ignore WordPress.Security.NonceVerification.Missing, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
	return isset( $_POST[ $key ] ) ? sanitize( wp_unslash( $_POST[ $key ] ) ) : null;
}

/**
 * Break array into string of attributes
 *
 * @since 1.0.0
 *
 * @param  array  $attrs   Attributes (keys) and values.
 * @param  string $prefix  Prefix for data attributes (ex: "data-").
 * @return string          Inline string of data attributes.
 */
function get_attrs( array $attrs, string $prefix = '' ): string {

	// Remove initially empty args.
	$attrs = array_filter( $attrs );

	foreach ( $attrs as $attr => $value ) {

		// data- attributes.
		if ( 'data' === $attr && is_array( $value ) ) {
			$attrs[ $attr ] = get_attrs( array_filter( $value ), 'data-' );
			continue;
		}

		// Array of classes.
		if ( 'class' === $attr && is_array( $value ) ) {
			$value = implode( ' ', array_filter( $value ) );
		}

		// Array of classes + all other cases.
		$attrs[ $attr ] = $prefix . $attr . '="' . esc_attr( $value ) . '"';
	}

	return implode( ' ', $attrs );
}

/**
 * Output HTML string off attributes
 *
 * @since 1.0.0
 *
 * @param  array  $attrs   Attributes and their values.
 * @param  string $prefix  A prefix for data attributes (ex: "data-").
 */
function do_attrs( array $attrs, string $prefix = '' ) {
	echo get_attrs( $attrs, $prefix ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Output KSES content
 *
 * @since 1.0.0
 *
 * @param string $content       Content.
 * @param string $allowed_html  Allowed HTML. Defaults to "post".
 */
function do_kses( string $content, string $allowed_html = 'post' ): void {
	echo wp_kses( $content, $allowed_html );
}

/**
 * Custom kses allowed HTML for "inlined" entities.
 *
 * @since 1.0.0
 *
 * @return array  Allowed HTML entities/attributes.
 */
function get_allowed_inline_html(): array {
	return [
		'a'      => [
			'href'  => [],
			'rel'   => [],
			'title' => [],
		],
		'b'      => [],
		'strong' => [],
		'i'      => [
			'class' => [],
			'style' => [],
		],
		'em'     => [],
		'code'   => [],
		'span'   => [
			'class' => [],
			'style' => [],
		],
	];
}

/**
 * Output a string with allowed inline HTML
 *
 * @since 1.0.0
 *
 * @param ?string $content  Content to filter disallowed inline HTML from.
 */
function do_kses_inline( ?string $content ) {
	echo wp_kses( $content, get_allowed_inline_html() );
}

/**
 * Implode a string with natural language
 *
 * @since 1.0.0
 * @see   https://stackoverflow.com/a/25057951
 *
 * @param array  $items         List of items to join.
 * @param string $conjunction  Conjunction.
 */
function natural_language_implode( $items, $conjunction = null ): string {

	$conjunction = $conjunction ?: _x( 'and', 'natural-language-implode', 'ucf' );

	$last = array_pop( $items );

	return $items
		? implode( ', ', $items ) . ( count( $items ) > 1 ? ',' : '' ) . ' ' . $conjunction . ' ' . $last
		: $last;
}

/**
 * Remove an action or filter without having to match the priority.
 *
 * @since 1.0.0
 *
 * @param string   $hook      Action/filter hook.
 * @param callable $callback  Registered callback.
 */
function remove_filter_without_priority( string $hook, callable $callback ): bool {

	$priority = has_filter( $hook, $callback );

	return false === $priority
		? false
		: remove_filter( $hook, $callback, $priority );
}
