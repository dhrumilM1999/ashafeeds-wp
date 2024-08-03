<?php
/**
 * Plugin Name: Hero Banner Ultimate
 * Plugin URI: https://www.essentialplugin.com/wordpress-plugin/hero-banner-ultimate/
 * Text Domain: hero-banner-ultimate
 * Description: Add hero banner with the help of background image OR background color OR background video. Also work with Gutenberg shortcode block. 
 * Domain Path: /languages/
 * Version: 1.4
 * Author: WP OnlineSupport, Essential Plugin
 * Author URI: https://www.essentialplugin.com/wordpress-plugin/hero-banner-ultimate/
 * Contributors: WP OnlineSupport
*/

if( ! defined( 'HBU_VERSION' ) ) {
	define( 'HBU_VERSION', '1.4' ); // Version of plugin
}
if( ! defined( 'HBU_NAME' ) ) {
	define( 'HBU_NAME', 'Hero Banner Ultimate' ); // Version of plugin
}
if( ! defined( 'HBU_DIR' ) ) {
	define( 'HBU_DIR', dirname( __FILE__ ) ); // Plugin dir
}
if( ! defined( 'HBU_URL' ) ) {
	define( 'HBU_URL', plugin_dir_url( __FILE__ )); // Plugin url
}
if( ! defined( 'HBU_PLUGIN_BASENAME' ) ) {
	define( 'HBU_PLUGIN_BASENAME', plugin_basename( __FILE__ ) ); // plugin base name
}
if( ! defined( 'HBU_POST_TYPE' ) ) {
	define('HBU_POST_TYPE', 'hbupro_banner'); // Plugin post type
}
if( ! defined( 'HBU_META_PREFIX' ) ) {
	define('HBU_META_PREFIX','_hbupro_'); // Plugin metabox prefix
}

if( ! defined( 'HBU_PLUGIN_LINK' ) ) {
	define( 'HBU_PLUGIN_LINK', 'https://www.essentialplugin.com/wordpress-plugin/hero-banner-ultimate/?utm_source=WP&utm_medium=Hero-Banner&utm_campaign=Features-PRO' ); // Plugin Link
}

if( ! defined( 'HBU_PLUGIN_LINK_UPGRADE' ) ) {
	define( 'HBU_PLUGIN_LINK_UPGRADE', 'https://www.essentialplugin.com/wordpress-plugin/hero-banner-ultimate/?utm_source=WP&utm_medium=Hero-Banner&utm_campaign=Features-PRO' ); // Plugin Link
}

if( ! defined( 'HBU_SITE_LINK' ) ) {
	define('HBU_SITE_LINK','https://www.essentialplugin.com'); // Plugin link
}

/**
 * Load Text Domain
 * This gets the plugin ready for translation
 * 
 * @package Hero Banner Ultimate
 * @since 1.0.0
 */
function hbu_load_textdomain() {

	global $wp_version;

	// Set filter for plugin's languages directory
	$hbu_lang_dir = dirname( plugin_basename( __FILE__ ) ) . '/languages/';
	$hbu_lang_dir = apply_filters( 'hbu_languages_directory', $hbu_lang_dir );

	// Traditional WordPress plugin locale filter.
	$get_locale = get_locale();

	if ( $wp_version >= 4.7 ) {
		$get_locale = get_user_locale();
	}

	// Traditional WordPress plugin locale filter
	$locale = apply_filters( 'plugin_locale',  $get_locale, 'hero-banner-ultimate' );
	$mofile = sprintf( '%1$s-%2$s.mo', 'hero-banner-ultimate', $locale );

	// Setup paths to current locale file
	$mofile_global  = WP_LANG_DIR . '/plugins/' . basename( HBU_DIR ) . '/' . $mofile;

	if ( file_exists( $mofile_global ) ) { // Look in global /wp-content/languages/plugin-name folder
		load_textdomain( 'hero-banner-ultimate', $mofile_global );
	} else { // Load the default language files
		load_plugin_textdomain( 'hero-banner-ultimate', false, $hbu_lang_dir );
	}
}
add_action('plugins_loaded', 'hbu_load_textdomain');

/**
 * Activation Hook
 * 
 * Register plugin activation hook.
 * 
 * @since 1.4
 */
register_activation_hook( __FILE__, 'hbu_install' );

/**
 * Deactivation Hook
 * 
 * Register plugin deactivation hook.
 * 
 * @since 1.4
 */
register_deactivation_hook( __FILE__, 'hbu_uninstall');

/**
 * Plugin Activation Function
 * Does the initial setup, sets the default values for the plugin options
 * 
 * @since 1.4
 */
function hbu_install() {

	// IMP need to flush rules for custom registered post type
	flush_rewrite_rules();

	// Deactivate free version
	if( is_plugin_active('hero-banner-ultimate-pro/hero-banner-ultimate-pro.php') ){
		add_action('update_option_active_plugins', 'hbu_deactivate_free_version');
	}
}

/**
 * Plugin Functinality (On Deactivation)
 * 
 * Delete  plugin options.
 * 
 * @since 1.4
 */
function hbu_uninstall() {
	// IMP need to flush rules for custom registered post type
	flush_rewrite_rules();
}

/**
 * Deactivate free plugin
 * 
 * @since 1.4
 */
function hbu_deactivate_free_version() {
	deactivate_plugins('hero-banner-ultimate-pro/hero-banner-ultimate-pro.php', true);
}

/**
 * Function to display admin notice of activated plugin.
 * 
 * @since 1.4
 */
function hbu_admin_notice() {

	global $pagenow;

	$dir                = WP_PLUGIN_DIR . '/hero-banner-ultimate-pro/hero-banner-ultimate-pro.php';
	$notice_link        = add_query_arg( array('message' => 'hbu-plugin-notice'), admin_url('plugins.php') );

	// If PRO plugin is active and free plugin exist
	if( $pagenow == 'plugins.php' ) {

		$notice_transient   = get_transient( 'hbu_install_notice' );

		if( $notice_transient == false && file_exists( $dir ) && current_user_can( 'install_plugins' ) ) {
			echo '<div class="updated notice" style="position:relative;">
						<p>
							<strong>'.sprintf( __('Thank you for activating %s', 'hero-banner-ultimate'), 'Hero Banner Ultimate').'</strong>.<br/>
							'.sprintf( __('It looks like you had PRO version %s of this plugin activated. To avoid conflicts the extra version has been deactivated and we recommend you delete it.', 'hero-banner-ultimate'), '<strong>(<em>Hero Banner Ultimate Pro</em>)</strong>' ).'
						</p>
						<a href="'.esc_url( $notice_link ).'" class="notice-dismiss" style="text-decoration:none;"></a>
					</div>';
		}
	}
}

// Action to display notice
add_action( 'admin_notices', 'hbu_admin_notice');

// Funcions File
require_once( HBU_DIR .'/includes/hbu-functions.php' );

// Post Type File
require_once( HBU_DIR . '/includes/hbu-post-types.php' );

// Script Class File
require_once( HBU_DIR . '/includes/class-hbu-script.php' );

// Admin Class File
require_once( HBU_DIR . '/includes/admin/class-hbu-admin.php' );

// Shortcode file
require_once( HBU_DIR . '/includes/shortcode/hbu-banner-shortcode.php' );
