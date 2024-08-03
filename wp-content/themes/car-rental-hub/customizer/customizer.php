<?php

function car_rental_hub_remove_customize_register() {
    global $wp_customize;
    $wp_customize->remove_section( 'automobile_hub_color_option' );
    $wp_customize->remove_section( 'automobile_hub_documentation' );
    $wp_customize->remove_section( 'automobile_hub_social_media' );

    $wp_customize->remove_setting( 'automobile_hub_search_icon' );
	$wp_customize->remove_control( 'automobile_hub_search_icon' );
}
add_action( 'customize_register', 'car_rental_hub_remove_customize_register', 11 );

function car_rental_hub_customize_register( $wp_customize ) {

	$wp_customize->add_setting('car_rental_hub_location_text',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('car_rental_hub_location_text',array(
		'label'	=> __('Add Location Text','car-rental-hub'),
		'section'	=> 'automobile_hub_topbar',
		'type'		=> 'text'
	));

	$wp_customize->add_setting('car_rental_hub_location',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('car_rental_hub_location',array(
		'label'	=> __('Add Location','car-rental-hub'),
		'section'	=> 'automobile_hub_topbar',
		'type'		=> 'text'
	));

	$wp_customize->add_section( 'car_rental_hub_featured_car_section' , array(
    	'title'      => __( 'Best Car Deals Settings', 'car-rental-hub' ),
		'panel' => 'automobile_hub_panel_id'
	) );

	$wp_customize->add_setting('car_rental_hub_featured_car_section_tittle',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('car_rental_hub_featured_car_section_tittle',array(
		'label'	=> __('Section Title','car-rental-hub'),
		'section'	=> 'car_rental_hub_featured_car_section',
		'type'		=> 'text'
	));

	$wp_customize->add_setting('car_rental_hub_featured_car_section_text',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('car_rental_hub_featured_car_section_text',array(
		'label'	=> __('Section Text','car-rental-hub'),
		'section'	=> 'car_rental_hub_featured_car_section',
		'type'		=> 'text'
	));

	$categories = get_categories();
	$cats = array();
	$i = 0;
	$offer_cat[]= 'select';
	foreach($categories as $category){
		if($i==0){
			$default = $category->slug;
			$i++;
		}
		$offer_cat[$category->slug] = $category->name;
	}

	$wp_customize->add_setting('car_rental_hub_featured_car_section_category',array(
		'default'	=> 'select',
		'sanitize_callback' => 'automobile_hub_sanitize_choices',
	));
	$wp_customize->add_control('car_rental_hub_featured_car_section_category',array(
		'type'    => 'select',
		'choices' => $offer_cat,
		'label' => __('Select Category','car-rental-hub'),
		'section' => 'car_rental_hub_featured_car_section',
	));

}
add_action( 'customize_register', 'car_rental_hub_customize_register' );