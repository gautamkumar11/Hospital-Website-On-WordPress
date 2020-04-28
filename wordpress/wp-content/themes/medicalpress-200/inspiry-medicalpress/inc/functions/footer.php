<?php
if ( ! function_exists( 'generate_quick_js' ) ) {
	/**
	 *  Generate Quick JavaScript
	 */
	function generate_quick_js() {
		global $theme_options;
		if ( isset ( $theme_options['quick_css'] ) ) {
			if ( $theme_options['quick_js'] ) {
				$quick_js = stripslashes( $theme_options['quick_js'] );
				if ( ! empty( $quick_js ) ) {
					echo "\n<script type='text/javascript' id='quick-js'>\n";
					echo $quick_js . "\n";
					echo "</script>" . "\n\n";
				}
			}
		}
	}

	add_action( 'wp_footer', 'generate_quick_js' );
}

if ( ! function_exists( 'generate_dynamic_javascript' ) ) {
	/**
	 * Generate Dynamic JavaScript
	 */
	function generate_dynamic_javascript() {

		if ( is_page_template( 'templates/contact.php' ) ) {

			global $theme_options;

			/* check if related theme option is enabled */
			if ( isset( $theme_options['google_map_api_key'], $theme_options['display_google_map'] ) && ! empty( $theme_options['google_map_api_key'] ) && ! empty( $theme_options['display_google_map'] ) ) {
				/* Generate */
				?>
                <script>
                    function initializeContactMap() {
                        var officeLocation = new google.maps.LatLng(<?php  echo $theme_options['google_map_latitude'];  ?>, <?php echo $theme_options['google_map_longitude'];  ?>);
                        var contactMapOptions = {
                            zoom:  <?php echo $theme_options['google_map_zoom'];  ?>,
                            center: officeLocation,
                            mapTypeId: google.maps.MapTypeId.ROADMAP,
                            scrollwheel: false
                        };
                        
                        var contactMap = new google.maps.Map(document.getElementById('map-canvas'), contactMapOptions);

                        var contactMarker = new google.maps.Marker({
                            position: officeLocation,
                            map: contactMap
                        });
                    }
                    window.onload = initializeContactMap();
                </script>
				<?php
			}
		}
	}

	/* Attach dynamic javascript generation function with wp_footer action hook */
	add_action( 'wp_footer', 'generate_dynamic_javascript' );
}

if ( ! function_exists( 'inspiry_modal_appointment' ) ) {
	/**
	 * Generate modal appointment form
	 */
	function inspiry_modal_appointment() {

		get_template_part( INSPIRY_PARTIALS . '/common/appoint-form' );
	}

	if ( 'reborn' == INSPIRY_DESIGN_VARIATION ) {
		add_action( 'wp_footer', 'inspiry_modal_appointment', 5 );
	}
}