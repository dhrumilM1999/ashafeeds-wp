<?php

/**
 * Handles translations for Easy Video Reviews
 *
 * @since 1.0.0
 * @package EasyVideoReviews
 */

// Namespace.
namespace EasyVideoReviews;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit( 1 );

if ( ! class_exists( __NAMESPACE__ . '\Translation' ) ) {

	/**
	 * Handles translations for Easy Video Reviews
	 *
	 * @since 1.0.0
	 * @package EasyVideoReviews
	 */
	class Translation {

		// Use Utilities trait.
		use \EasyVideoReviews\Traits\Utilities;

		/**
		 * Returns the default translations
		 *
		 * @return array
		 */
		public function defaults() {
			// phpcs:disable Universal.Arrays.MixedKeyedUnkeyedArray.Found

			$texts = [
				'Start',
				'Uploading video...',
				'Upload Video',
				'Drag and drop your video here',
				'Or',
				'Click here',
				'to select and upload the video',
				'Record video',
				'Uploaded Successfully!',
				'Video Duration Limit Exceeded, Select other file',
				'Please select a file less than %s',
				'Error attempting to enable full-screen mode: %s',
				'Start Recording',
				'Record Again',
				'Submit Review',
				'Reupload Video',
				'Finish',
				'Done',
				'Fill in the data',
				'Changed your mind?',
				'Record a Video Review',
				'Record a Video Instead',
				'Upload Video Instead',
				'Not ready to record?',
				'Changed mind?',
				'Cancel',
				'Close Window',
				'Yes, Proceed',
				'Stop Recording',
				'Hello there! 👋',
				'Please leave your feedback',
				'You will be able to check your review before sending',
				'Camera and microphone access is blocked!',
				'You can record up to',
				'You can review your video before submitting',
				'Please give',
				'microphone and camera access',
				'to record video',
				'This site isn’t using https protocol.',
				'Reviews cannot be recorded or uploaded',
				'Thanks for your review! 😍',
				'Your Review has been successfully',
				'submitted',
				'Your uploaded',
				'Your recorded',
				'video will be lost',
				'Do you want to close?',
				'How would you like to review?',
				'Record Video',
				'Write Review',
				'Type your review below',
            	'Start typing your review here...',
				'Type your name',
				'floating-widget-text' => [ // phpcs:ignore Universal.Arrays.MixedArrayKeyTypes.StringKey
					'Hello there! 👋',
					'How would you like to review?',
					'Record Video',
					'Write Review',
					'You will be able to check your review before sending',
				],
			];

			// phpcs:enable

			$translations = [];

			foreach ( $texts as $key => $text ) {
				if ( 'floating-widget-text' === $key ) {
					$translations[ $key ] = $text;
				} else {
					$translations[ $text ] = $text;
				}
			}

			return apply_filters( 'evr_translations', $translations );
		}

		/**
		 * Returns the translations
		 *
		 * @return array
		 */
		public function get_all() {
			$keys = array_keys( $this->defaults() );

			$translations = get_option('evr_translations', []);

			$translations = (array) $translations;

			// remove old translate text from database.
			if ( count($translations) > 1 ) {
				foreach ( $translations as $fkey => $key ) {
					if ( 'floating-widget-text' === $fkey ) {
						if ( ! array_key_exists($fkey, $keys) ) {
							unset($translations[ $fkey ]);
						}
					} else {
						if ( ! array_key_exists($key, $keys) ) {
							unset($translations[ $key ]);
						}
					}
				}
			}

			foreach ( $keys as $key ) {
				if ( ! isset( $translations[ $key ] ) ) {
					if ( 'floating-widget-text' === $key ) {
						$translations[ $key ] = $this->defaults()[ $key ];
					} else {
						$translations[ $key ] = $key;
					}
				} else {
					if ( 'floating-widget-text' === $key ) {
						$translations[ $key ] = stripslashes( $key );
					} else {
						$translations[ $key ] = stripslashes( $translations[ $key ] );
					}
				}
			}

			return $translations;
		}
	}
}
