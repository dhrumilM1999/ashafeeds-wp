<?php
/**
 * Asha Feeds: Customizer
 *
 * @package Asha Feeds
 * @subpackage ashafeeds
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function ashafeeds_customize_register( $wp_customize ) {

	//add home page setting pannel
	$wp_customize->add_panel( 'ashafeeds_panel_id', array(
	    'priority' => 10,
	    'capability' => 'edit_theme_options',
	    'theme_supports' => '',
	    'title' => __( 'Custom Home page', 'ashafeeds' ),
	    'description' => __( 'Description of what this panel does.', 'ashafeeds' ),
	) );

	//TP Color Option
	$wp_customize->add_section('ashafeeds_color_option',array(
     'title'         => __('TP Color Option', 'ashafeeds'),
     'priority' => 10,
     'panel' => 'ashafeeds_panel_id'
    ) );

	$wp_customize->add_setting( 'ashafeeds_tp_color_option', array(
	    'default' => '',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ashafeeds_tp_color_option', array(
	    'description' => __('It will change the complete theme color in one click.', 'ashafeeds'),
	    'section' => 'ashafeeds_color_option',
	    'settings' => 'ashafeeds_tp_color_option',
  	)));

  	$wp_customize->add_setting( 'ashafeeds_tp_color_option_link', array(
	    'default' => '',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ashafeeds_tp_color_option_link', array(
	    'description' => __('It will change the complete theme hover link color in one click.', 'ashafeeds'),
	    'section' => 'ashafeeds_color_option',
	    'settings' => 'ashafeeds_tp_color_option_link',
  	)));

	//Sidebar Position
	$wp_customize->add_section('ashafeeds_tp_general_settings',array(
        'title' => __('TP General Option', 'ashafeeds'),
        'priority' => 2,
        'panel' => 'ashafeeds_panel_id'
    ) );

   $wp_customize->add_setting('ashafeeds_tp_body_layout_settings',array(
        'default' => 'Full',
        'sanitize_callback' => 'ashafeeds_sanitize_choices'
	));
   $wp_customize->add_control('ashafeeds_tp_body_layout_settings',array(
        'type' => 'radio',
        'label'     => __('Body Layout Setting', 'ashafeeds'),
        'description'   => __('This option work for complete body, if you want to set the complete website in container.', 'ashafeeds'),
        'section' => 'ashafeeds_tp_general_settings',
        'choices' => array(
            'Full' => __('Full','ashafeeds'),
            'Container' => __('Container','ashafeeds'),
            'Container Fluid' => __('Container Fluid','ashafeeds')
        ),
	) );

    // Add Settings and Controls for Post Layout
	$wp_customize->add_setting('ashafeeds_sidebar_post_layout',array(
        'default' => 'right',
        'sanitize_callback' => 'ashafeeds_sanitize_choices'
	));
	$wp_customize->add_control('ashafeeds_sidebar_post_layout',array(
        'type' => 'radio',
        'label'     => __('Theme Sidebar Position', 'ashafeeds'),
        'description'   => __('This option work for blog page, blog single page, archive page and search page.', 'ashafeeds'),
        'section' => 'ashafeeds_tp_general_settings',
        'choices' => array(
            'full' => __('Full','ashafeeds'),
            'left' => __('Left','ashafeeds'),
            'right' => __('Right','ashafeeds'),
            'three-column' => __('Three Columns','ashafeeds'),
            'four-column' => __('Four Columns','ashafeeds'),
            'grid' => __('Grid Layout','ashafeeds')
        ),
	) );

	// Add Settings and Controls for Page Layout
	$wp_customize->add_setting('ashafeeds_sidebar_page_layout',array(
        'default' => 'right',
        'sanitize_callback' => 'ashafeeds_sanitize_choices'
	));
	$wp_customize->add_control('ashafeeds_sidebar_page_layout',array(
        'type' => 'radio',
        'label'     => __('Page Sidebar Position', 'ashafeeds'),
        'description'   => __('This option work for pages.', 'ashafeeds'),
        'section' => 'ashafeeds_tp_general_settings',
        'choices' => array(
            'full' => __('Full','ashafeeds'),
            'left' => __('Left','ashafeeds'),
            'right' => __('Right','ashafeeds')
        ),
	) );

	$wp_customize->add_setting('ashafeeds_sticky',array(
		'default' => false,
		'sanitize_callback'	=> 'ashafeeds_sanitize_checkbox'
	));
	$wp_customize->add_control('ashafeeds_sticky',array(
		'type' => 'checkbox',
		'label' => __('Show / Hide Sticky Header','ashafeeds'),
		'section' => 'ashafeeds_tp_general_settings',
	));

	//TP Blog Option
	$wp_customize->add_section('ashafeeds_blog_option',array(
        'title' => __('TP Blog Option', 'ashafeeds'),
        'priority' => 1,
        'panel' => 'ashafeeds_panel_id'
    ) );

    $wp_customize->add_setting('ashafeeds_remove_date',array(
       'default' => true,
       'sanitize_callback'	=> 'ashafeeds_sanitize_checkbox'
    ));
    $wp_customize->add_control('ashafeeds_remove_date',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Date Option','ashafeeds'),
       'section' => 'ashafeeds_blog_option',
    ));
    $wp_customize->selective_refresh->add_partial( 'ashafeeds_remove_date', array(
		'selector' => '.entry-date',
		'render_callback' => 'ashafeeds_customize_partial_ashafeeds_remove_date',
	 ) );

    $wp_customize->add_setting('ashafeeds_remove_author',array(
       'default' => true,
       'sanitize_callback'	=> 'ashafeeds_sanitize_checkbox'
    ));
    $wp_customize->add_control('ashafeeds_remove_author',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Author Option','ashafeeds'),
       'section' => 'ashafeeds_blog_option',
    ));
    $wp_customize->selective_refresh->add_partial( 'ashafeeds_remove_author', array(
		'selector' => '.entry-author',
		'render_callback' => 'ashafeeds_customize_partial_ashafeeds_remove_author',
	 ) );

    $wp_customize->add_setting('ashafeeds_remove_comments',array(
       'default' => true,
       'sanitize_callback'	=> 'ashafeeds_sanitize_checkbox'
    ));
    $wp_customize->add_control('ashafeeds_remove_comments',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Comment Option','ashafeeds'),
       'section' => 'ashafeeds_blog_option',
    ));
    $wp_customize->selective_refresh->add_partial( 'ashafeeds_remove_comments', array(
		'selector' => '.entry-comments',
		'render_callback' => 'ashafeeds_customize_partial_ashafeeds_remove_comments',
	 ) );

    $wp_customize->add_setting('ashafeeds_remove_tags',array(
       'default' => true,
       'sanitize_callback'	=> 'ashafeeds_sanitize_checkbox'
    ));
    $wp_customize->add_control('ashafeeds_remove_tags',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Tags Option','ashafeeds'),
       'section' => 'ashafeeds_blog_option',
    ));

    $wp_customize->add_setting('ashafeeds_remove_read_button',array(
       'default' => true,
       'sanitize_callback'	=> 'ashafeeds_sanitize_checkbox'
    ));
    $wp_customize->add_control('ashafeeds_remove_read_button',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Read More Button','ashafeeds'),
       'section' => 'ashafeeds_blog_option',
    ));
    $wp_customize->selective_refresh->add_partial( 'ashafeeds_remove_read_button', array(
		'selector' => '.readmore-btn',
		'render_callback' => 'ashafeeds_customize_partial_ashafeeds_remove_read_button',
	 ) );

    $wp_customize->add_setting('ashafeeds_read_more_text',array(
		'default'=> __('Read More','ashafeeds'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('ashafeeds_read_more_text',array(
		'label'	=> __('Edit Button Text','ashafeeds'),
		'section'=> 'ashafeeds_blog_option',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'ashafeeds_excerpt_count', array(
		'default'              => 35,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'ashafeeds_sanitize_number_range',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'ashafeeds_excerpt_count', array(
		'label'       => esc_html__( 'Edit Excerpt Limit','ashafeeds' ),
		'section'     => 'ashafeeds_blog_option',
		'type'        => 'number',
		'input_attrs' => array(
			'step'             => 2,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	//TP Preloader Option
	$wp_customize->add_section('ashafeeds_prelaoder_option',array(
		'title'         => __('TP Preloader Option', 'ashafeeds'),
		'priority' => 3,
		'panel' => 'ashafeeds_panel_id'
	) );

	$wp_customize->add_setting('ashafeeds_preloader_show_hide',array(
		'default' => false,
		'sanitize_callback'	=> 'ashafeeds_sanitize_checkbox'
	));
 	$wp_customize->add_control('ashafeeds_preloader_show_hide',array(
		'type' => 'checkbox',
		'label' => __('Show / Hide Preloader Option','ashafeeds'),
		'section' => 'ashafeeds_prelaoder_option',
	));

	$wp_customize->add_setting( 'ashafeeds_tp_preloader_color1_option', array(
	    'default' => '',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ashafeeds_tp_preloader_color1_option', array(
	    'description' => __('It will change the complete theme preloader ring 1 color in one click.', 'ashafeeds'),
	    'section' => 'ashafeeds_prelaoder_option',
	    'settings' => 'ashafeeds_tp_preloader_color1_option',
  	)));

  	$wp_customize->add_setting( 'ashafeeds_tp_preloader_color2_option', array(
	    'default' => '',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ashafeeds_tp_preloader_color2_option', array(
	    'description' => __('It will change the complete theme preloader ring 2 color in one click.', 'ashafeeds'),
	    'section' => 'ashafeeds_prelaoder_option',
	    'settings' => 'ashafeeds_tp_preloader_color2_option',
  	)));

  	$wp_customize->add_setting( 'ashafeeds_tp_preloader_bg_color_option', array(
	    'default' => '',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ashafeeds_tp_preloader_bg_color_option', array(
	    'description' => __('It will change the complete theme preloader bg color in one click.', 'ashafeeds'),
	    'section' => 'ashafeeds_prelaoder_option',
	    'settings' => 'ashafeeds_tp_preloader_bg_color_option',
  	)));

	// Top Bar
	$wp_customize->add_section( 'ashafeeds_topbar', array(
    	'title'      => __( 'Contact Details', 'ashafeeds' ),
    	'priority' => 4,
    	'description' => __( 'Add your contact details', 'ashafeeds' ),
		'panel' => 'ashafeeds_panel_id'
	) );

	$wp_customize->add_setting('ashafeeds_mail_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('ashafeeds_mail_text',array(
		'label'	=> __('Add Email Text','ashafeeds'),
		'section'=> 'ashafeeds_topbar',
		'type'=> 'text'
	));

	$wp_customize->add_setting('ashafeeds_mail',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_email'
	));
	$wp_customize->add_control('ashafeeds_mail',array(
		'label'	=> __('Add Mail Address','ashafeeds'),
		'section'=> 'ashafeeds_topbar',
		'type'=> 'text'
	));

	$wp_customize->add_setting('ashafeeds_call_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('ashafeeds_call_text',array(
		'label'	=> __('Add Call Text','ashafeeds'),
		'section'=> 'ashafeeds_topbar',
		'type'=> 'text'
	));

	$wp_customize->selective_refresh->add_partial( 'ashafeeds_call_text', array(
		'selector' => '.headerbox .call',
		'render_callback' => 'ashafeeds_customize_partial_ashafeeds_call_text',
	) );

	$wp_customize->add_setting('ashafeeds_call',array(
		'default'=> '',
		'sanitize_callback'	=> 'ashafeeds_sanitize_phone_number'
	));
	$wp_customize->add_control('ashafeeds_call',array(
		'label'	=> __('Add Phone Number','ashafeeds'),
		'section'=> 'ashafeeds_topbar',
		'type'=> 'text'
	));

	$wp_customize->add_setting('ashafeeds_search_icon',array(
		'default' => true,
		'sanitize_callback'	=> 'ashafeeds_sanitize_checkbox'
	));
 	$wp_customize->add_control('ashafeeds_search_icon',array(
		'type' => 'checkbox',
		'label' => __('Show / Hide Search Option','ashafeeds'),
		'section' => 'ashafeeds_topbar',
	));

	$wp_customize->selective_refresh->add_partial( 'ashafeeds_search_icon', array(
		'selector' => '.search_btn i',
		'render_callback' => 'ashafeeds_customize_partial_ashafeeds_search_icon',
	) );

	//Social Media
	$wp_customize->add_section( 'ashafeeds_social_media', array(
    	'title'      => __( 'Social Media Links', 'ashafeeds' ),
    	'priority' => 5,
    	'description' => __( 'Add your Social Links', 'ashafeeds' ),
		'panel' => 'ashafeeds_panel_id'
	) );

	$wp_customize->selective_refresh->add_partial( 'ashafeeds_facebook_url', array(
		'selector' => '.social-media',
		'render_callback' => 'ashafeeds_customize_partial_ashafeeds_facebook_url',
	) );

	$wp_customize->add_setting('ashafeeds_facebook_url',array(
		'default'=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('ashafeeds_facebook_url',array(
		'label'	=> __('Facebook Link','ashafeeds'),
		'section'=> 'ashafeeds_social_media',
		'type'=> 'url'
	));

	$wp_customize->add_setting('ashafeeds_twitter_url',array(
		'default'=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('ashafeeds_twitter_url',array(
		'label'	=> __('Twitter Link','ashafeeds'),
		'section'=> 'ashafeeds_social_media',
		'type'=> 'url'
	));

	$wp_customize->add_setting('ashafeeds_instagram_url',array(
		'default'=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('ashafeeds_instagram_url',array(
		'label'	=> __('Instagram Link','ashafeeds'),
		'section'=> 'ashafeeds_social_media',
		'type'=> 'url'
	));

	$wp_customize->add_setting('ashafeeds_youtube_url',array(
		'default'=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('ashafeeds_youtube_url',array(
		'label'	=> __('YouTube Link','ashafeeds'),
		'section'=> 'ashafeeds_social_media',
		'type'=> 'url'
	));

	$wp_customize->add_setting('ashafeeds_pint_url',array(
		'default'=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('ashafeeds_pint_url',array(
		'label'	=> __('Pinterest Link','ashafeeds'),
		'section'=> 'ashafeeds_social_media',
		'type'=> 'url'
	));

	//home page slider
	$wp_customize->add_section( 'ashafeeds_slider_section' , array(
    	'title'      => __( 'Slider Section', 'ashafeeds' ),
    	'priority' => 6,
		'panel' => 'ashafeeds_panel_id'
	) );

	$wp_customize->add_setting('ashafeeds_slider_arrows',array(
       'default' => false,
       'sanitize_callback'	=> 'ashafeeds_sanitize_checkbox'
    ));
   $wp_customize->add_control('ashafeeds_slider_arrows',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide slider','ashafeeds'),
       'section' => 'ashafeeds_slider_section',
    ));

 	$wp_customize->selective_refresh->add_partial( 'ashafeeds_slider_arrows', array(
		'selector' => '#slider .carousel-caption',
		'render_callback' => 'ashafeeds_customize_partial_ashafeeds_slider_arrows',
	) );


	for ( $ashafeeds_count = 1; $ashafeeds_count <= 4; $ashafeeds_count++ ) {

		$wp_customize->add_setting( 'ashafeeds_slider_page' . $ashafeeds_count, array(
			'default'           => '',
			'sanitize_callback' => 'ashafeeds_sanitize_dropdown_pages'
		) );

		$wp_customize->add_control( 'ashafeeds_slider_page' . $ashafeeds_count, array(
			'label'    => __( 'Select Slide Image Page', 'ashafeeds' ),
			'section'  => 'ashafeeds_slider_section',
			'type'     => 'dropdown-pages'
		) );

	}

	//About Section
	$wp_customize->add_section('ashafeeds_about_section',array(
		'title'	=> __('About Section','ashafeeds'),
		'panel' => 'ashafeeds_panel_id',
	));

	$wp_customize->add_setting('ashafeeds_about_tittle',array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('ashafeeds_about_tittle',array(
		'label'	=> __('About Title','ashafeeds'),
		'section'	=> 'ashafeeds_about_section',
		'type'		=> 'text'
	));
	$wp_customize->selective_refresh->add_partial( 'ashafeeds_about_tittle', array(
		'selector' => '#about h3',
		'render_callback' => 'ashafeeds_customize_partial_ashafeeds_about_tittle',
	) );

	$wp_customize->add_setting( 'ashafeeds_about_page', array(
		'default'           => '',
		'sanitize_callback' => 'ashafeeds_sanitize_dropdown_pages'
	) );

	$wp_customize->add_control( 'ashafeeds_about_page', array(
		'label'    => __( 'Select About Page', 'ashafeeds' ),
		'section'  => 'ashafeeds_about_section',
		'type'     => 'dropdown-pages'
	) );

	//footer
	$wp_customize->add_section('ashafeeds_footer_section',array(
		'title'	=> __('Footer Text','ashafeeds'),
		'description'	=> __('Add copyright text.','ashafeeds'),
		'panel' => 'ashafeeds_panel_id'
	));

	$wp_customize->add_setting('ashafeeds_footer_text',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('ashafeeds_footer_text',array(
		'label'	=> __('Copyright Text','ashafeeds'),
		'section'	=> 'ashafeeds_footer_section',
		'type'		=> 'text'
	));

	$wp_customize->selective_refresh->add_partial( 'ashafeeds_footer_text', array(
		'selector' => '#footer p',
		'render_callback' => 'ashafeeds_customize_partial_ashafeeds_footer_text',
	) );

    $wp_customize->add_setting('ashafeeds_return_to_header',array(
       'default' => true,
       'sanitize_callback'	=> 'ashafeeds_sanitize_checkbox'
    ));
    $wp_customize->add_control('ashafeeds_return_to_header',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Return to header','ashafeeds'),
       'section' => 'ashafeeds_footer_section',
    ));

    // Add Settings and Controls for Scroll top
	$wp_customize->add_setting('ashafeeds_scroll_top_position',array(
        'default' => 'Right',
        'sanitize_callback' => 'ashafeeds_sanitize_choices'
	));
	$wp_customize->add_control('ashafeeds_scroll_top_position',array(
        'type' => 'radio',
        'label'     => __('Scroll to top Position', 'ashafeeds'),
        'description'   => __('This option work for scroll to top', 'ashafeeds'),
        'section' => 'ashafeeds_footer_section',
        'choices' => array(
            'Right' => __('Right','ashafeeds'),
            'Left' => __('Left','ashafeeds'),
            'Center' => __('Center','ashafeeds')
        ),
	) );

	$wp_customize->get_setting( 'blogname' )->transport          = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport   = 'postMessage';

	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector' => '.site-title a',
		'render_callback' => 'ashafeeds_customize_partial_blogname',
	) );
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector' => '.site-description',
		'render_callback' => 'ashafeeds_customize_partial_blogdescription',
	) );

	$wp_customize->add_setting('ashafeeds_site_title',array(
       'default' => true,
       'sanitize_callback'	=> 'ashafeeds_sanitize_checkbox'
    ));
    $wp_customize->add_control('ashafeeds_site_title',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Site Title','ashafeeds'),
       'section' => 'title_tagline',
    ));

    $wp_customize->add_setting('ashafeeds_site_tagline',array(
       'default' => false,
       'sanitize_callback'	=> 'ashafeeds_sanitize_checkbox'
    ));
    $wp_customize->add_control('ashafeeds_site_tagline',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Tagline','ashafeeds'),
       'section' => 'title_tagline',
    ));

    $wp_customize->add_setting('ashafeeds_logo_width',array(
		'default' => 80,
		'sanitize_callback'	=> 'ashafeeds_sanitize_number_absint'
	));
	 $wp_customize->add_control('ashafeeds_logo_width',array(
		'label'	=> esc_html__('Here You Can Customize Your Logo Size','ashafeeds'),
		'section'	=> 'title_tagline',
		'type'		=> 'number'
	));

	$wp_customize->add_setting('ashafeeds_logo_settings',array(
        'default' => 'Different Line',
        'sanitize_callback' => 'ashafeeds_sanitize_choices'
	));
    $wp_customize->add_control('ashafeeds_logo_settings',array(
        'type' => 'radio',
        'label'     => __('Logo Layout Settings', 'ashafeeds'),
        'description'   => __('Here you have two options 1. Logo and Site tite in differnt line. 2. Logo and Site title in same line.', 'ashafeeds'),
        'section' => 'title_tagline',
        'choices' => array(
            'Different Line' => __('Different Line','ashafeeds'),
            'Same Line' => __('Same Line','ashafeeds')
        ),
	) );

	$wp_customize->add_setting('ashafeeds_per_columns',array(
		'default'=> 3,
		'sanitize_callback'	=> 'ashafeeds_sanitize_number_absint'
	));
	$wp_customize->add_control('ashafeeds_per_columns',array(
		'label'	=> __('Product Per Row','ashafeeds'),
		'section'=> 'woocommerce_product_catalog',
		'type'=> 'number'
	));

	$wp_customize->add_setting('ashafeeds_product_per_page',array(
		'default'=> 9,
		'sanitize_callback'	=> 'ashafeeds_sanitize_number_absint'
	));
	$wp_customize->add_control('ashafeeds_product_per_page',array(
		'label'	=> __('Product Per Page','ashafeeds'),
		'section'=> 'woocommerce_product_catalog',
		'type'=> 'number'
	));

    $wp_customize->add_setting('ashafeeds_product_sidebar',array(
       'default' => true,
       'sanitize_callback'	=> 'ashafeeds_sanitize_checkbox'
    ));
    $wp_customize->add_control('ashafeeds_product_sidebar',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Shop page sidebar','ashafeeds'),
       'section' => 'woocommerce_product_catalog',
    ));

    $wp_customize->add_setting('ashafeeds_single_product_sidebar',array(
       'default' => true,
       'sanitize_callback'	=> 'ashafeeds_sanitize_checkbox'
    ));
    $wp_customize->add_control('ashafeeds_single_product_sidebar',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Product page sidebar','ashafeeds'),
       'section' => 'woocommerce_product_catalog',
    ));
}
add_action( 'customize_register', 'ashafeeds_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @since Asha Feeds 1.0
 * @see ashafeeds_customize_register()
 *
 * @return void
 */
function ashafeeds_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @since Asha Feeds 1.0
 * @see ashafeeds_customize_register()
 *
 * @return void
 */
function ashafeeds_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

if ( ! defined( 'ashafeeds_PRO_THEME_NAME' ) ) {
	define( 'ashafeeds_PRO_THEME_NAME', esc_html__( 'Automobile Pro Theme', 'ashafeeds' ));
}
if ( ! defined( 'ashafeeds_PRO_THEME_URL' ) ) {
	define( 'ashafeeds_PRO_THEME_URL', esc_url('https://www.themespride.com/themes/automobile-wordpress-theme/'));
}
if ( ! defined( 'ashafeeds_DOCS_URL' ) ) {
	define( 'ashafeeds_DOCS_URL', esc_url('https://www.themespride.com/demo/docs/ashafeeds-lite/'));
}

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class ashafeeds_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections( $manager ) {

		// Load custom sections.
		load_template( trailingslashit( get_template_directory() ) . '/inc/section-pro.php' );

		// Register custom section types.
		$manager->register_section_type( 'ashafeeds_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section(
			new ashafeeds_Customize_Section_Pro(
				$manager,
				'ashafeeds_section_pro',
				array(
					'priority'   => 9,
					'title'    => ashafeeds_PRO_THEME_NAME,
					'pro_text' => esc_html__( 'Upgrade Pro', 'ashafeeds' ),
					'pro_url'  => esc_url( ashafeeds_PRO_THEME_URL, 'ashafeeds' ),
				)
			)
		);

		// Register sections.
		$manager->add_section(
			new ashafeeds_Customize_Section_Pro(
				$manager,
				'ashafeeds_documentation',
				array(
					'priority'   => 500,
					'title'    => esc_html__( 'Theme Documentation', 'ashafeeds' ),
					'pro_text' => esc_html__( 'Click Here', 'ashafeeds' ),
					'pro_url'  => esc_url( ashafeeds_DOCS_URL, 'ashafeeds'),
				)
			)
		);
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'ashafeeds-customize-controls', trailingslashit( esc_url( get_template_directory_uri() ) ) . '/assets/js/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'ashafeeds-customize-controls', trailingslashit( esc_url( get_template_directory_uri() ) ) . '/assets/css/customize-controls.css' );
	}
}

// Doing this customizer thang!
ashafeeds_Customize::get_instance();
