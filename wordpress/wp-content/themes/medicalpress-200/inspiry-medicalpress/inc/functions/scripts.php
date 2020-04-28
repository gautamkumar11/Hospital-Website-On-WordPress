<?php
/**
 * Load Required JS Scripts
 */
if ( ! function_exists( 'inspiry_load_scripts' ) ) {

	function inspiry_load_scripts() {

		if ( ! is_admin() ) {

			global $theme_options;
			$common_js_path = INSPIRY_COMMON_DIR_URI . '/js/vendors/';
			$js_path        = INSPIRY_ASSETS_DIR_URI . '/js/vendors/';

			wp_register_script( 'isotope', $common_js_path . 'jquery.isotope.pkgd.min.js', array( 'jquery' ), '3.0.4', true );
			wp_register_script( 'validate', $common_js_path . 'jquery.validate.min.js', array( 'jquery' ), '1.11.1', true );
			wp_register_script( 'jquery-form', $common_js_path . 'jquery.form.js', array( 'jquery' ), '3.43.0', true );
			wp_register_script( 'swipebox', $common_js_path . 'swipebox/jquery.swipebox.min.js', array( 'jquery' ), '1.2.1', true );
			wp_register_script( 'meanmenu', $common_js_path . 'meanmenu/jquery.meanmenu.min.js', array( 'jquery' ), '2.0.6', true );
			wp_register_script( 'select2-js', $common_js_path . 'select2/select2.min.js', array( 'jquery' ), '4.0.3', true );
			wp_register_script( 'velocity', $common_js_path . 'jquery.velocity.min.js', array( 'jquery' ), '0.0.0', true );
			wp_register_script( 'appear', $common_js_path . 'jquery.appear.js', array( 'jquery' ), '0.3.3', true );
			wp_register_script( 'flexslider', $common_js_path . 'flexslider/jquery.flexslider-min.js', array( 'jquery' ), '2.3.0', true );
			wp_register_script( 'jplayer', $common_js_path . 'jquery.jplayer.min.js', array( 'jquery' ), '2.6.0', true );
			wp_register_script( 'owl-carousel', $js_path . 'owl-carousel/owl.carousel.min.js', array( 'jquery' ), '2.2.1', true );
			wp_register_script( 'bootstrap', $js_path . 'bootstrap.min.js', array( 'jquery' ), '3.1.0', true );
			wp_register_script( 'autosize', $js_path . 'jquery.autosize.min.js', array( 'jquery' ), '1.18.7', true );
			wp_register_script( 'custom-common-script', INSPIRY_COMMON_DIR_URI . '/js/custom-common.js', array( 'jquery', 'meanmenu' ), '1.0', true );
			wp_register_script( 'custom-script', INSPIRY_ASSETS_DIR_URI . '/js/custom.js', array( 'jquery', 'meanmenu' ), '1.0', true );

			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jquery-ui-core' );
			wp_enqueue_script( 'isotope' );
			wp_enqueue_script( 'select2-js' );
			wp_enqueue_script( 'meanmenu' );
			wp_enqueue_script( 'validate' );
			wp_enqueue_script( 'jquery-form' );
			wp_enqueue_script( 'velocity' );
			wp_enqueue_script( 'jquery-ui-datepicker' );
			wp_enqueue_script( 'flexslider' );
			wp_enqueue_script( 'jplayer' );
			wp_enqueue_script( 'bootstrap' );
			wp_enqueue_script( 'appear' );

			if ( 'default' == INSPIRY_DESIGN_VARIATION ) {

				wp_enqueue_script( 'autosize' );

			} elseif ( 'reborn' == INSPIRY_DESIGN_VARIATION ) {

				wp_enqueue_script( 'owl-carousel' );

			}

			// swipebox - control flag
			if ( $theme_options['swipebox'] == '1' && ( ! is_singular( 'product' ) ) ) {
				wp_enqueue_script( 'swipebox' );
			}

			if ( is_page_template( 'templates/contact.php' ) ) {

				$google_map_arguments = array();

				// Get Google Map API Key if available
				if ( isset( $theme_options['google_map_api_key'], $theme_options['display_google_map'] ) && ! empty( $theme_options['google_map_api_key'] ) && ! empty( $theme_options['display_google_map'] ) ) {
					$google_map_arguments['key'] = urlencode( $theme_options['google_map_api_key'] );
					$google_map_api_uri          = add_query_arg( apply_filters( 'inspiry_google_map_arguments', $google_map_arguments ), '//maps.google.com/maps/api/js' );
					wp_enqueue_script( 'google-map-api', esc_url_raw( $google_map_api_uri ), array(), '3.21', false );
				}
			}

			if ( is_single() || is_page() ) {
				wp_enqueue_script( 'comment-reply' );
			}

			wp_enqueue_script( 'custom-common-script' );
			wp_enqueue_script( 'custom-script' );
		}
	}

	add_action( 'wp_enqueue_scripts', 'inspiry_load_scripts' );
}