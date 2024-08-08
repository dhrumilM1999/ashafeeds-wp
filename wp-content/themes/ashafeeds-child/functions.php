<?php

require get_stylesheet_directory() . '/customizer/customizer.php';

add_action('after_setup_theme', 'car_rental_hub_after_setup_theme');
function car_rental_hub_after_setup_theme()
{
    add_theme_support('title-tag');
    add_theme_support('automatic-feed-links');
    add_theme_support("responsive-embeds");
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    add_theme_support('post-thumbnails');
    add_image_size('ashafeeds-child-featured-image', 2000, 1200, true);
    add_image_size('ashafeeds-child-thumbnail-avatar', 100, 100, true);

    // Set the default content width.
    $GLOBALS['content_width'] = 525;

    // Add theme support for Custom Logo.
    add_theme_support('custom-logo', array(
        'width'       => 250,
        'height'      => 250,
        'flex-width'  => true,
    ));

    add_theme_support('custom-background', array(
        'default-color' => 'ffffff'
    ));

    add_theme_support('html5', array('comment-form', 'comment-list', 'gallery', 'caption',));

    add_editor_style(array('assets/css/editor-style.css'));
}

/**
 * Register widget area.
 */
function car_rental_hub_widgets_init()
{
    register_sidebar(array(
        'name'          => __('Blog Sidebar', 'ashafeeds-child'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here to appear in your sidebar on blog posts and archive pages.', 'ashafeeds-child'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __('Page Sidebar', 'ashafeeds-child'),
        'id'            => 'sidebar-2',
        'description'   => __('Add widgets here to appear in your sidebar on pages.', 'ashafeeds-child'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __('Sidebar 3', 'ashafeeds-child'),
        'id'            => 'sidebar-3',
        'description'   => __('Add widgets here to appear in your sidebar on blog posts and archive pages.', 'ashafeeds-child'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __('Footer 1', 'ashafeeds-child'),
        'id'            => 'footer-1',
        'description'   => __('Add widgets here to appear in your footer.', 'ashafeeds-child'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __('Footer 2', 'ashafeeds-child'),
        'id'            => 'footer-2',
        'description'   => __('Add widgets here to appear in your footer.', 'ashafeeds-child'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __('Footer 3', 'ashafeeds-child'),
        'id'            => 'footer-3',
        'description'   => __('Add widgets here to appear in your footer.', 'ashafeeds-child'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __('Footer 4', 'ashafeeds-child'),
        'id'            => 'footer-4',
        'description'   => __('Add widgets here to appear in your footer.', 'ashafeeds-child'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'car_rental_hub_widgets_init');

// enqueue styles for child theme
function car_rental_hub_enqueue_styles()
{
    // Bootstrap
    wp_enqueue_style('font-css', 'https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&family=Sen:wght@400..800&display=swap');
    wp_enqueue_style('slick', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');
    // wp_enqueue_style('slick-theme', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css');
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');
    wp_enqueue_style('ashafeeds-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('ashafeeds-child-child-style', get_stylesheet_directory_uri() . '/style.css', array());
    wp_enqueue_style('ashafeeds-child-backend-css', get_theme_file_uri('/assets/css/customizer.css'));

    
    wp_enqueue_script('theme-jquery', 'https://code.jquery.com/jquery-3.6.4.min.js', array(), true, true);
    wp_enqueue_script('slick', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array(), false, true);
    wp_enqueue_script('comment-reply', '/wp-includes/js/comment-reply.min.js', array(), false, true);
    wp_enqueue_script('script', get_theme_file_uri() .'/assets/js/script.js', array(), false, true);
}
add_action('wp_enqueue_scripts', 'car_rental_hub_enqueue_styles');


// Featured Cars Meta
function car_rental_hub_bn_custom_meta_featured()
{
    add_meta_box('bn_meta', __('Car Feature Meta Feilds', 'ashafeeds-child'), 'car_rental_hub_meta_callback_featured_car', 'post', 'normal', 'high');
}
/* Hook things in for admin*/
if (is_admin()) {
    add_action('admin_menu', 'car_rental_hub_bn_custom_meta_featured');
}

function car_rental_hub_meta_callback_featured_car($post)
{
    wp_nonce_field(basename(__FILE__), 'car_rental_hub_featured_car_meta_nonce');
    $car_rental_hub_bn_stored_meta = get_post_meta($post->ID);
    $car_rental_hub_compare_price = get_post_meta($post->ID, 'car_rental_hub_compare_price', true);
    $car_rental_hub_body_type = get_post_meta($post->ID, 'car_rental_hub_body_type', true);
    $car_rental_hub_model_year = get_post_meta($post->ID, 'car_rental_hub_model_year', true);
    $car_rental_hub_mileage = get_post_meta($post->ID, 'car_rental_hub_mileage', true);
?>
    <div id="custom_stuff">
        <table id="list">
            <tbody id="the-list" data-wp-lists="list:meta">
                <tr id="meta-8">
                    <td class="left">
                        <?php esc_html_e('Compare Price', 'ashafeeds-child') ?>
                    </td>
                    <td class="left">
                        <input type="text" name="car_rental_hub_compare_price" id="car_rental_hub_compare_price" value="<?php echo esc_attr($car_rental_hub_compare_price); ?>" />
                    </td>
                </tr>
                <tr id="meta-8">
                    <td class="left">
                        <?php esc_html_e('Car Body-Type', 'ashafeeds-child') ?>
                    </td>
                    <td class="left">
                        <input type="text" name="car_rental_hub_body_type" id="car_rental_hub_body_type" value="<?php echo esc_attr($car_rental_hub_body_type); ?>" />
                    </td>
                </tr>
                <tr id="meta-8">
                    <td class="left">
                        <?php esc_html_e('Car Model-Year', 'ashafeeds-child') ?>
                    </td>
                    <td class="left">
                        <input type="text" name="car_rental_hub_model_year" id="car_rental_hub_model_year" value="<?php echo esc_attr($car_rental_hub_model_year); ?>" />
                    </td>
                </tr>
                <tr id="meta-8">
                    <td class="left">
                        <?php esc_html_e('Car Mileage', 'ashafeeds-child') ?>
                    </td>
                    <td class="left">
                        <input type="text" name="car_rental_hub_mileage" id="car_rental_hub_mileage" value="<?php echo esc_attr($car_rental_hub_mileage); ?>" />
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
<?php
}

/* Saves the custom meta input */
function car_rental_hub_bn_metadesig_save($post_id)
{
    if (!isset($_POST['car_rental_hub_featured_car_meta_nonce']) || !wp_verify_nonce(strip_tags(wp_unslash($_POST['car_rental_hub_featured_car_meta_nonce'])), basename(__FILE__))) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Save Compare Price
    if (isset($_POST['car_rental_hub_compare_price'])) {
        update_post_meta($post_id, 'car_rental_hub_compare_price', strip_tags(wp_unslash($_POST['car_rental_hub_compare_price'])));
    }
    // Save Car Body-Type
    if (isset($_POST['car_rental_hub_body_type'])) {
        update_post_meta($post_id, 'car_rental_hub_body_type', strip_tags(wp_unslash($_POST['car_rental_hub_body_type'])));
    }
    // Save Car Model-Year
    if (isset($_POST['car_rental_hub_model_year'])) {
        update_post_meta($post_id, 'car_rental_hub_model_year', strip_tags(wp_unslash($_POST['car_rental_hub_model_year'])));
    }
    // Save Car Mileage
    if (isset($_POST['car_rental_hub_mileage'])) {
        update_post_meta($post_id, 'car_rental_hub_mileage', strip_tags(wp_unslash($_POST['car_rental_hub_mileage'])));
    }
}
add_action('save_post', 'car_rental_hub_bn_metadesig_save');
