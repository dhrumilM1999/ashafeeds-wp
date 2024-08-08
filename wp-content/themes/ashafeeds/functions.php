<?php

/**
 * Asha Feeds functions and definitions
 *
 * @package Asha Feeds
 * @subpackage ashafeeds
 */

function ashafeeds_setup()
{

	load_theme_textdomain('ashafeeds', get_template_directory() . '/language');
	add_theme_support('automatic-feed-links');
	add_theme_support('woocommerce');
	add_theme_support('title-tag');
	add_theme_support("responsive-embeds");
	add_theme_support('wp-block-styles');
	add_theme_support('align-wide');
	add_theme_support('post-thumbnails');
	add_image_size('ashafeeds-featured-image', 2000, 1200, true);
	add_image_size('ashafeeds-thumbnail-avatar', 100, 100, true);
	$GLOBALS['content_width'] = 525;
	register_nav_menus(array(
		'primary-menu'    => __('Primary Menu', 'ashafeeds'),
	));
	add_theme_support('custom-logo', array(
		'width'       => 250,
		'height'      => 250,
		'flex-width'  => true,
		'flex-height' => true,
	));
	add_theme_support('customize-selective-refresh-widgets');

	add_theme_support('custom-background', array(
		'default-color' => 'ffffff'
	));

	/*
	 * Enable support for Post Formats.
	 *	 */
	add_theme_support('post-formats', array('image', 'video', 'gallery', 'audio',));

	add_theme_support('html5', array('comment-form', 'comment-list', 'gallery', 'caption',));
}
add_action('after_setup_theme', 'ashafeeds_setup');

/**
 * Enqueue scripts and styles.
 */
function ashafeeds_scripts()
{
	wp_enqueue_style('ashafeeds-style', get_stylesheet_uri());
	require get_parent_theme_file_path('/tp-theme-color.php');
	require get_parent_theme_file_path('/tp-body-width-layout.php');
	wp_add_inline_style('ashafeeds-style', $ashafeeds_tp_theme_css);
	wp_style_add_data('ashafeeds-style', 'rtl', 'replace');
	wp_enqueue_style('ashafeeds-block-style', get_theme_file_uri('/assets/css/blocks.css'), array('ashafeeds-style'), '1.0');
	wp_enqueue_style('fontawesome-css', get_theme_file_uri('/assets/css/fontawesome-all.css'));
	wp_enqueue_script('ashafeeds-focus-nav', get_template_directory_uri() . '/assets/js/focus-nav.js', array('jquery'), true);
}
add_action('wp_enqueue_scripts', 'ashafeeds_scripts');

function ashafeeds_admin_enqueue_scripts()
{
	wp_enqueue_style('ashafeeds-admin-style', get_template_directory_uri() . '/assets/css/admin.css');
	wp_enqueue_script('ashafeeds-custom-scripts', get_template_directory_uri() . '/assets/js/ashafeeds-custom.js', array('jquery'), true);
}
add_action('admin_enqueue_scripts', 'ashafeeds_admin_enqueue_scripts');

/*radio button sanitization*/
function ashafeeds_sanitize_choices($input, $setting)
{
	global $wp_customize;
	$control = $wp_customize->get_control($setting->id);
	if (array_key_exists($input, $control->choices)) {
		return $input;
	} else {
		return $setting->default;
	}
}

/* Excerpt Limit Begin */
function ashafeeds_string_limit_words($string, $word_limit)
{
	$words = explode(' ', $string, ($word_limit + 1));
	if (count($words) > $word_limit)
		array_pop($words);
	return implode(' ', $words);
}

function ashafeeds_sanitize_dropdown_pages($page_id, $setting)
{
	$page_id = absint($page_id);
	return ('publish' == get_post_status($page_id) ? $page_id : $setting->default);
}
add_filter('loop_shop_columns', 'ashafeeds_loop_columns');
if (!function_exists('ashafeeds_loop_columns')) {
	function ashafeeds_loop_columns()
	{
		$columns = get_theme_mod('ashafeeds_per_columns', 3);
		return $columns;
	}
}
add_filter('loop_shop_per_page', 'ashafeeds_per_page', 20);
function ashafeeds_per_page($cols)
{
	$cols = get_theme_mod('ashafeeds_product_per_page', 9);
	return $cols;
}

function ashafeeds_sanitize_phone_number($phone)
{
	return preg_replace('/[^\d+]/', '', $phone);
}

function ashafeeds_sanitize_number_range($number, $setting)
{
	$number = absint($number);
	$atts = $setting->manager->get_control($setting->id)->input_attrs;
	$min = (isset($atts['min']) ? $atts['min'] : $number);
	$max = (isset($atts['max']) ? $atts['max'] : $number);
	$step = (isset($atts['step']) ? $atts['step'] : 1);
	return ($min <= $number && $number <= $max && is_int($number / $step) ? $number : $setting->default);
}

function ashafeeds_sanitize_checkbox($input)
{
	return ((isset($input) && true == $input) ? true : false);
}

function ashafeeds_sanitize_number_absint($number, $setting)
{
	$number = absint($number);
	return ($number ? $number : $setting->default);
}

/**
 * Use front-page.php when Front page displays is set to a static page.
 */
function ashafeeds_front_page_template($template)
{
	return is_home() ? '' : $template;
}
add_filter('frontpage_template', 'ashafeeds_front_page_template');


function ashafeeds_logo_width()
{

	$ashafeeds_logo_width   = get_theme_mod('ashafeeds_logo_width', 80);

	echo "<style type='text/css' media='all'>"; ?>
	img.custom-logo{
	width: <?php echo absint($ashafeeds_logo_width); ?>px;
	max-width: 100%;
	}
<?php echo "</style>";
}

add_action('wp_head', 'ashafeeds_logo_width');

require get_parent_theme_file_path('/inc/custom-header.php');

require get_parent_theme_file_path('/inc/template-tags.php');

require get_parent_theme_file_path('/inc/template-functions.php');

require get_parent_theme_file_path('/inc/customizer.php');

require get_parent_theme_file_path('/inc/about-theme.php');

require get_parent_theme_file_path('/inc/wptt-webfont-loader.php');
