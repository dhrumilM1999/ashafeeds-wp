<?php
/**
 * The sidebar containing the main widget area
 *
 * @package Asha Feeds
 * @subpackage ashafeeds
 */
?>

<aside id="theme-sidebar" class="widget-area" role="complementary" aria-label="<?php esc_attr_e( 'Blog Sidebar', 'ashafeeds' ); ?>">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>