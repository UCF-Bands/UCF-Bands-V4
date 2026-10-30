<?php
/**
 * SpaceU theming
 *
 * @since   4.0.0
 * @package UCF\Theme
 */

declare( strict_types = 1 );

namespace UCF\Theme;

use WP_Customize_Manager;

/**
 * #SpaceU #ChargeOn
 *
 * @since 4.0.0
 */
class SpaceU {
	use View;

	/**
	 * View name
	 *
	 * @since 4.0.0
	 * @var   string
	 */
	public const NAME = 'spaceu';

	/**
	 * Customizer control/setting prefix
	 *
	 * @since 4.0.0
	 * @var   string
	 */
	public const CUSTOMIZER_PREFIX = Theme::CUSTOMIZER_PREFIX . self::NAME . '_';

	/**
	 * Get view directory name
	 *
	 * @since 4.0.0
	 *
	 * @return string
	 */
	protected static function get_view_name(): string {
		return self::NAME;
	}

	/**
	 * Is the request for this view?
	 *
	 * @since 4.0.0
	 *
	 * @return bool
	 */
	protected function is_view(): bool {
		return (bool) get_theme_mod( self::CUSTOMIZER_PREFIX . 'enable' );
	}

	/**
	 * Perform additional setup actions
	 *
	 * @since 4.0.0
	 */
	protected function do_additional_setup(): void {
		add_action( 'customize_register', [ $this, 'add_customizer' ] );
	}

	/**
	 * Add customizer section + controls
	 *
	 * @since 4.0.0
	 *
	 * @param WP_Customize_Manager $wp_customize  Customizer manager.
	 */
	public function add_customizer( WP_Customize_Manager $wp_customize ): void {

		$wp_customize->add_section(
			self::CUSTOMIZER_PREFIX,
			[
				'title'    => __( 'SpaceU', 'ucf' ),
				'priority' => 20,
			]
		);

		$wp_customize->add_setting(
			self::CUSTOMIZER_PREFIX . 'enable',
			[
				'default'           => false,
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => fn( $checked ): bool => (bool) $checked,
			]
		);

		$wp_customize->add_control(
			self::CUSTOMIZER_PREFIX . 'enable',
			[
				'label'    => __( "Enable America's Space University Bands", 'ucf' ),
				'section'  => self::CUSTOMIZER_PREFIX,
				'settings' => self::CUSTOMIZER_PREFIX . 'enable',
				'type'     => 'checkbox',
			]
		);
	}

	/**
	 * Should the style be deferred?
	 *
	 * @since 4.0.0
	 * @var   bool
	 */
	protected function is_style_deferred(): bool {
		return false;
	}
}
