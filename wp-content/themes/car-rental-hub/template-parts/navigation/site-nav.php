<?php
/*
* Display Theme menus
*/

$automobile_hub_sticky = get_theme_mod('automobile_hub_sticky');
    $data_sticky = "false";
    if ($automobile_hub_sticky) {
    $data_sticky = "true";
    }
    global $wp_customize;
?>
<div class="menubar <?php if( is_user_logged_in() && !isset( $wp_customize ) ){ echo "login-user";} ?>" data-sticky="<?php echo esc_attr($data_sticky); ?>">
	<div class="menubox">
		<div class="innermenubox">
			<?php if(has_nav_menu('primary-menu')){ ?>
	  			<div class="toggle-nav mobile-menu">
	    			<button onclick="automobile_hub_menu_open_nav()" class="responsivetoggle"><i class="fas fa-bars"></i><span class="screen-reader-text"><?php esc_html_e('Open Button','car-rental-hub'); ?></span></button>
	  			</div>
	  		<?php }?>
		 	<div id="mySidenav" class="nav sidenav">
				<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Top Menu', 'car-rental-hub' ); ?>">
	              	<?php if(has_nav_menu('primary-menu')){
	                  	wp_nav_menu( array(
		                    'theme_location' => 'primary-menu',
		                    'container_class' => 'main-menu clearfix' ,
		                    'menu_class' => 'clearfix',
		                    'items_wrap' => '<ul id="%1$s" class="%2$s mobile_nav">%3$s</ul>',
		                    'fallback_cb' => 'wp_page_menu',
	                  	) );
	              	} ?>
	  				<a href="javascript:void(0)" class="closebtn mobile-menu" onclick="automobile_hub_menu_close_nav()"><i class="fas fa-times"></i><span class="screen-reader-text"><?php esc_html_e('Close Button','car-rental-hub'); ?></span></a>
	    		</nav>
	  		</div>
			<div class="clearfix"></div>
		</div>
  	</div>
</div>
