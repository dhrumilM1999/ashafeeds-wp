<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Asha Feeds
 * @subpackage ashafeeds
 */

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function ashafeeds_categorized_blog() {
	$ashafeeds_category_count = get_transient( 'ashafeeds_categories' );

	if ( false === $ashafeeds_category_count ) {
		// Create an array of all the categories that are attached to posts.
		$ashafeeds_categories = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$ashafeeds_category_count = count( $ashafeeds_categories );

		set_transient( 'ashafeeds_categories', $ashafeeds_category_count );
	}

	// Allow viewing case of 0 or 1 categories in post preview.
	if ( is_preview() ) {
		return true;
	}

	return $ashafeeds_category_count > 1;
}

if ( ! function_exists( 'ashafeeds_the_custom_logo' ) ) :
/**
 * Displays the optional custom logo.
 *
 * Does nothing if the custom logo is not available.
 *
 * @since Asha Feeds
 */
function ashafeeds_the_custom_logo() {
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}
}
endif;

/**
 * Flush out the transients used in ashafeeds_categorized_blog.
 */
function ashafeeds_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'ashafeeds_categories' );
}
add_action( 'edit_category', 'ashafeeds_category_transient_flusher' );
add_action( 'save_post',     'ashafeeds_category_transient_flusher' );
