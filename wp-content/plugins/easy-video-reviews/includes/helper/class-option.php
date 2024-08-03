<?php

/**
 * Manages options for Easy Video Reviews
 *
 * @since 1.3.8
 * @package EasyVideoReviews
 */

// Namespace.
namespace EasyVideoReviews\Helper;

// Exit if accessed directly.
defined('ABSPATH') || exit(1);

if ( ! class_exists(__NAMESPACE__ . '\Option') ) {

	/**
	 * Manages options for Easy Video Reviews
	 */
	class Option {

		/**
		 * Singleton instance
		 *
		 * @var self
		 */
		private static $instance;

		/**
		 * Returns the singleton instance
		 *
		 * @return self
		 */
		public static function get_instance() {
			if ( ! self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}
		/**
		 * Prefix for all options
		 *
		 * @var string
		 */
		public $prefix = 'evr_';

		/**
		 * Get default options
		 *
		 * @return array
		 */
		public function get_defaults() {
			// Option Key pairs.
			$options = [
				'recorder' => [
					'max_video_length'    => 120,
					'max_video_size'      => 1000,
					'allow_upload'        => 0,
					'show_publish_policy' => 0,
					'show_options'        => 0,
					'show_form'           => 0,
					'enable_delay'        => true,
					'delay'               => 3,
					'auto_publish'        => false,
					'publishing_polisy_text' => '',
				],
				'default_button'    => [
					'text'       => esc_html__('Leave a video review', 'easy-video-reviews'),
					'color'      => '#f0f0f0',
					'background' => '#000099',
					'size'       => '18',
					'alignment'  => 'center',
					'custom_css' => '',
				],
				'email_template'    => [
					'message' => esc_html__('If you like the product, please leave a video review for us {button}', 'easy-video-reviews'),
					'button'  => [
						'text'       => esc_html__('Leave a video review', 'easy-video-reviews'),
						'color'      => '#f0f0f0',
						'background' => '#000099',
						'size'       => '18',
						'alignment'  => 'center',
						'custom_css' => '',
					],
					'url'     => [
						'label' => esc_html__('Leave a video review', 'easy-video-reviews'),
					],
				],
				'review_option'       => [
					'enable_video_review' => '1',
					'enable_text_review' => '1',
					'text_review_optional' => '1',
					'allow_choose_review' => '0',
				],
				'enable_woocommerce_review' => '0',
				'woocommerce_gallery_settings' => [],
				'woocommerce_button' => [
					'text'       => esc_html__('Leave a video review', 'easy-video-reviews'),
					'color'      => '#8B54FF',
					'background' => '#FFFFFF',
					'size'       => '16',
					'alignment'  => 'center',
					'border_radius' => '500px',
					'border_color' => '#8B54FF',
				],
				'recording_page_id' => 0,
				'review_page_id'    => 0,
				'review_menu_guide_tooltip' => '1',
				'gallaries'         => [],
				'forms'             => [],
				'translations'      => [],
				'enable_floating_widget_review' => '0',
				'floating_widgets_settings' => [
					'floting_widget_icons' => [],
					'selected_floating_icon_data' => [
						'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="18" viewBox="0 0 25 18" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M22.2796 2.53444C22.686 2.46759 23.1029 2.52336 23.4783 2.69483C23.8451 2.84241 24.1599 3.09794 24.3823 3.42853C24.6048 3.75912 24.7246 4.14965 24.7264 4.54988V12.9979C24.7256 13.3967 24.6076 13.7861 24.3875 14.1166C24.1674 14.447 23.8551 14.7034 23.4907 14.8529C23.2228 14.9761 22.9322 15.0402 22.638 15.0409C22.108 15.0385 21.5976 14.8377 21.2046 14.4769L18.5355 11.9701V13.7875C18.5355 14.7848 18.1449 15.7412 17.4497 16.4464C16.7545 17.1516 15.8116 17.5477 14.8284 17.5477H3.7071C2.72392 17.5477 1.781 17.1516 1.08579 16.4464C0.390569 15.7412 0 14.7848 0 13.7875V3.76023C0 2.76296 0.390569 1.80653 1.08579 1.10135C1.781 0.396166 2.72392 0 3.7071 0H14.8284C15.8116 0 16.7545 0.396166 17.4497 1.10135C18.1449 1.80653 18.5355 2.76296 18.5355 3.76023V5.57768L21.1923 3.07086C21.495 2.78783 21.8731 2.6013 22.2796 2.53444ZM4.97382 10.3316L3.97453 9.6992L2.97523 10.3291C2.79223 10.445 2.56829 10.2737 2.61645 10.057L2.88132 8.86775L1.99761 8.06653C1.83628 7.9204 1.92296 7.64325 2.13486 7.62561L3.2979 7.52231L3.753 6.40111C3.83487 6.19703 4.11419 6.19703 4.19606 6.40111L4.65116 7.52483L5.8142 7.62813C6.02609 7.64577 6.11278 7.92292 5.95145 8.06905L5.06773 8.87027L5.33261 10.0595C5.38077 10.2762 5.15683 10.4475 4.97382 10.3316ZM10.2374 10.3318L9.23809 9.69943L8.2388 10.3293C8.05579 10.4452 7.83186 10.2739 7.88001 10.0572L8.14489 8.86798L7.26117 8.06676C7.09984 7.92063 7.18653 7.64348 7.39843 7.62584L8.56146 7.52254L9.01656 6.40134C9.09843 6.19725 9.37775 6.19725 9.45962 6.40134L9.91473 7.52506L11.0778 7.62836C11.2897 7.646 11.3763 7.92315 11.215 8.06928L10.3313 8.8705L10.5962 10.0597C10.6443 10.2764 10.4204 10.4477 10.2374 10.3318ZM14.6894 9.6992L15.6887 10.3316C15.8717 10.4475 16.0956 10.2762 16.0475 10.0595L15.7826 8.87027L16.6663 8.06905C16.8276 7.92292 16.7409 7.64577 16.529 7.62813L15.366 7.52483L14.9109 6.40111C14.829 6.19703 14.5497 6.19703 14.4678 6.40111L14.0127 7.52231L12.8497 7.62561C12.6378 7.64325 12.5511 7.9204 12.7125 8.06653L13.5962 8.86775L13.3313 10.057C13.2831 10.2737 13.5071 10.445 13.6901 10.3291L14.6894 9.6992Z" fill="#77879D"/></svg>',
						'type' => 'svg',
						'name' => 'default-float-icon-1',
					],
					'selected_device' => 'computer',
					'cta_text' => 'Leave your feedback',
					'cta_behavaiour' => 'show-on-hover',
					'cta_text_color' => '#3c434a',
					'cta_text_mobile_color' => '#3c434a',
					'cta_backround_color' => '#ffffff',
					'cta_backround_mobile_color' => '#ffffff',
					'widget_show_on' => [ 'desktop', 'mobile' ],
					'widget_icon_background_type' => 'static',
					'widget_icon' => '',
					'icon_color' => '#ffffff',
					'icon_mobile_color' => '#ffffff',
					'icon_background_color' => '#5654f8',
					'icon_background_mobile_color' => '#5654f8',
					'icon_background_video_url' => '',
					'widget_position' => 'right',
					'widget_mobile_position' => 'right',
					'widget_animation_effect' => 'evr-switch-effect-wobble',
					'exclude_widgets_pages' => [],
				],
			];

			return apply_filters('evr_options', $options);
		}

		/**
		 * Get all options
		 *
		 * @return array
		 */
		public function get_all() {
			$defaults = $this->get_defaults();
			$options = [];
			foreach ( $defaults as $key => $value ) {
				$options[ $key ] = $this->get($key, $value);
			}

			return $options;
		}

		/**
		 * Get option
		 *
		 * @param string $key Option key.
		 * @param mixed  $default Default value.
		 *
		 * @return mixed
		 */
		public function get( $key, $default = null ) {
			$option = get_option($this->prefix . $key, $default);

			return maybe_unserialize( $option );
		}

		/**
		 * Update option
		 *
		 * @param string $key Option key.
		 * @param mixed  $value Option value. Default is null.
		 *
		 * @return bool
		 */
		public function update( $key, $value = null ) {

			if ( is_null($value) ) {
				$defaults = $this->get_defaults();
				$value    = $defaults[ $key ];
			}

			$option = update_option($this->prefix . $key, $value);

			return $option;
		}

		/**
		 * Delete option
		 *
		 * @param string $key Option key.
		 *
		 * @return bool
		 */
		public function delete( $key ) {
			$option = delete_option($this->prefix . $key);

			return $option;
		}

		/**
		 * Reset options
		 *
		 * @return bool
		 */
		public function reset() {
			$defaults = $this->get_defaults();

			foreach ( $defaults as $key => $value ) {
				$this->update($key, $value);
			}

			return true;
		}

		/**
		 * Get transient
		 *
		 * @param string $key Transient key.
		 * @param mixed  $default Default value.
		 * @return mixed
		 */
		public function get_transient( $key, $default = null ) {
			$transient = get_transient($this->prefix . $key);

			if ( false === $transient ) {
				$transient = $default;
			}

			return $transient;
		}

		/**
		 * Set transient
		 *
		 * @param string $key Transient key.
		 * @param mixed  $value Transient value.
		 * @param int    $expiration Expiration time in seconds. Default is 0.
		 * @return bool
		 */
		public function set_transient( $key, $value, $expiration = 0 ) {
			$transient = set_transient($this->prefix . $key, $value, $expiration);

			return $transient;
		}

		/**
		 * Delete transient
		 *
		 * @param string $key Transient key.
		 * @return bool
		 */
		public function delete_transient( $key ) {
			$transient = delete_transient($this->prefix . $key);

			return $transient;
		}

		/**
		 * Get first array key
		 *
		 * @param array $array
		 * @return string
		 */
		public function array_first_key( array $array ) {
			foreach ( $array as $key => $value ) {
				return $key;
			}
		}
	}
}
