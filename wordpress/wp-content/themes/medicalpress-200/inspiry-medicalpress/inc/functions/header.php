<?php
if ( ! function_exists( 'inspiry_update_page_templates' ) ) {

	function inspiry_update_page_templates() {

		global $post;

		$page_template = '';

		if ( ! empty( $post ) && isset( $post->ID ) ) {
			$page_template = get_post_meta( $post->ID, '_wp_page_template', true );
		} else {
			return;
		}

		$postfix = '-template';

		if ( ! empty( $page_template ) && false !== strpos( $page_template, $postfix ) ) {

			$page_template = str_replace( $postfix, '', $page_template );

			if ( false === strpos( $page_template, 'templates/' ) ) {

				$new_template = 'templates/' . $page_template;

				update_post_meta( $post->ID, '_wp_page_template', $new_template );

				echo '<meta http-equiv="refresh" content="1"';
			}
		}
	}

	add_action( 'wp_head', 'inspiry_update_page_templates' );
}

if ( ! function_exists( 'inspiry_body_classes' ) ) {
	/**
	 * Inspiry Themes and Medical Press Class in body
	 */
	function inspiry_body_classes( $classes ) {

		$classes[] = 'inspiry-themes';
		$classes[] = 'inspiry-medicalpress-theme';

		global $theme_options;
		if ( isset( $theme_options['inspiry_boxed_layout'] ) ) {
			if ( '1' == $theme_options['inspiry_boxed_layout'] ) {
				$classes[] = 'inspiry-boxed-layout';
			}
		}

		/* Sticky Header Class */
		if ( $theme_options['sticky_header'] ) {
			$classes[] = 'sticky-header';
		}

		return $classes;
	}

	add_filter( 'body_class', 'inspiry_body_classes' );
}

if ( ! function_exists( 'generate_quick_css' ) ) {
	/**
	 *  Generate Quick CSS
	 */
	function generate_quick_css() {
		global $theme_options;
		if ( isset ( $theme_options['quick_css'] ) ) {
			if ( ! empty( $theme_options['quick_css'] ) ) {
				$quick_css = stripslashes( $theme_options['quick_css'] );
				if ( ! empty( $quick_css ) ) {
					echo "\n<style type='text/css' id='quick-css'>\n";
					echo $quick_css . "\n";
					echo "</style>" . "\n\n";
				}
			}
		}
	}

	add_action( 'wp_head', 'generate_quick_css' );
}

if ( ! function_exists( 'add_ie_html5_shim' ) ) {
	/**
	 * HTML5 shim IE8 support of HTML5 elements
	 */
	function add_ie_html5_shim() {
		echo '<!--[if lt IE 9]>';
		echo '<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>';
		echo '<script src="' . INSPIRY_ASSETS_DIR_URI . 'js/vendors/respond.min.js"></script>';
		echo '<![endif]-->';
	}

	add_action( 'wp_head', 'add_ie_html5_shim' );
}

if ( ! function_exists( 'inspiry_logo_img' ) ) {
	/**
	 * Display logo image
	 * @since   1.6.1
	 *
	 * @param   $logo_url // logo img url
	 * @param   $retina_logo_url // retina logo image url
	 *
	 * @return  void
	 */
	function inspiry_logo_img( $logo_url, $retina_logo_url ) {

		global $is_IE;

		if ( ! empty( $logo_url ) && ! empty( $retina_logo_url ) && ! $is_IE ) {
			echo '<img alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" src="' . esc_url( $logo_url ) . '" srcset="' . esc_url( $logo_url ) . ', ' . esc_url( $retina_logo_url ) . ' 2x">';
		} else if ( ! empty( $retina_logo_url ) ) {
			echo '<img alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" src="' . esc_url( $retina_logo_url ) . '">';
		} else {
			echo '<img alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" src="' . esc_url( $logo_url ) . '">';
		}
	}
}