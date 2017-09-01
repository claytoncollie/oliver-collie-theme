<?php

/**
 * Customizations
 *
 * @package Oliver Collie
 * @author  Clayton Collie
 */

/**
 * Get default primary color for Customizer.
 *
 * Abstracted here since at least two functions use it.
 *
 * @since 1.0.0
 *
 * @return string Hex color code for primary color.
 */

function olivercollie_customizer_get_default_primary_color() {
	return '#57e5ae';
}

add_action( 'customize_register', 'olivercollie_customizer_register' );
/**
 * Register settings and controls with the Customizer.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function olivercollie_customizer_register() {

	global $wp_customize;

	$wp_customize->add_setting(
		'olivercollie_primary_color',
		array(
			'default'           => olivercollie_customizer_get_default_primary_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'olivercollie_primary_color',
			array(
				'description' => __( 'Set the default color.', 'olivercollie' ),
			    'label'       => __( 'Primary Color', 'olivercollie' ),
			    'section'     => 'colors',
			    'settings'    => 'olivercollie_primary_color',
			)
		)
	);

}
