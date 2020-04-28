<?php
global $theme_options;

if ( ! function_exists( 'inspiry_load_styles' ) ) {
	/**
	 * Load Required CSS Styles
	 */
	function inspiry_load_styles() {

		if ( ! is_admin() ) {

			global $data, $theme_options;
			$common_css_path = INSPIRY_COMMON_DIR_URI . '/css/';
			$common_js_path  = INSPIRY_COMMON_DIR_URI . '/js/';
			$css_path        = INSPIRY_ASSETS_DIR_URI . '/css/';
			$js_path         = INSPIRY_ASSETS_DIR_URI . '/js/';

			wp_register_style( 'animations-css', $common_css_path . 'animations.css', array(), '1.0', 'all' );
			wp_register_style( 'font-awesome-css', $common_css_path . 'fontawesome-all.min.css', array(), '5.0.8', 'all' );
			wp_register_style( 'datepicker-css', $common_css_path . 'datepicker.css', array(), '1.10.4', 'all' );
			wp_register_style( 'swipebox-css', $common_js_path . 'vendors/swipebox/swipebox.css', array(), '1.2.1', 'all' );
			wp_register_style( 'meanmenu-css', $common_js_path . 'vendors/meanmenu/meanmenu.css', array(), '2.0.6', 'all' );
			wp_register_style( 'select2-css', $common_js_path . 'vendors/select2/select2.min.css', array(), '4.0.3', 'all' );
			wp_register_style( 'flexslider-css', $common_js_path . 'vendors/flexslider/flexslider.css', array(), '2.3.0', 'all' );
			wp_register_style( 'owl-carousel-css', $js_path . 'vendors/owl-carousel/owl.carousel.min.css', array(), '2.2.1', 'all' );
			wp_register_style( 'owl-carousel-theme-css', $js_path . 'vendors/owl-carousel/owl.theme.default.min.css', array(), '2.2.1', 'all' );
			wp_register_style( 'bootstrap-css', $css_path . 'bootstrap.css', array(), '3.0', 'all' );
			wp_register_style( 'main-css', $css_path . 'main.css', array(), '1.0', 'all' );
			wp_register_style( 'theme-css', $css_path . 'theme.css', array('main-css'), '1.0', 'all' );
			wp_register_style( 'custom-responsive-css', $css_path . 'custom-responsive.css', array(), '1.0', 'all' );

			if ( is_rtl() ) {
				wp_register_style( 'bootstrap-rtl-css', $css_path . 'bootstrap-rtl.css', array(), '1.0', 'all' );
				wp_register_style( 'main-rtl-css', $css_path . 'main-rtl.css', array( 'main-css' ), '1.0', 'all' );
				wp_register_style( 'theme-rtl-css', $css_path . 'theme-rtl.css', array('main-rtl-css'), '1.0', 'all' );
				wp_register_style( 'custom-responsive-rtl-css', $css_path . 'custom-responsive-rtl.css', array(), '1.0', 'all' );
			}

			wp_register_style( 'parent-default', get_stylesheet_uri(), array(), '1.0', 'all' );
			wp_register_style( 'parent-custom', $common_css_path . 'custom.css', array(), '1.2', 'all' );

			// Google Fonts
			wp_enqueue_style( 'inspiry-google-fonts', inspiry_google_fonts(), array(), INSPIRY_THEME_VERSION );

			// enqueue Font Awesome styles
			wp_enqueue_style( 'font-awesome-css' );

			// enqueue Swipe Box styles
			if ( ! is_singular( 'product' ) ) {
				wp_enqueue_style( 'swipebox-css' );
			}

			// enqueue animations styles
			if ( isset( $theme_options['animation'] ) && $theme_options['animation'] ) {
				wp_enqueue_style( 'animations-css' );
			}

			// enqueue Mean Menu styles
			wp_enqueue_style( 'meanmenu-css' );

			// enqueue Flex Slider styles
			wp_enqueue_style( 'flexslider-css' );

			// enqueue Date Picker styles
			wp_enqueue_style( 'datepicker-css' );

			if( ! wp_style_is( 'select2-css') ){
				wp_enqueue_style( 'select2', $common_js_path . 'vendors/select2/select2.min.css', array(), '4.0.3', 'all' );
			}

			if ( 'default' == INSPIRY_DESIGN_VARIATION ) {
				wp_enqueue_style( 'bootstrap-css' );
				wp_enqueue_style( 'custom-responsive-css' );

				if ( is_rtl() ) {
					wp_enqueue_style( 'bootstrap-rtl-css' );
					wp_enqueue_style( 'custom-responsive-rtl-css' );
				}
			} elseif ( 'reborn' == INSPIRY_DESIGN_VARIATION ) {

				wp_enqueue_style( 'owl-carousel-css' );
				wp_enqueue_style( 'owl-carousel-theme-css' );
			}

			// enqueue Theme's Main styles
			wp_enqueue_style( 'main-css' );

			if ( is_rtl() ) {
				wp_enqueue_style( 'main-rtl-css' );
			}

			if ( 'reborn' == INSPIRY_DESIGN_VARIATION ) {
				wp_enqueue_style( 'theme-css' );
				if ( is_rtl() ) {
					wp_enqueue_style( 'theme-rtl-css' );
				}
			}

			// default css
			wp_enqueue_style( 'parent-default' );

			// parent theme custom css
			wp_enqueue_style( 'parent-custom' );
		}
	}

	add_action( 'wp_enqueue_scripts', 'inspiry_load_styles' );
}

if ( ! function_exists( 'inspiry_google_fonts' ) ) {
	/**
	 * Google fonts enqueue url
	 */
	function inspiry_google_fonts() {
		$fonts_url     = '';
		$font_families = array();

		if ( 'default' == INSPIRY_DESIGN_VARIATION ) {

			$raleway     = _x( 'on', 'Raleway font: on or off', 'framework' );
			$droid_serif = _x( 'on', 'Droid Serif font: on or off', 'framework' );

			if ( 'off' !== $raleway ) {
				$font_families[] = 'Raleway:400,100,200,300,500,600,700,800,900';
			}

			if ( 'off' !== $droid_serif ) {
				$font_families[] = 'Droid Serif:400,700,400italic,700italic';
			}

		} elseif ( 'reborn' == INSPIRY_DESIGN_VARIATION ) {

			$montserrat = _x( 'on', 'Montserrat font: on or off', 'framework' );

			if ( 'off' !== $montserrat ) {
				$font_families[] = 'Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i';
			}
		}

		if ( ! empty( $font_families ) ) {

			$query_args = array(
				'family' => urlencode( implode( '|', $font_families ) ),
				'subset' => urlencode( 'latin,latin-ext' ),
			);

			$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
		}

		return esc_url_raw( $fonts_url );
	}
}

if ( ! function_exists( 'inspiry_admin_js' ) ) {
	/**
	 * Register and load admin javascript
	 */
	function inspiry_admin_js( $hook ) {

		if ( $hook == 'toplevel_page__options' ) {
			wp_enqueue_style( 'inspiry-admin-css', INSPIRY_COMMON_DIR_URI . '/css/admin.css' );
		}
	}

	add_action( 'admin_enqueue_scripts', 'inspiry_admin_js', 10, 1 );
}

if ( isset( $theme_options['want_to_change_theme_styling'] ) && '1' == $theme_options['want_to_change_theme_styling'] ) {
	// Dynamic CSS
	require_once( INSPIRY_ASSETS_DIR . '/css/dynamic-css.php' );
}