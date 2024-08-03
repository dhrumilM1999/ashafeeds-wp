<?php

/**
 * Floating Widget class for Easy Video Reviews
 *
 * @since 1.3.0
 * @package EasyVideoReviews
 */

// Namespace.
namespace EasyVideoReviews;

// Exit if accessed directly.
defined('ABSPATH') || exit(1);


if ( ! class_exists( __NAMESPACE__ . '\Floatingwidget' ) ) {
    /**
	 * Floatingwidget class for Easy Video Reviews
	 */
	class Floatingwidget extends \EasyVideoReviews\Base\Controller {

        // Use the utilities trait.
		use \EasyVideoReviews\Traits\Utilities;

        /**
		 * Contains the value of only video state
		 *
		 * @var boolean
		 */
		private $only_video = false;

        /**
		 * Contains the value of only text state
		 *
		 * @var boolean
		 */
		private $only_text = false;

        /**
		 * Contains the value of only text review optional state
		 *
		 * @var boolean
		 */
		private $text_review_optional = false;

        /**
		 * Contains the value of choose option state
		 *
		 * @var boolean
		 */
		private $choose_option = false;

        /**
		 * Register hooks
		 *
		 * @return void
		 */
		public function register_hooks() {
			// Register action hooks.
			add_action('wp_footer', [ $this, 'render_floating_widget' ]);
		}

        /**
		 * Renders the floating widget template
		 *
		 * @return void
		 */
		public function render_floating_widget() {
			$this->render_template('frontend/floating-widget');
		}

        /**
         * Set state of taking review
         *
         * @return void
         */
        public function set_review_state( $review_settings ) {
            $only_video_review = [
                'enable_video_review' => '1',
                'enable_text_review' => '0',
                'text_review_optional' => '0',
                'allow_choose_review' => '0',
            ];

            $only_text_review = [
                'enable_video_review' => '0',
                'enable_text_review' => '1',
                'text_review_optional' => '0',
                'allow_choose_review' => '0',
            ];

            $video_text_optional_review = [
                'enable_video_review' => '1',
                'enable_text_review' => '1',
                'text_review_optional' => '1',
                'allow_choose_review' => '0',
            ];

            $choose_bitween_video_text_review = [
                'enable_video_review' => '1',
                'enable_text_review' => '1',
                'text_review_optional' => '0',
                'allow_choose_review' => '1',
            ];

            if ( $only_video_review === $review_settings ) {

                $this->only_video = true;

            } elseif ( $only_text_review === $review_settings ) {

                $this->only_text = true;

            } elseif ( $video_text_optional_review === $review_settings ) {

                $this->text_review_optional = true;

            } elseif ( $choose_bitween_video_text_review === $review_settings ) {

                $this->choose_option = true;

            }
		}
    }

    // Instantiate the class.
	Floatingwidget::init();
}
