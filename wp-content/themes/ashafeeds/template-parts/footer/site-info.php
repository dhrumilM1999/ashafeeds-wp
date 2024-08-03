<?php
/**
 * Displays footer site info
 *
 * @package Asha Feeds
 * @subpackage ashafeeds
 */

?>
<div class="site-info">
	<div class="container">
		<p><?php ashafeeds_credit();?> <?php echo esc_html(get_theme_mod('ashafeeds_footer_text',__('By Themespride','ashafeeds'))); ?></p>
	</div>
</div>