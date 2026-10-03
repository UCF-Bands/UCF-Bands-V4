<?php
/**
 * Custom taxonomy abstract
 *
 * @since   1.0.0
 * @package UCF\Utils
 */

declare( strict_types = 1 );

namespace UCF\Utils\Structures;

use UCF\Utils\Singleton;

/**
 * Taxonomy handling abstract
 *
 * @since 1.0.0
 */
abstract class Taxonomy {
	use Singleton;

	/**
	 * Taxonomy key
	 *
	 * @since 1.0.0
	 * @var   string
	 */
	const TAX_KEY = 'ucf_tax';

	/**
	 * Post types to attach this taxonomy to
	 *
	 * @since 1.0.0
	 * @var   string[]
	 */
	const POST_TYPES = [];

	/**
	 * Spin everything up
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'do_init' ] );
		add_action( 'init', [ $this, 'do_registration' ] );
	}

	/**
	 * Do WP init actions
	 *
	 * @since 1.0.0
	 */
	public function do_init(): void {}

	/**
	 * Get main taxonomy label
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_label(): string {
		return __( 'Set Taxonomy Label', 'ucf' );
	}

	/**
	 * Get main plural taxonomy label
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_plural_label(): string {
		return __( 'Set Plural Taxonomy Label', 'ucf' );
	}

	/**
	 * Do taxonomy registration
	 *
	 * @since 1.0.0
	 */
	public function do_registration(): void {
		register_taxonomy(
			static::TAX_KEY,
			static::POST_TYPES,
			$this->get_tax_args()
		);
	}

	/**
	 * Get taxonomy args
	 *
	 * @since 1.0.0
	 * @see   https://generatewp.com/taxonomy/
	 *
	 * @return array  Taxonomy registration args.
	 */
	protected function get_tax_args(): array {
		return [];
	}

	/**
	 * Get currently queried terms
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function get_queried(): array {
		return array_filter( explode( ',', get_query_var( static::TAX_KEY ) ) );
	}

	/**
	 * Get the taxonomy's terms
	 *
	 * @since 1.0.0
	 *
	 * @param  array $args  Arguments for get_terms().
	 * @return array
	 */
	public static function get_terms( array $args = [] ): array {

		return get_terms(
			wp_parse_args(
				$args,
				[
					'taxonomy'   => static::TAX_KEY,
					'hide_empty' => true,
				]
			)
		);
	}

	/**
	 * Get current query's terms for the taxonomy
	 *
	 * Compatible with archives and singular posts.
	 *
	 * @since 1.0.0
	 *
	 * @param  string $fields  Term fields to return. "all" is full term objects.
	 * @return array           Term objects for this taxonomy.
	 */
	public static function get_current_terms( string $fields = 'all' ): array {

		$terms = is_archive()
			// Only try to grab queried terms if something is actually queried
			// since empty array results in all terms.
			? ( self::get_queried() ? get_terms(
				[
					'taxonomy' => static::TAX_KEY,
					'slug'     => self::get_queried(),
				]
			) : false )
			: get_the_terms( get_the_ID(), static::TAX_KEY );

		if ( empty( $terms ) ) {
			return [];
		} elseif ( 'names' === $fields ) {
			return wp_list_pluck( $terms, 'name' );
		} elseif ( 'ids' === $fields ) {
			return wp_list_pluck( $terms, 'term_id' );
		} else {
			return $terms;
		}
	}

	/**
	 * Get current query's terms in a human-readable list
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function get_current_terms_list(): string {
		$terms = static::get_current_terms( 'names' );

		// Sanity check.
		if ( ! $terms ) {
			return '';

			// Add "and " to the last term and separate with commas/spaces.
		} elseif ( count( $terms ) > 2 ) {
			$terms[ count( $terms ) - 1 ] = __( 'and', 'ucf' ) . ' ' . $terms[ count( $terms ) - 1 ];
			return implode( ', ', $terms );

			// Just two: put "and" between them.
		} else {
			return implode( ' ' . __( 'and', 'ucf' ) . ' ', $terms );
		}
	}
}
