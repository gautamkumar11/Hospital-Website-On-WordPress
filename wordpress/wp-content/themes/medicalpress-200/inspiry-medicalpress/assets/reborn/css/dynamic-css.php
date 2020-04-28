<?php
if ( ! function_exists( 'generate_dynamic_css' ) ) {
	/**
	 * Generate Dynamic CSS for Reborn Design Variation
	 */
	function generate_dynamic_css() {

		global $theme_options;

		if ( isset(
			$theme_options['overall_theme_color_one'],
			$theme_options['overall_theme_color_two'],
			$theme_options['overall_link_color'],
			$theme_options['default_btn_bg'],
			$theme_options['default_btn_text_color'],
			$theme_options['read_more_btn_bg'],
			$theme_options['read_more_btn_text_color'],
			$theme_options['appo_form_heading_bg_color'],
			$theme_options['appo_form_bg_color'],
			$theme_options['appo_calendar_hover_color'],
            $theme_options['header_text_color'],
			$theme_options['main_menu_item_hover_bg_color'],
			$theme_options['footer_cta_gradient_color_one'],
            $theme_options['footer_cta_gradient_color_two'],
			$theme_options['footer_link_color']
		) ) {

			$overall_theme_color_one = $theme_options['overall_theme_color_one'];
			$overall_theme_color_two = $theme_options['overall_theme_color_two'];
			$overall_link_color           = $theme_options['overall_link_color'];
			$default_btn_bg               = $theme_options['default_btn_bg'];
			$default_btn_text_color       = $theme_options['default_btn_text_color'];
			$read_more_btn_bg             = $theme_options['read_more_btn_bg'];
			$read_more_btn_text_color     = $theme_options['read_more_btn_text_color'];
			$appo_form_bg                 = $theme_options['appo_form_bg_color'];
			$appo_calendar_hover          = $theme_options['appo_calendar_hover_color'];
			$footer_link_color            = $theme_options['footer_link_color'];

			$dynamic_css = array(
				array(
					'elements' => '.woocommerce nav.woocommerce-pagination ul a, .woocommerce nav.woocommerce-pagination ul span, .woocommerce nav.woocommerce-pagination ul li a, .woocommerce nav.woocommerce-pagination ul li span, .gallery-single .next-prev-posts a:hover, .gallery-single #carousel .flex-direction-nav a:hover, .overlay, .tagcloud a:hover, .flex-direction-nav a:hover, .contact-page-social-media-list a, .toggle-main .toggle.current .toggle-title, .accordion-main .accordion.current .accordion-title',
					'property' => 'background-color',
					'value'    => $overall_theme_color_one
				),
				array(
					'elements' => '.testimonials-carousel-item, .filters > li.active a, .tagcloud a:hover, .flex-direction-nav a:hover',
					'property' => 'border-color',
					'value'    => $overall_theme_color_one
				),
               array(
                   'elements' => '.home-features-item:hover, .entry-content .tabs-nav li.active, .sidebar .tab-head.active, .filters > li.active a:after',
                   'property' => 'border-top-color',
                   'value'    => $overall_theme_color_one
               ),
               array(
                   'elements' => '.woocommerce table.shop_table td a:hover, .doctor-grid .doctor-departments a:hover',
                   'property' => 'color',
                   'value'    => $overall_theme_color_one
               ),
				array(
					'elements' => '.select2-container--default .select2-results__option[data-selected=true], .select2-container--default .select2-results__option--highlighted[aria-selected], .woocommerce nav.woocommerce-pagination ul a:hover, .woocommerce nav.woocommerce-pagination ul a.current, .woocommerce nav.woocommerce-pagination ul span:hover, .woocommerce nav.woocommerce-pagination ul span.current, .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li a.current, .woocommerce nav.woocommerce-pagination ul li span:hover, .woocommerce nav.woocommerce-pagination ul li span.current, .woocommerce span.onsale, .woocommerce ul.products li.product span.onsale, .woocommerce-page ul.products li.product span.onsale, .owl-theme .owl-dots .owl-dot.active span, .owl-theme .owl-dots .owl-dot:hover span, .gallery-single .next-prev-posts a, .announcement, .flex-direction-nav a, .toggle-main .toggle-title, .accordion-main .accordion-title, .tagcloud a',
					'property' => 'background-color',
					'value'    => $overall_theme_color_two
				),
				array(
					'elements' => '.home-features-item, .flex-direction-nav a, .woocommerce-info, .tagcloud a',
					'property' => 'border-color',
					'value'    => $overall_theme_color_two
				),
               array(
                   'elements' => '.entry-footer .fa',
                   'property' => 'color',
                   'value'    => $overall_theme_color_two
               ),


				//Over All Link Color
				array(
					'elements' => 'a',
					'property' => 'color',
					'value'    => $overall_link_color['regular']
				),
				array(
					'elements' => 'a:hover, a:focus',
					'property' => 'color',
					'value'    => $overall_link_color['hover']
				),

				//Default Button Background and Text Color
				array(
					'elements' => '.btn:active, input[type="submit"]:active, .read-more:active, .btn-primary, .pagination span, .pagination a, .page-links span, .page-links a, form input[type="submit"], .woocommerce a.added_to_cart, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit, .woocommerce #respond input[type="submit"]',
					'property' => 'background-color',
					'value'    => $default_btn_bg['regular']
				),
				array(
					'elements' => '.scroll-top:hover, .btn:active:hover, input[type="submit"]:active:hover, .read-more:active:hover, .btn-outline-primary:hover, .btn-primary:hover, .pagination span:hover, .pagination span.current, .pagination a:hover, .pagination a.current, .page-links span:hover, .page-links span.current, .page-links a:hover, .page-links a.current, form input[type="submit"]:hover, form input[type="submit"]:focus, .woocommerce a.added_to_cart:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover, .woocommerce #respond input#submit:hover, .woocommerce #respond input[type="submit"]:hover',
					'property' => 'background-color',
					'value'    => $default_btn_bg['hover']
				),
				array(
					'elements' => '.btn:active, input[type="submit"]:active, .read-more:active, .btn-primary, .pagination span, .pagination a, .page-links span, .page-links a, form input[type="submit"], .woocommerce a.added_to_cart, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit, .woocommerce #respond input[type="submit"]',
					'property' => 'color',
					'value'    => $default_btn_text_color['regular']
				),
				array(
					'elements' => '.scroll-top:hover, .btn:active:hover, input[type="submit"]:active:hover, .read-more:active:hover, .btn-outline-primary:hover, .btn-primary:hover, .pagination span:hover, .pagination span.current, .pagination a:hover, .pagination a.current, .page-links span:hover, .page-links span.current, .page-links a:hover, .page-links a.current, form input[type="submit"]:hover, form input[type="submit"]:focus, .woocommerce a.added_to_cart:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover, .woocommerce #respond input#submit:hover, .woocommerce #respond input[type="submit"]:hover',
					'property' => 'color',
					'value'    => $default_btn_text_color['hover']
				),

				// Read More Button Background and Text Color
				array(
					'elements' => '.read-more, .woocommerce ul.products li.product .button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt',
					'property' => 'background-color',
					'value'    => $read_more_btn_bg['regular']
				),
				array(
					'elements' => '.read-more:hover, .read-more:focus, .woocommerce ul.products li.product .button:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover',
					'property' => 'background-color',
					'value'    => $read_more_btn_bg['hover']
				),
				array(
					'elements' => '.read-more, .woocommerce ul.products li.product .button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt',
					'property' => 'color',
					'value'    => $read_more_btn_text_color['regular']
				),
				array(
					'elements' => '.read-more:hover, .read-more:focus, .woocommerce ul.products li.product .button:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover',
					'property' => 'color',
					'value'    => $read_more_btn_text_color['hover']
				),

				//Appointment Form Background Color
				array(
					'elements' => '.home-slider .appointment-form, .ui-datepicker-header',
					'property' => 'background-color',
					'value'    => $appo_form_bg
				),

				//Appointment Form Calender Hover,Active and Focus Color
				array(
					'elements' => 'td .ui-state-active, td .ui-state-hover, td .ui-state-highlight, .ui-datepicker-header .ui-state-hover',
					'property' => 'background-color',
					'value'    => $appo_calendar_hover
				),

				//Footer
				array(
					'elements' => '.site-footer a',
					'property' => 'color',
					'value'    => $footer_link_color['regular']
				),
				array(
					'elements' => '.site-footer a:hover',
					'property' => 'color',
					'value'    => $footer_link_color['hover']
				),
				array(
					'elements' => '.site-footer a:active',
					'property' => 'color',
					'value'    => $footer_link_color['active']
				),
			);

			$prop_count = count( $dynamic_css );

			if ( $prop_count > 0 ) {

				echo "<style type='text/css' id='inspiry-dynamic-css'>\n\n";

				foreach ( $dynamic_css as $css_unit ) {
					if ( ! empty( $css_unit['value'] ) ) {
						echo $css_unit['elements'] . "{\n";
						echo $css_unit['property'] . ":" . $css_unit['value'] . ";\n";
						echo "}\n\n";
					}
				}

				$header_search_form_text_color = $theme_options['header_text_color'];
				$footer_cta_gradient_color_one = $theme_options['footer_cta_gradient_color_one'];
				$footer_cta_gradient_color_two = $theme_options['footer_cta_gradient_color_two'];
				?>
                .header-search-form-container input:-moz-placeholder {
                    color: <?php echo $header_search_form_text_color; ?>;
                }

                .header-search-form-container input::-moz-placeholder {
                    color: <?php echo $header_search_form_text_color; ?>;
                }

                .header-search-form-container input:-ms-input-placeholder {
                    color: <?php echo $header_search_form_text_color; ?>;
                }

                .header-search-form-container input::-webkit-input-placeholder {
                    color: <?php echo $header_search_form_text_color; ?>;
                }

                @media (max-width: 991px){
                    .site-header-bottom {
                        background-color: <?php echo $theme_options['main_menu_item_hover_bg_color']; ?>
                    }
                }

                .call-to-action {
                    background-image: -webkit-linear-gradient(left, <?php echo $footer_cta_gradient_color_one; ?> 0%, <?php echo $footer_cta_gradient_color_two; ?> 100%);
                    background-image: linear-gradient(to right, <?php echo $footer_cta_gradient_color_one; ?> 0%, <?php echo $footer_cta_gradient_color_two; ?> 100%);
                }
				<?php
				echo '</style>';
			}
		}
	}

	add_action( 'wp_head', 'generate_dynamic_css' );
}