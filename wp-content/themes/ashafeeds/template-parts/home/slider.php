<?php
/**
 * Template part for displaying slider section
 *
 * @package Asha Feeds
 * @subpackage ashafeeds
 */

?>

<?php if( get_theme_mod( 'ashafeeds_slider_arrows') != '') { ?>

<section id="slider">
  <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <?php $ashafeeds_slide_pages = array();
      for ( $ashafeeds_count = 1; $ashafeeds_count <= 4; $ashafeeds_count++ ) {
        $ashafeeds_mod = intval( get_theme_mod( 'ashafeeds_slider_page' . $ashafeeds_count ));
        if ( 'page-none-selected' != $ashafeeds_mod ) {
          $ashafeeds_slide_pages[] = $ashafeeds_mod;
        }
      }
      if( !empty($ashafeeds_slide_pages) ) :
        $ashafeeds_args = array(
          'post_type' => 'page',
          'post__in' => $ashafeeds_slide_pages,
          'orderby' => 'post__in'
        );
        $ashafeeds_query = new WP_Query( $ashafeeds_args );
        if ( $ashafeeds_query->have_posts() ) :
          $i = 1;
    ?>
    <div class="carousel-inner" role="listbox">
      <?php  while ( $ashafeeds_query->have_posts() ) : $ashafeeds_query->the_post(); ?>
        <div <?php if($i == 1){echo 'class="carousel-item active"';} else{ echo 'class="carousel-item"';}?>>
          <img src="<?php esc_url(the_post_thumbnail_url('full')); ?>"/>
          <div class="carousel-caption">
            <div class="inner_carousel">
              <h2><?php the_title(); ?></h2>
              <p><?php $ashafeeds_excerpt = get_the_excerpt();echo esc_html( ashafeeds_string_limit_words( $ashafeeds_excerpt,15 ) ); ?></p>
              <div class="more-btn">
                <i class="fas fa-hand-point-right"></i><a href="<?php the_permalink(); ?>"><?php esc_html_e('READ MORE','ashafeeds'); ?></a>
              </div>
            </div>
          </div>
        </div>
      <?php $i++; endwhile;
      wp_reset_postdata();?>
    </div>
    <?php else : ?>
        <div class="no-postfound"></div>
      <?php endif;
    endif;?>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"><i class="fas fa-chevron-left"></i></span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"><i class="fas fa-chevron-right"></i></span>
    </a>
  </div>
  <div class="clearfix"></div>
</section>

<?php } ?>
