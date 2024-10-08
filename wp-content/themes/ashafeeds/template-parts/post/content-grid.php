<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Asha Feeds
 * @subpackage ashafeeds
 */

?>
<article class="col-lg-4 col-md-4">
	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="page-box">
	        <div class="box-image">
	            <?php the_post_thumbnail();  ?>
	        </div>
		    <div class="box-content">
		    	<h4><a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>"><?php the_title();?></a></h4>
		        <div class="box-info">
	        	<?php if(get_theme_mod('ashafeeds_remove_date',true) != ''){ ?>
					<i class="far fa-calendar-alt"></i><span class="entry-date"><?php the_date(); ?></span>
				<?php }?>
				<?php if(get_theme_mod('ashafeeds_remove_author',true) != ''){ ?>
					<i class="fas fa-user"></i><span class="entry-author"><?php the_author(); ?></span>
				<?php }?>
				<?php if(get_theme_mod('ashafeeds_remove_comments',true) != ''){ ?>
					<i class="fas fa-comments"></i><span class="entry-comments"><?php comments_number( __('0 Comments','ashafeeds'), __('0 Comments','ashafeeds'), __('% Comments','ashafeeds') ); ?></span>
				<?php }?>
            </div>
	        <p><?php $ashafeeds_excerpt = get_the_excerpt(); echo esc_html( ashafeeds_string_limit_words( $ashafeeds_excerpt, esc_attr(get_theme_mod('ashafeeds_excerpt_count','35')))); ?></p>
	        <?php if(get_theme_mod('ashafeeds_remove_read_button',true) != ''){ ?>
	            <div class="readmore-btn">
	                <a href="<?php echo esc_url( get_permalink() );?>" class="blogbutton-small" title="<?php esc_attr_e( 'Read More', 'ashafeeds' ); ?>"><?php echo esc_html(get_theme_mod('ashafeeds_read_more_text',__('Read More','ashafeeds')));?></a>
	            </div>
	        <?php }?>
		    </div>
		    <div class="clearfix"></div>
		</div>
	</div>
</article>