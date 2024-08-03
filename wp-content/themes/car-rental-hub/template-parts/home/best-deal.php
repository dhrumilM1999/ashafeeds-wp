<?php
/**
 * Template part for displaying best deals section
 *
 * @package Car Rental Hub
 * @subpackage car_rental_hub
 */
?>

<section id="featured-car" class="py-5">
  <div class="container">
    <?php if( get_theme_mod('car_rental_hub_featured_car_section_tittle') != ''){ ?>
      <h2 class="text-center"><?php echo esc_html(get_theme_mod('car_rental_hub_featured_car_section_tittle','')); ?></h2>
    <?php }?>
    <?php if( get_theme_mod('car_rental_hub_featured_car_section_text') != ''){ ?>
      <p class="mb-5 text-center section_text"><?php echo esc_html(get_theme_mod('car_rental_hub_featured_car_section_text','')); ?></p>
    <?php }?>
    <div class="row">
      <?php
        $car_rental_hub_post_category = get_theme_mod('car_rental_hub_featured_car_section_category');
        if($car_rental_hub_post_category){
          $car_rental_hub_page_query = new WP_Query(array( 'category_name' => esc_html( $car_rental_hub_post_category ,'car-rental-hub')));?>
          <?php while( $car_rental_hub_page_query->have_posts() ) : $car_rental_hub_page_query->the_post(); ?>
            <div class="col-lg-4 col-md-6">
              <div class="cat-inner-box mb-4">
                <?php if(has_post_thumbnail()) { ?><?php the_post_thumbnail(); ?><?php } ?>
                <?php if( get_post_meta($post->ID, 'car_rental_hub_mileage', true) || get_post_meta($post->ID, 'car_rental_hub_body_type', true) || get_post_meta($post->ID, 'car_rental_hub_mileage', true) ) {?>
                  <div class="featured-car-box">
                    <div class="row">
                      <div class="col-lg-4 col-md-4 col-4 align-self-center">
                        <?php if( get_post_meta($post->ID, 'car_rental_hub_body_type', true) ) {?>
                          <p class="mb-0"><i class="fas fa-car mr-2"></i><?php echo esc_html(get_post_meta($post->ID,'car_rental_hub_body_type',true)); ?></p>
                        <?php }?>
                      </div>
                      <div class="col-lg-4 col-md-4 col-4 align-self-center">
                        <?php if( get_post_meta($post->ID, 'car_rental_hub_model_year', true) ) {?>
                          <p class="mb-0"><i class="fas fa-calendar-alt mr-2"></i><?php echo esc_html(get_post_meta($post->ID,'car_rental_hub_model_year',true)); ?></p>
                        <?php }?>
                      </div>
                      <div class="col-lg-4 col-md-4 col-4 align-self-center">
                        <?php if( get_post_meta($post->ID, 'car_rental_hub_mileage', true) ) {?>
                          <p class="mb-0"><i class="fas fa-road mr-2"></i><?php echo esc_html(get_post_meta($post->ID,'car_rental_hub_mileage',true)); ?></p>
                        <?php }?>
                      </div>
                    </div>
                  </div>
                <?php }?>
                <div class="car-inner-content">
                  <div class="row">
                    <div class="col-lg-7 col-md-7 align-self-center">
                      <h3 class="mb-0"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    </div>
                    <div class="col-lg-5 col-md-5 align-self-center">
                      <?php if( get_post_meta($post->ID, 'car_rental_hub_compare_price', true) ) {?>
                        <p class="mb-0"><?php echo esc_html(get_post_meta($post->ID,'car_rental_hub_compare_price',true)); ?></p>
                      <?php }?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php endwhile;
          wp_reset_postdata();
        }
      ?>
    </div>
  </div>
</section>
