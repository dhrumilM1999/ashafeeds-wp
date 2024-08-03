<?php

	$ashafeeds_tp_color_option = get_theme_mod('ashafeeds_tp_color_option');
	$ashafeeds_tp_color_option_link = get_theme_mod('ashafeeds_tp_color_option_link');
	$ashafeeds_tp_preloader_color1_option = get_theme_mod('ashafeeds_tp_preloader_color1_option');
	$ashafeeds_tp_preloader_color2_option = get_theme_mod('ashafeeds_tp_preloader_color2_option');
	$ashafeeds_tp_preloader_bg_color_option = get_theme_mod('ashafeeds_tp_preloader_bg_color_option');

	$ashafeeds_tp_theme_css = '';

	if($ashafeeds_tp_color_option != false){
		$ashafeeds_tp_theme_css .='#theme-sidebar button[type="submit"], #footer button[type="submit"],.prev.page-numbers, .next.page-numbers,.page-numbers,#comments input[type="submit"],.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt,span.meta-nav,.headerbox i, .more-btn i,.headerbox i:after,#theme-sidebar .tagcloud a:hover,
		#slider .carousel-control-prev-icon, #slider .carousel-control-next-icon{';
			$ashafeeds_tp_theme_css .='background-color: '.esc_attr($ashafeeds_tp_color_option).';';
		$ashafeeds_tp_theme_css .='}';
	}
	if($ashafeeds_tp_color_option != false){
		$ashafeeds_tp_theme_css .='p.infotext,a,.main-navigation .current_page_item > a, .main-navigation .current-menu-item > a, .main-navigation .current_page_ancestor > a,.main-navigation a:hover,#theme-sidebar h3,.search-box i,.headerbox i:hover,.social-media i:hover,#about h3{';
			$ashafeeds_tp_theme_css .='color: '.esc_attr($ashafeeds_tp_color_option).';';
		$ashafeeds_tp_theme_css .='}';
	}
	if($ashafeeds_tp_color_option != false){
		$ashafeeds_tp_theme_css .='#footer .tagcloud a:hover,.serach_inner form.search-form{';
			$ashafeeds_tp_theme_css .='border-color: '.esc_attr($ashafeeds_tp_color_option).';';
		$ashafeeds_tp_theme_css .='}';
	}
	if($ashafeeds_tp_color_option_link != false){
		$ashafeeds_tp_theme_css .='a:hover,#theme-sidebar a:hover{';
			$ashafeeds_tp_theme_css .='color: '.esc_attr($ashafeeds_tp_color_option_link).';';
		$ashafeeds_tp_theme_css .='}';
	}
	if($ashafeeds_tp_preloader_color1_option != false){
		$ashafeeds_tp_theme_css .='.center1{';
			$ashafeeds_tp_theme_css .='border-color: '.esc_attr($ashafeeds_tp_preloader_color1_option).' !important;';
		$ashafeeds_tp_theme_css .='}';
	}
	if($ashafeeds_tp_preloader_color1_option != false){
		$ashafeeds_tp_theme_css .='.center1 .ring::before{';
			$ashafeeds_tp_theme_css .='background: '.esc_attr($ashafeeds_tp_preloader_color1_option).' !important;';
		$ashafeeds_tp_theme_css .='}';
	}
	if($ashafeeds_tp_preloader_color2_option != false){
		$ashafeeds_tp_theme_css .='.center2{';
			$ashafeeds_tp_theme_css .='border-color: '.esc_attr($ashafeeds_tp_preloader_color2_option).' !important;';
		$ashafeeds_tp_theme_css .='}';
	}
	if($ashafeeds_tp_preloader_color2_option != false){
		$ashafeeds_tp_theme_css .='.center2 .ring::before{';
			$ashafeeds_tp_theme_css .='background: '.esc_attr($ashafeeds_tp_preloader_color2_option).' !important;';
		$ashafeeds_tp_theme_css .='}';
	}
	if($ashafeeds_tp_preloader_bg_color_option != false){
		$ashafeeds_tp_theme_css .='.loader{';
			$ashafeeds_tp_theme_css .='background: '.esc_attr($ashafeeds_tp_preloader_bg_color_option).';';
		$ashafeeds_tp_theme_css .='}';
	}