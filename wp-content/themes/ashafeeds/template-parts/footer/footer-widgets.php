<?php
/**
 * Displays footer widgets if assigned
 *
 * @package Asha Feeds
 * @subpackage ashafeeds
 */

?>
<div class="container">
	<aside class="widget-area row" role="complementary" aria-label="<?php esc_attr_e( 'Footer', 'ashafeeds' ); ?>">
		<div class="col-lg-3 col-md-3">
			<?php dynamic_sidebar( 'footer-1' ); ?>
		</div>
		<div class="col-lg-3 col-md-3">
			<?php dynamic_sidebar( 'footer-2' ); ?>
		</div>
		<div class="col-lg-3 col-md-3">
			<?php dynamic_sidebar( 'footer-3' ); ?>
		</div>
		<div class="col-lg-3 col-md-3">
			<?php dynamic_sidebar( 'footer-4' ); ?>
		</div>
	</aside>
</div>