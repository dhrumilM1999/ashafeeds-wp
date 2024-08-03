<?php
/**
 * Template part for displaying contact info section
 *
 * @package Car Rental Hub
 * @subpackage car_rental_hub
 */
?>

<section id="contact-info">
  <div class="row m-0">
    <div class="call col-lg-4 col-md-4 align-self-md-center p-4">
      <?php if( get_theme_mod( 'automobile_hub_call' ) != '' || get_theme_mod('automobile_hub_call_text','') ) { ?>
        <div class="row">
          <div class="col-lg-3 col-md-3 align-self-md-center text-center"><i class="fas fa-phone"></i></div>
          <div class="col-lg-9 col-md-9 align-self-md-center">
            <p class="infotext"><?php echo esc_html( get_theme_mod('automobile_hub_call_text','') ); ?></p>
            <p class="simplep mb-0"><?php echo esc_html( get_theme_mod('automobile_hub_call','') ); ?></p>
          </div>
        </div>
      <?php } ?>
    </div>
    <div class="email col-lg-4 col-md-4 align-self-md-center p-4">
      <?php if( get_theme_mod( 'automobile_hub_mail' ) != '' || get_theme_mod('automobile_hub_mail_text','') ) { ?>
        <div class="row">
          <div class="col-lg-3 col-md-3 align-self-md-center text-center"><i class="fas fa-envelope-open"></i></div>
          <div class="col-lg-9 col-md-9 align-self-md-center">
            <p class="infotext"><?php echo esc_html( get_theme_mod('automobile_hub_mail_text','')); ?></p>
            <p class="simplep mb-0"><?php echo esc_html( get_theme_mod('automobile_hub_mail','') ); ?></p>
          </div>
        </div>
      <?php } ?>
    </div>
    <div class="call col-lg-4 col-md-4 align-self-md-center p-4">
      <?php if( get_theme_mod( 'car_rental_hub_location' ) != '' || get_theme_mod('car_rental_hub_location_text','') ) { ?>
        <div class="row">
          <div class="col-lg-3 col-md-3 align-self-md-center text-center"><i class="fas fa-map-marker-alt"></i></div>
          <div class="col-lg-9 col-md-9 align-self-md-center">
            <p class="infotext"><?php echo esc_html( get_theme_mod('car_rental_hub_location_text','')); ?></p>
            <p class="simplep mb-0"><?php echo esc_html( get_theme_mod('car_rental_hub_location','') ); ?></p>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</section> 