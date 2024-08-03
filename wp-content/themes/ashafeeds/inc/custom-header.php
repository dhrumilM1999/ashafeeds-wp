<?php
/**
 * Custom header implementation
 *
 * @link https://codex.wordpress.org/Custom_Headers
 *
 * @package Asha Feeds
 * @subpackage ashafeeds
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses ashafeeds_header_style()
 */
function ashafeeds_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'ashafeeds_custom_header_args', array(
		'default-text-color'     => 'fff',
		'header-text' 			 =>	false,
		'width'                  => 1600,
		'height'                 => 400,
		'flex-width'         	 => true,
    	'flex-height'            => true,
		'wp-head-callback'       => 'ashafeeds_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'ashafeeds_custom_header_setup' );

if ( ! function_exists( 'ashafeeds_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see ashafeeds_custom_header_setup().
 */
add_action( 'wp_enqueue_scripts', 'ashafeeds_header_style' );
function ashafeeds_header_style() {
	//Check if user has defined any header image.
	if ( get_header_image() ) :
	$ashafeeds_custom_css = "
        .headerbox{
			background-image:url('".esc_url(get_header_image())."');
			background-position: center top;
		}";
	   	wp_add_inline_style( 'ashafeeds-style', $ashafeeds_custom_css );
	endif;
}
endif; // ashafeeds_header_style
