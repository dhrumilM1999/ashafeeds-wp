<?php
/**
 * Plugin generic functions file
 *
 * @package Hero Banner Ultimate
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Function to get unique value number
 * 
 * @since 1.0
 */
function hbu_get_unique() {
	static $unique = 0;
	$unique++;
	return $unique;
}

/**
 * Clean variables using sanitize_text_field. Arrays are cleaned recursively.
 * Non-scalar values are ignored.
 * 
 * @since 1.4
 */
function hbu_clean( $var ) {
	if ( is_array( $var ) ) {
		return array_map( 'wpspw_pro_clean', $var );
	} else {
		$data = is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
		return wp_unslash( $data );
	}
}

/**
 * Sanitize number value and return fallback value if it is blank
 * 
 * @since 1.4
 */
function hbu_clean_number( $var, $fallback = null, $type = 'int' ) {

	$var = trim( $var );
	$var = is_numeric( $var ) ? $var : 0;

	if ( $type == 'number' ) {
		$data = intval( $var );
	} else if ( $type == 'abs' ) {
		$data = abs( $var );
	} else if ( $type == 'float' ) {
		$data = (float)$var;
	} else {
		$data = absint( $var );
	}

	return ( empty( $data ) && isset( $fallback ) ) ? $fallback : $data;
}

/**
 * Sanitize URL
 * 
 * @since 1.4
 */
function hbu_clean_url( $url ) {
	return esc_url_raw( trim( $url ) );
}

/**
 * Sanitize Hex Color
 * 
 * @since 1.4
 */
function hbu_clean_color( $color, $fallback = null ) {

	if ( false === strpos( $color, 'rgba' ) ) {
		
		$data = sanitize_hex_color( $color );

	} else {

		$red	= 0;
		$green	= 0;
		$blue	= 0;
		$alpha	= 0.5;

		// By now we know the string is formatted as an rgba color so we need to further sanitize it.
		$color = str_replace( ' ', '', $color );
		sscanf( $color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );
		$data = 'rgba('.$red.','.$green.','.$blue.','.$alpha.')';
	}

	return ( empty( $data ) && $fallback ) ? $fallback : $data;
}

/**
 * Function to render popup content.
 * An alternate solution of apply_filter('the_content')
 *
 * Prioritize the function in a same order apply_filter('the_content') wp-includes/default-filters.php
 * 
 * @since 1.4
 */
function hbu_render_hero_banner_content( $hero_banner_content = '', $only_allowed_html = FALSE ) {

	if ( empty( $hero_banner_content ) ) {
		return false;
	}

	global $wp_embed;

	$hero_banner_content		= $wp_embed->run_shortcode( $hero_banner_content );
	$hero_banner_content		= $wp_embed->autoembed( $hero_banner_content );
	$hero_banner_content		= wptexturize( $hero_banner_content );
	$hero_banner_content		= wpautop( $hero_banner_content );
	$hero_banner_content		= shortcode_unautop( $hero_banner_content );

	// Since Version 5.5.0
	if ( function_exists('wp_filter_content_tags') ) {
		$hero_banner_content = wp_filter_content_tags( $hero_banner_content );
	}

	// Since Version 5.7.0
	if ( function_exists( 'wp_replace_insecure_home_url' ) ) {
		$hero_banner_content = wp_replace_insecure_home_url( $hero_banner_content );
	}

	$hero_banner_content	= do_shortcode( $hero_banner_content );
	$hero_banner_content	= convert_smilies( $hero_banner_content );
	$hero_banner_content	= str_replace( ']]>', ']]&gt;', $hero_banner_content );

	// Escaping with allowed Post HTML + IFRAME tag
	if ( $only_allowed_html ) {
		$hero_banner_content = wp_kses( $hero_banner_content, array_merge(
															array(
																'iframe' => array(
																	'src'				=> true,
																	'style'				=> true,
																	'id'				=> true,
																	'class'				=> true,
																	'height'			=> true,
																	'width'				=> true,
																	'title'				=> true,
																	'aria-describedby'	=> true,
																	'aria-details'		=> true,
																	'aria-label'		=> true,
																	'aria-labelledby'	=> true,
																	'aria-hidden' 		=> true,
																	'frameborder'		=> true,
																	'allowfullscreen'	=> true,
																	'loading'			=> true,
																	'allow'				=> true,
																	'data-*'			=> true,
																)
															),
															wp_kses_allowed_html( 'post' )
														) );
	}

	return apply_filters( 'hbu_hero_banner_content', $hero_banner_content );
}

/**
 * Function to get Banner style type
 * 
 * @since 1.0.0
 */
function hbu_banner_type() {
	$banner_type = array(
						'bgcolor'		=> __( 'Background Color','hero-banner-ultimate' ),
						'bgcolor_image'	=> __( 'Background Color and Image','hero-banner-ultimate' ),
						'image'			=> __( 'Background Image','hero-banner-ultimate' ),
						'video'			=> __( 'Background Video','hero-banner-ultimate' ),
						'video_image'	=> __( 'Background Video and Image','hero-banner-ultimate' ),
					);
	return apply_filters( 'hbu_banner_type', $banner_type );
}

/**
 * Function to get button style type
 * 
 * @since 1.0.0
 */
function hbu_button_type() {
	$button_type = array(
						'hbupro-black'				=> __( 'Black','hero-banner-ultimate' ),
						'hbupro-white'				=> __( 'White','hero-banner-ultimate' ),
						'hbupro-grey'				=> __( 'Gray','hero-banner-ultimate' ),
						'hbupro-azure'				=> __( 'Azure','hero-banner-ultimate' ),
						'hbupro-moderate-green'		=> __( 'Moderate Green','hero-banner-ultimate' ),
						'hbupro-soft-red'			=> __( 'Soft Red','hero-banner-ultimate' ),
						'hbupro-red'				=> __( 'Moderate Red','hero-banner-ultimate' ),
						'hbupro-green'				=> __( 'Green','hero-banner-ultimate' ),
						'hbupro-bright-yellow'		=> __( 'Bright Yellow','hero-banner-ultimate' ),
						'hbupro-orange'				=> __( 'Cyan','hero-banner-ultimate' ),
						'hbupro-orange'				=> __( 'Orange','hero-banner-ultimate' ),
						'hbupro-moderate-violet'	=> __( 'Moderate Violet','hero-banner-ultimate' ),
						'hbupro-dark-magenta'		=> __( 'Dark Magenta','hero-banner-ultimate' ),
						'hbupro-moderate-blue'		=> __( 'Moderate Blue','hero-banner-ultimate' ),
						'hbupro-blue'				=> __( 'Blue','hero-banner-ultimate' ),
						'hbupro-magenta'			=> __( 'Magenta','hero-banner-ultimate' ),
						'hbupro-lime'				=> __( 'Lime','hero-banner-ultimate' ),
						'hbupro-pink'				=> __( 'Pink','hero-banner-ultimate' ),
						'hbupro-vivid-yellow'		=> __( 'Vivid Yellow','hero-banner-ultimate' ),
						'hbupro-lime-green'			=> __( 'Lime Green','hero-banner-ultimate' ),
						'hbupro-yellow'				=> __( 'Yellow','hero-banner-ultimate' ),
					);
	return apply_filters( 'hbu_button_type', $button_type );
}

/**
 * Function to get button style type
 * 
 * @since 1.0.0
 */
function hbu_banner_layout() {
	$banner_layout = array(
						'layout-1'	=> __( 'Layout 1','hero-banner-ultimate' ),
						'layout-2'	=> __( 'Layout 2','hero-banner-ultimate' ),
						'layout-3'	=> __( 'Layout 3','hero-banner-ultimate' ),
						'layout-4'	=> __( 'Layout 4','hero-banner-ultimate' ),
					);
	return apply_filters( 'hbu_banner_layout', $banner_layout );
}

/**
 * Function to add array after specific key
 * 
 * @since 1.0.0
 */
function hbu_add_array(&$array, $value, $index, $from_last = false) {

	if( is_array($array) && is_array($value) ) {

		if( $from_last ) {
			$total_count	= count($array);
			$index			= (!empty($total_count) && ($total_count > $index)) ? ($total_count-$index): $index;
		}

		$split_arr	= array_splice($array, max(0, $index));
		$array		= array_merge( $array, $value, $split_arr);
	}
	
	return $array;
}

/**
 * Function to get  Image background size
 * 
 * @since 1.0.0
 */
function hbu_bg_size() {
	$bgsize_arr = array(
		'auto'		=> __( 'Auto', 'post-grid-and-filter-ultimate' ),
		'cover'		=> __( 'Cover', 'post-grid-and-filter-ultimate' ),
		'contain'	=> __( 'Contain', 'post-grid-and-filter-ultimate' ),
		);
	return apply_filters('hbu_bg_size', $bgsize_arr );
}

/**
 * Function to get  Image background Attachment
 * 
 * @since 1.0.0
 */
function hbu_bg_attachemnt() {
	$attachemnt_arr = array(
		'fixed'		=> __( 'Fixed', 'post-grid-and-filter-ultimate' ),
		'scroll'	=> __( 'Scroll', 'post-grid-and-filter-ultimate' ),
		);
	return apply_filters('hbu_bg_attachemnt', $attachemnt_arr );
}