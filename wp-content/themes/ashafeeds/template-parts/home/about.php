<?php
/**
 * Template part for displaying About section
 *
 * @package Asha Feeds
 * @subpackage ashafeeds
 */
?>

<section id="about">
  <div class="container">
    <?php if( get_theme_mod('ashafeeds_about_tittle') != ''){ ?>
      <h3><?php echo esc_html(get_theme_mod('ashafeeds_about_tittle','')); ?></h3>
    <?php }?>
    <div class="row">
      <?php $ashafeeds_about_page = array();
        $ashafeeds_mod = absint( get_theme_mod( 'ashafeeds_about_page' ));
        if ( 'page-none-selected' != $ashafeeds_mod ) {
          $ashafeeds_about_page[] = $ashafeeds_mod;
        }
      if( !empty($ashafeeds_about_page) ) :
        $ashafeeds_args = array(
          'post_type' => 'page',
          'post__in' => $ashafeeds_about_page,
          'orderby' => 'post__in'
        );
        $ashafeeds_query = new WP_Query( $ashafeeds_args );
        if ( $ashafeeds_query->have_posts() ) :
          while ( $ashafeeds_query->have_posts() ) : $ashafeeds_query->the_post(); ?>
            <div class="col-lg-5 col-md-5">
              <h4><?php the_title(); ?></h4>
              <p><?php the_excerpt(); ?></p>
              <div class="more-btn">
                <i class="fas fa-hand-point-right"></i><a href="<?php the_permalink(); ?>"><?php esc_html_e('READ MORE','ashafeeds'); ?></a>
                </a>
              </div>
            </div>
            <div class="col-lg-7 col-md-7">
              <?php the_post_thumbnail(); ?>
            </div>
          <?php endwhile; ?>
        <?php else : ?>
          <div class="no-postfound"></div>
        <?php endif;
      endif;
      wp_reset_postdata()?>
      <div class="clearfix"></div>
    </div>
  </div>
</section>
