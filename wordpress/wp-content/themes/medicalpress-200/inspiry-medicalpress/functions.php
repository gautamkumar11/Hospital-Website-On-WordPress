<?php
// Theme version.
define( 'INSPIRY_THEME_VERSION', '2.0.0' );

// Theme include.
define( 'INSPIRY_INC', '/inc' );

// Theme include directory.
define( 'INSPIRY_INC_DIR', get_template_directory() . INSPIRY_INC );

// Theme include directory.
define( 'INSPIRY_INC_DIR_URI', get_template_directory_uri() . INSPIRY_INC );

// Theme common.
define( 'INSPIRY_COMMON', '/common' );

// Theme common directory.
define( 'INSPIRY_COMMON_DIR', get_template_directory() . INSPIRY_COMMON );

// Theme common directory URI.
define( 'INSPIRY_COMMON_DIR_URI', get_template_directory_uri() . INSPIRY_COMMON );

// Theme Options Framework
if ( class_exists( 'ReduxFramework' ) ) {
	require_once( INSPIRY_INC_DIR . '/theme-options/medical-config.php' );
}

// One Click Demo Import
require_once get_template_directory() . '/inc/demo-import/demo-import.php';

if ( ! function_exists( 'inspiry_current_design_variation' ) ) {
	/**
	 * Returns the current design variation the user has selected.
	 *
	 * @since 1.6.0
	 */
	function inspiry_current_design_variation() {
		global $theme_options;
		$available_design_variations = array( 'default', 'reborn' );
		if ( isset( $theme_options['inspiry_design_variation'] ) && in_array( $theme_options['inspiry_design_variation'], $available_design_variations ) ) {
			return $theme_options['inspiry_design_variation'];
		}

		return 'default';
	}
}

// Theme variation.
define( 'INSPIRY_DESIGN_VARIATION', inspiry_current_design_variation() );

// Theme assets.
define( 'INSPIRY_ASSETS', '/assets/' . INSPIRY_DESIGN_VARIATION );

// Theme assets directory.
define( 'INSPIRY_ASSETS_DIR', get_template_directory() . INSPIRY_ASSETS );

// Theme assets directory URI.
define( 'INSPIRY_ASSETS_DIR_URI', get_template_directory_uri() . INSPIRY_ASSETS );

// Theme partials.
define( 'INSPIRY_PARTIALS', INSPIRY_ASSETS . '/partials' );

if ( ! function_exists( 'inspiry_theme_setup' ) ) {
	/**
	 * Basic Theme Setup
	 */
	function inspiry_theme_setup() {

		/* Load Text Domain */
		load_theme_textdomain( 'framework', get_template_directory() . '/languages' );

		/* Add Automatic Feed Links Support */
		add_theme_support( 'automatic-feed-links' );

		/* Add Title Support - let WordPress manage the document title */
		add_theme_support( 'title-tag' );

		/* Add Post Formats Support */
		add_theme_support( 'post-formats', array( 'gallery', 'link', 'image', 'quote', 'video', 'audio' ) );

		/* Add Menu Support */
		add_theme_support( 'menus' );
		register_nav_menus( array( 'main-menu' => __( 'Main Menu', 'framework' ) ) );

		/* Add Post Thumbnails Support and Related Image Sizes */
		add_theme_support( 'post-thumbnails' );

		if ( 'default' == INSPIRY_DESIGN_VARIATION ) {

			add_image_size( 'blog-page', 732, 9999, false );                  // For Blog Page
			add_image_size( 'default-page', 1140, 9999, false );              // Default Page and Full Width Page
			add_image_size( 'blog-post-thumb', 732, 447, true );              // For Home Blog Section and Gallery Slider on Single and Blog Page
			add_image_size( 'testimonial-thumb', 130, 130, true );            // For Testimonial Post
			add_image_size( 'services-one-col-thumb', 570, 250, true );       // For one column services page
			add_image_size( 'service-gallery-thumb', 848, 518, true );        // For service single page and two columns, three columns, four columns services pages.
			add_image_size( 'gallery-post-single', 670, 500, true );          // For Gallery Single Post Slider and Various Other Parts of theme like doctors pages
			add_image_size( 'gallery-post-single-thumb', 111, 69, true );     // For Gallery Single Post Thumbnail

		} elseif ( 'reborn' == INSPIRY_DESIGN_VARIATION ) {

			set_post_thumbnail_size( 750, 500, true );

			add_image_size( 'common-grid-thumb', 585, 386, true );
			add_image_size( 'doctor-grid-thumb', 585, 618, true );

			register_nav_menus( array( 'footer-menu' => __( 'Footer Menu', 'framework' ) ) );
		}
	}

	add_action( 'after_setup_theme', 'inspiry_theme_setup' );
}

// Content Width
if ( ! isset( $content_width ) ) {
	$content_width = 1170;
}

// TGM Plugin Activation Class and related code to get the plugins installed and activated
require_once( INSPIRY_INC_DIR . '/tgm/class-tgm-plugin-activation.php' );
require_once( INSPIRY_INC_DIR . '/tgm/plugins-list.php' );

// Custom Post Types
require_once( INSPIRY_INC_DIR . '/post-types/doctor-post-type.php' );
require_once( INSPIRY_INC_DIR . '/post-types/testimonial-post-type.php' );
require_once( INSPIRY_INC_DIR . '/post-types/faq-post-type.php' );
require_once( INSPIRY_INC_DIR . '/post-types/service-post-type.php' );
require_once( INSPIRY_INC_DIR . '/post-types/gallery-post-type.php' );

// Meta Box
require_once( INSPIRY_INC_DIR . '/meta-box/config-meta-boxes.php' );

// Shortcodes
require_once( INSPIRY_INC_DIR . '/shortcodes/elements.php' );
require_once( INSPIRY_INC_DIR . '/shortcodes/vc-map.php' );

// Widgets
require_once( INSPIRY_INC_DIR . '/widgets/tabs-widget.php' );

if ( 'reborn' == INSPIRY_DESIGN_VARIATION ) {
	require_once( INSPIRY_INC_DIR . '/widgets/blog-posts-widget.php' );
}

// Include theme functions
require_once( INSPIRY_INC_DIR . '/functions/styles.php' );
require_once( INSPIRY_INC_DIR . '/functions/scripts.php' );
require_once( INSPIRY_INC_DIR . '/functions/sidebar.php' );
require_once( INSPIRY_INC_DIR . '/functions/header.php' );
require_once( INSPIRY_INC_DIR . '/functions/footer.php' );
require_once( INSPIRY_INC_DIR . '/functions/basic.php' );
require_once( INSPIRY_INC_DIR . '/functions/sort.php' );
require_once( INSPIRY_INC_DIR . '/functions/recaptcha.php' );
require_once( INSPIRY_INC_DIR . '/functions/contact_form_handler.php' );
require_once( INSPIRY_INC_DIR . '/functions/theme_comment.php' );

// WooCommerce related function
if ( class_exists( 'woocommerce' ) ) {
	require_once( INSPIRY_INC_DIR . '/functions/woocommerce.php' );
}

// Check woocommerce pages
if ( ! function_exists( 'inspiry_is_woocommerce_page' ) ) {
	function inspiry_is_woocommerce_page() {

		if ( function_exists( 'is_shop' ) && function_exists( 'is_product' ) ) {

			if ( is_shop() || is_product() ) {

				return true;
			}
		}

		return false;
	}
}