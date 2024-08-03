<?php
/**
 * Admin Class
 *
 * Handles the Admin side functionality of plugin
 *
 * @package Hero Banner Ultimate
 * @since 1.0.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Hbu_Admin {

	function __construct() {

		// Action to register admin menu
		add_action( 'admin_menu', array( $this, 'hbu_register_menu' ), 9 );

		// Action to add metabox
		add_action( 'add_meta_boxes', array( $this, 'hbu_post_sett_metabox' ));

		// Action to save metabox
		add_action( 'save_post_'.HBU_POST_TYPE, array( $this, 'hbu_save_metabox_value' ));

		// Action to register plugin settings
		add_action ( 'admin_init', array( $this, 'hbu_register_settings' ));

		// Action to add custom column to Slider listing
		add_filter( 'manage_'.HBU_POST_TYPE.'_posts_columns', array( $this, 'hbu_manage_posts_columns' ));

		// Action to add custom column data to Slider listing
		add_action('manage_'.HBU_POST_TYPE.'_posts_custom_column', array( $this, 'hbu_post_columns_data' ), 10, 2);
	}

	/**
	 * Function to add menu
	 * 
	 * @since 1.0.0
	 */
	function hbu_register_menu() {

		// Register plugin premium page
		add_submenu_page( 'edit.php?post_type='.HBU_POST_TYPE, __('Upgrade to PRO - Hero Banner Ultimate', 'hero-banner-ultimate'), '<span style="color:#ff2700">'.__('Upgrade to PRO', 'hero-banner-ultimate').'</span>', 'manage_options', 'hbu-premium', array($this, 'hbu_premium_page') );
	}

	/**
	 * Getting Started Page Html
	 * 
	 * @since 1.0.0
	 */
	function hbu_premium_page() {
		include_once( HBU_DIR . '/includes/admin/premium.php' );
	}

	/**
	 * Post Settings Metabox
	 * 
	 * @since 1.0.0
	 */
	function hbu_post_sett_metabox() {
		add_meta_box( 'hbu-post-sett', __( 'Hero Banner - Settings', 'hero-banner-ultimate' ), array($this, 'hbu_post_sett_mb_content'), HBU_POST_TYPE, 'normal', 'high' );
	}

	/**
	 * Post Settings Metabox HTML
	 * 
	 * @since 1.0.0
	 */
	function hbu_post_sett_mb_content() {
		include_once( HBU_DIR .'/includes/admin/metabox/hbu-post-sett-metabox.php');
	}

	/**
	 * Function to save metabox values
	 * 
	 * @since 1.0.0
	 */
	function hbu_save_metabox_value( $post_id ) {

		global $post_type;

		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )					// Check Autosave
		|| ( ! isset( $_POST['post_ID'] ) || $post_id != $_POST['post_ID'] )	// Check Revision
		|| ( $post_type !=  HBU_POST_TYPE ) )									// Check if current post type is supported.
		{
			return $post_id;
		}

		$prefix = HBU_META_PREFIX; // Taking metabox prefix

		// Taking variables
		$banner_type				= isset( $_POST[$prefix.'banner_type'] )				? hbu_clean($_POST[$prefix.'banner_type'])						: '';
		$banner_layout				= isset( $_POST[$prefix.'banner_layout'] )				? hbu_clean($_POST[$prefix.'banner_layout'])					: '';
		$banner_bg_color			= isset( $_POST[$prefix.'banner_bg_color'] )			? hbu_clean_color($_POST[$prefix.'banner_bg_color'])			: '';
		$banner_image_url			= isset( $_POST[$prefix.'banner_image_url'] )			? hbu_clean_url($_POST[$prefix.'banner_image_url'])				: '';
		$banner_video_url			= isset( $_POST[$prefix.'banner_video_url'] )			? hbu_clean($_POST[$prefix.'banner_video_url'])					: '';
		$banner_vmvideo_url			= isset( $_POST[$prefix.'banner_vmvideo_url'] )			? hbu_clean($_POST[$prefix.'banner_vmvideo_url'])				: '';
		$banner_ovelay_color		= isset( $_POST[$prefix.'banner_ovelay_color'] )		? hbu_clean_color($_POST[$prefix.'banner_ovelay_color'])		: '';
		$banner_ovelay_opacity		= isset( $_POST[$prefix.'banner_ovelay_opacity'] )		? hbu_clean($_POST[$prefix.'banner_ovelay_opacity'])			: '';
		$banner_title_color			= isset( $_POST[$prefix.'banner_title_color'] )			? hbu_clean_color($_POST[$prefix.'banner_title_color'])			: '';
		$banner_content_color		= isset( $_POST[$prefix.'banner_content_color'] )		? hbu_clean_color($_POST[$prefix.'banner_content_color'])		: '';
		$banner_title_fontsize		= isset( $_POST[$prefix.'banner_title_fontsize'] )		? hbu_clean_number($_POST[$prefix.'banner_title_fontsize'])		: '';
		$banner_subtitle_fontsize	= isset( $_POST[$prefix.'banner_subtitle_fontsize'] )	? hbu_clean_number($_POST[$prefix.'banner_subtitle_fontsize'])	: '';
		$banner_button_one_name		= isset( $_POST[$prefix.'banner_button_one_name'] )		? hbu_clean($_POST[$prefix.'banner_button_one_name'])			: '';
		$banner_button_one_link		= isset( $_POST[$prefix.'banner_button_one_link'] )		? hbu_clean_url($_POST[$prefix.'banner_button_one_link'])		: '';
		$banner_button_two_name		= isset( $_POST[$prefix.'banner_button_two_name'] )		? hbu_clean($_POST[$prefix.'banner_button_two_name'])			: '';
		$banner_button_two_link		= isset( $_POST[$prefix.'banner_button_two_link'] )		? hbu_clean_url($_POST[$prefix.'banner_button_two_link'])		: '';
		$banner_bg_size				= isset( $_POST[$prefix.'banner_bg_size'] )				? hbu_clean($_POST[$prefix.'banner_bg_size'])					: '';
		$banner_bg_attachemnt		= isset( $_POST[$prefix.'banner_bg_attachemnt'] )		? hbu_clean($_POST[$prefix.'banner_bg_attachemnt'])				: '';
		$banner_bg_position			= isset( $_POST[$prefix.'banner_bg_position'] )			? hbu_clean($_POST[$prefix.'banner_bg_position'])				: '';
		$banner_padding_top			= isset( $_POST[$prefix.'banner_padding_top'] )			? hbu_clean($_POST[$prefix.'banner_padding_top'])				: '';
		$banner_padding_right		= isset( $_POST[$prefix.'banner_padding_right'] )		? hbu_clean($_POST[$prefix.'banner_padding_right'])				: '';
		$banner_padding_bottom		= isset( $_POST[$prefix.'banner_padding_bottom'] )		? hbu_clean($_POST[$prefix.'banner_padding_bottom'])			: '';
		$banner_padding_left		= isset( $_POST[$prefix.'banner_padding_left'] )		? hbu_clean($_POST[$prefix.'banner_padding_left'])				: '';
		$banner_wrap_width			= isset( $_POST[$prefix.'banner_wrap_width'] )			? hbu_clean_number($_POST[$prefix.'banner_wrap_width'])			: '';
		$banner_button_one_class	= isset( $_POST[$prefix.'banner_button_one_class'] )	? hbu_clean($_POST[$prefix.'banner_button_one_class'])			: '';
		$banner_button_two_class	= isset( $_POST[$prefix.'banner_button_two_class'] )	? hbu_clean($_POST[$prefix.'banner_button_two_class'])			: '';

		update_post_meta( $post_id, $prefix.'banner_type', $banner_type );
		update_post_meta( $post_id, $prefix.'banner_bg_color', $banner_bg_color );
		update_post_meta( $post_id, $prefix.'banner_layout', $banner_layout );
		update_post_meta( $post_id, $prefix.'banner_video_url', $banner_video_url );
		update_post_meta( $post_id, $prefix.'banner_vmvideo_url', $banner_vmvideo_url );
		update_post_meta( $post_id, $prefix.'banner_image_url', $banner_image_url );
		update_post_meta( $post_id, $prefix.'banner_ovelay_color', $banner_ovelay_color );
		update_post_meta( $post_id, $prefix.'banner_ovelay_opacity', $banner_ovelay_opacity );
		update_post_meta( $post_id, $prefix.'banner_title_color', $banner_title_color );
		update_post_meta( $post_id, $prefix.'banner_content_color', $banner_content_color );
		update_post_meta( $post_id, $prefix.'banner_title_fontsize', $banner_title_fontsize );
		update_post_meta( $post_id, $prefix.'banner_subtitle_fontsize', $banner_subtitle_fontsize );
		update_post_meta( $post_id, $prefix.'banner_button_one_name', $banner_button_one_name );
		update_post_meta( $post_id, $prefix.'banner_button_one_link', $banner_button_one_link );
		update_post_meta( $post_id, $prefix.'banner_button_two_name', $banner_button_two_name );
		update_post_meta( $post_id, $prefix.'banner_button_two_link', $banner_button_two_link );
		update_post_meta( $post_id, $prefix.'banner_bg_size', $banner_bg_size );
		update_post_meta( $post_id, $prefix.'banner_bg_attachemnt', $banner_bg_attachemnt );
		update_post_meta( $post_id, $prefix.'banner_bg_position', $banner_bg_position );
		update_post_meta( $post_id, $prefix.'banner_padding_top', $banner_padding_top );
		update_post_meta( $post_id, $prefix.'banner_padding_right', $banner_padding_right );
		update_post_meta( $post_id, $prefix.'banner_padding_bottom', $banner_padding_bottom );
		update_post_meta( $post_id, $prefix.'banner_padding_left', $banner_padding_left );
		update_post_meta( $post_id, $prefix.'banner_wrap_width', $banner_wrap_width );
		update_post_meta( $post_id, $prefix.'banner_button_one_class', $banner_button_one_class );
		update_post_meta( $post_id, $prefix.'banner_button_two_class', $banner_button_two_class );
	}

	/**
	 * Function register setings
	 * 
	 * @since 1.4
	 */
	function hbu_register_settings() {

		// If plugin notice is dismissed
		if( isset( $_GET['message'] ) && 'hbu-plugin-notice' == $_GET['message'] ) {
			set_transient( 'hbu_install_notice', true, 604800 );
		}
	}

	/**
	 * Add custom column to Post listing page
	 * 
	 * @since 1.0.0
	 */
	function hbu_manage_posts_columns( $columns ) {

		$new_columns['hbu_shortcode']	= esc_html__( 'Shortcode', 'hero-banner-ultimate' );

		$columns = hbu_add_array( $columns, $new_columns, 1, true );

		return $columns;
	}

	/**
	 * Add custom column data to Post listing page
	 * 
	 * @since 1.0.0
	 */
	function hbu_post_columns_data( $column, $post_id ) {

		switch ($column) {
			case 'hbu_shortcode':
				echo '<div class="wpos-copy-clipboard hbu-shortcode-preview">[hbupro_banner id="'.$post_id.'"]</div>';
				break;
		}
	}
}

$hbu_admin = new Hbu_Admin();