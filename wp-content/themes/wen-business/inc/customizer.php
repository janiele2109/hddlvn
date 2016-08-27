<?php
/**
 * Theme Customizer.
 *
 * @package WEN_Business
 */

/**
 * Add partial refresh support for site title and description.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function wen_business_customize_register( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

    // Abort if selective refresh is not available.
    if ( ! isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->get_setting( 'blogname' )->transport        = 'refresh';
		$wp_customize->get_setting( 'blogdescription' )->transport = 'refresh';
        return;
    }

    // Load customizer partials callback.
    require get_template_directory() . '/inc/customizer/partials.php';

    // Partial blogname.
    $wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector'            => '.site-title a',
		'container_inclusive' => false,
		'render_callback'     => 'wen_business_customize_partial_blogname',
    ) );

    // Partial blogdescription.
    $wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector'            => '.site-description',
		'container_inclusive' => false,
		'render_callback'     => 'wen_business_customize_partial_blogdescription',
    ) );

}
add_action( 'customize_register', 'wen_business_customize_register' );

function wen_business_custom_customize_enqueue_scripts() {

	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	wp_register_script( 'wen-business-customizer-button', get_template_directory_uri() . '/assets/js/customizer-button' . $min . '.js', array( 'customize-controls' ), '1.4.0', true );
	$data = array(
		'updrade_button_text' => __( 'Buy WEN Business Pro', 'wen-business' ),
		'updrade_button_link' => esc_url( 'http://catchthemes.com/themes/wen-business-pro' ),
	);
	wp_localize_script( 'wen-business-customizer-button', 'WEN_Business_Customizer_Object', $data );
	wp_enqueue_script( 'wen-business-customizer-button' );

}

add_action( 'customize_controls_enqueue_scripts', 'wen_business_custom_customize_enqueue_scripts' );
