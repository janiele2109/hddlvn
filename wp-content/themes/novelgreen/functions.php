<?php
/**
 * Loads the child theme textdomain.
 */
function novelgreen_child_theme_setup() {
    load_child_theme_textdomain( 'novelgreen');
}
add_action( 'after_setup_theme', 'novelgreen_child_theme_setup' );

function novelgreen_child_enqueue_styles() {
    $parent_style = 'parent-style';
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
	 wp_enqueue_style( 'novelgreen-style',get_stylesheet_directory_uri() . '/novelgreen.css');
}
add_action( 'wp_enqueue_scripts', 'novelgreen_child_enqueue_styles',99);
?>