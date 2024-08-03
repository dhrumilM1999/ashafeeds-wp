<?php

	$ashafeeds_theme_lay = get_theme_mod( 'ashafeeds_tp_body_layout_settings','Full');
    if($ashafeeds_theme_lay == 'Container'){
		$ashafeeds_tp_theme_css .='body{';
			$ashafeeds_tp_theme_css .='max-width: 1140px; width: 100%; padding-right: 15px; padding-left: 15px; margin-right: auto; margin-left: auto;';
		$ashafeeds_tp_theme_css .='}';
		$ashafeeds_tp_theme_css .='.scrolled{';
			$ashafeeds_tp_theme_css .='width: auto; left:0; right:0;';
		$ashafeeds_tp_theme_css .='}';
	}else if($ashafeeds_theme_lay == 'Container Fluid'){
		$ashafeeds_tp_theme_css .='body{';
			$ashafeeds_tp_theme_css .='width: 100%;padding-right: 15px;padding-left: 15px;margin-right: auto;margin-left: auto;';
		$ashafeeds_tp_theme_css .='}';
		$ashafeeds_tp_theme_css .='.scrolled{';
			$ashafeeds_tp_theme_css .='width: auto; left:0; right:0;';
		$ashafeeds_tp_theme_css .='}';
	}else if($ashafeeds_theme_lay == 'Full'){
		$ashafeeds_tp_theme_css .='body{';
			$ashafeeds_tp_theme_css .='max-width: 100%;';
		$ashafeeds_tp_theme_css .='}';
	}

    $ashafeeds_scroll_position = get_theme_mod( 'ashafeeds_scroll_top_position','Right');
    if($ashafeeds_scroll_position == 'Right'){
        $ashafeeds_tp_theme_css .='#return-to-top{';
            $ashafeeds_tp_theme_css .='right: 20px;';
        $ashafeeds_tp_theme_css .='}';
    }else if($ashafeeds_scroll_position == 'Left'){
        $ashafeeds_tp_theme_css .='#return-to-top{';
            $ashafeeds_tp_theme_css .='left: 20px;';
        $ashafeeds_tp_theme_css .='}';
    }else if($ashafeeds_scroll_position == 'Center'){
        $ashafeeds_tp_theme_css .='#return-to-top{';
            $ashafeeds_tp_theme_css .='right: 50%;left: 50%;';
        $ashafeeds_tp_theme_css .='}';
    }