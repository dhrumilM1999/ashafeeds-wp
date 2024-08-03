<?php
/*
* Display Logo and contact details
*/
?>

<div class="headerbox">
  <div class="container">
    <div class="row">
      <div class="col-lg-2 col-md-2 col-8 align-self-md-center">
        <?php $ashafeeds_logo_settings = get_theme_mod( 'ashafeeds_logo_settings','Different Line');
        if($ashafeeds_logo_settings == 'Different Line'){ ?>
          <div class="logo">
            <?php if( has_custom_logo() ) ashafeeds_the_custom_logo(); ?>
            <?php if(get_theme_mod('ashafeeds_site_title',true) != ''){ ?>
              <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
            <?php }?>
            <?php $car_rental_hub_description = get_bloginfo( 'description', 'display' );
            if ( $car_rental_hub_description || is_customize_preview() ) : ?>
              <?php if(get_theme_mod('ashafeeds_site_tagline',true) != ''){ ?>
                <p class="site-description"><?php echo esc_html($car_rental_hub_description); ?></p>
              <?php }?>
            <?php endif; ?>
          </div>
        <?php }else if($ashafeeds_logo_settings == 'Same Line'){ ?>
          <div class="logo logo-same-line">
            <div class="row">
              <div class="col-lg-2 col-md-2 align-self-md-center">
                <?php if( has_custom_logo() ) ashafeeds_the_custom_logo(); ?>
              </div>
              <div class="col-lg-10 col-md-10 align-self-md-center">
                <?php if(get_theme_mod('ashafeeds_site_title',true) != ''){ ?>
                  <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                <?php }?>
                <?php $car_rental_hub_description = get_bloginfo( 'description', 'display' );
                if ( $car_rental_hub_description || is_customize_preview() ) : ?>
                  <?php if(get_theme_mod('ashafeeds_site_tagline',true) != ''){ ?>
                    <p class="site-description"><?php echo esc_html($car_rental_hub_description); ?></p>
                  <?php }?>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php }?>
      </div>
      <div class="col-lg-10 col-md-10 col-4 align-self-md-center">
        <?php get_template_part( 'template-parts/navigation/site', 'nav' ); ?>
      </div>
    </div>
  </div>
</div>
