<?php
/**
 * Internal "tagging" taxonomy registration/handling
 *
 * @since   1.0.0
 * @package UCF\Utils
 */

declare( strict_types = 1 );

namespace UCF\Utils\Structures;

/**
 * Internal "admin" tag taxonomy
 *
 * @since 1.0.0
 */
class Admin_Tag extends Taxonomy {

	/**
	 * Taxonomy key
	 *
	 * @since 1.0.0
	 * @var   string
	 */
	const TAX_KEY = 'ucf_admin_tag';

	/**
	 * Post types to attach this taxonomy to
	 *
	 * @since 1.0.0
	 * @var   string[]
	 */
	const POST_TYPES = [ 'page' ];

	/**
	 * Get general taxonomy label
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_label(): string {
		return __( 'Admin Tag', 'ucf' );
	}

	/**
	 * Get the plural version of the general taxonomy label
	 *
	 * @since 1.0.0
	 */
	public function get_plural_label(): string {
		return __( 'Admin Tags', 'ucf' );
	}

	/**
	 * Get non-default post type args
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_tax_args(): array {

		$labels = [
			'name'                       => $this->get_plural_label(),
			'singular_name'              => $this->get_label(),
			'menu_name'                  => $this->get_plural_label(),
			'all_items'                  => __( 'All Admin Tags', 'ucf' ),
			'parent_item'                => __( 'Parent Admin Tag', 'ucf' ),
			'parent_item_colon'          => __( 'Parent Admin Tag:', 'ucf' ),
			'new_item_name'              => __( 'New Admin Tag Name', 'ucf' ),
			'add_new_item'               => __( 'Add New Admin Tag', 'ucf' ),
			'edit_item'                  => __( 'Edit Admin Tag', 'ucf' ),
			'update_item'                => __( 'Update Admin Tag', 'ucf' ),
			'view_item'                  => __( 'View Admin Tag', 'ucf' ),
			'separate_items_with_commas' => __( 'Separate admin tags with commas', 'ucf' ),
			'add_or_remove_items'        => __( 'Add or remove admin tags', 'ucf' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'ucf' ),
			'popular_items'              => __( 'Popular Admin Tags', 'ucf' ),
			'search_items'               => __( 'Search Admin Tags', 'ucf' ),
			'not_found'                  => __( 'Not Found', 'ucf' ),
			'no_terms'                   => __( 'No Admin Tags', 'ucf' ),
			'items_list'                 => __( 'Admin tags list', 'ucf' ),
			'items_list_navigation'      => __( 'Admin tags list navigation', 'ucf' ),
		];

		return [
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => false,
			'hierarchical'       => true,
			'show_admin_column'  => true,
			'show_in_nav_menus'  => false,
			'show_tagcloud'      => false,
			'rewrite'            => false,
			'show_in_rest'       => true,
		];
	}
}
