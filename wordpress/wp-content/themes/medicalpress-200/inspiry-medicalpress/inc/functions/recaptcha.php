<?php
if ( ! function_exists( 'inspiry_is_reCAPTCHA_configured' ) ) {
	/**
	 * Check if Google reCAPTCHA is properly configured and enabled or not
	 *
	 * @return bool
	 */
	function inspiry_is_reCAPTCHA_configured() {

		if ( inspiry_get_option( 'recaptcha_public_key' ) && inspiry_get_option( 'recaptcha_private_key' ) ) {

			if ( 'reborn' == INSPIRY_DESIGN_VARIATION ) {
				if ( ( '1' == inspiry_get_option( 'display_appointment_recaptcha' ) ) ||
				     ( '1' == inspiry_get_option( 'display_contact_recaptcha' ) && is_page_template( 'templates/contact.php' ) ) ||
				     ( '1' == inspiry_get_option( 'display_appointment_recaptcha' ) && is_page_template( 'templates/make-appointment.php' ) ) ) {
					return true;
				}
			} else {
				if ( ( '1' == inspiry_get_option( 'display_contact_recaptcha' ) && is_page_template( 'templates/contact.php' ) ) ||
				     ( '1' == inspiry_get_option( 'display_appointment_recaptcha' ) && is_page_template( array(
						     'templates/make-appointment.php',
						     'templates/home.php',
						     'templates/demo-home-two.php',
						     'templates/demo-home-three.php',
						     'templates/demo-home-four.php',
						     'templates/demo-home-five.php',
					     ) ) ) ) {
					return true;
				}
			}
		}

		return false;
	}
}

if ( ! function_exists( 'inspiry_recaptcha_script' ) ) {

	function inspiry_recaptcha_script() {

		if ( ! is_admin() && inspiry_is_reCAPTCHA_configured() ) {

			$recaptcha_src = esc_url_raw( add_query_arg( array(
				'render' => 'explicit',
				'onload' => 'loadInspiryReCAPTCHA',
			), '//www.google.com/recaptcha/api.js' ) );

			wp_enqueue_script( 'inspiry-google-recaptcha', $recaptcha_src, array(), INSPIRY_THEME_VERSION, true );
		}else{
			remove_action( 'wp_footer', 'inspiry_recaptcha_callback_generator' );
        }
	}

	add_action( 'wp_enqueue_scripts', 'inspiry_recaptcha_script' );
}

if ( ! function_exists( 'inspiry_recaptcha_callback_generator' ) ) {
	/**
	 * Generates a call back JavaScript function for reCAPTCHA
	 */
	function inspiry_recaptcha_callback_generator() {

		global $theme_options;

		$reCAPTCHA_public_key = $theme_options['recaptcha_public_key'];
		?>
        <script type="text/javascript">
            var reCAPTCHAWidgetIDs = [];
            var inspirySiteKey = '<?php echo $reCAPTCHA_public_key; ?>';

            // Render Google reCAPTCHA and store their widget IDs in an array
            var loadInspiryReCAPTCHA = function () {
                jQuery('.inspiry-google-recaptcha').each(function (index, el) {
                    var tempWidgetID = grecaptcha.render(el, {
                        'sitekey': inspirySiteKey
                    });
                    reCAPTCHAWidgetIDs.push(tempWidgetID);
                });
            };

            // For Google reCAPTCHA reset
            var inspiryResetReCAPTCHA = function () {
                if (typeof reCAPTCHAWidgetIDs != 'undefined') {
                    var arrayLength = reCAPTCHAWidgetIDs.length;
                    for (var i = 0; i < arrayLength; i++) {
                        grecaptcha.reset(reCAPTCHAWidgetIDs[i]);
                    }
                }
            };
        </script>
		<?php
	}

	add_action( 'wp_footer', 'inspiry_recaptcha_callback_generator' );
}

if ( ! function_exists( 'inspiry_verify_google_recaptcha' ) ) {
	/**
	 * This function verifies google recaptcha and echo a json array if fails
	 */
	function inspiry_verify_google_recaptcha() {

		global $theme_options;

		$reCAPTCHA_private_key = $theme_options['recaptcha_private_key'];

		// include reCAPTCHA library - https://github.com/google/recaptcha
		include_once( INSPIRY_INC_DIR . '/recaptcha/autoload.php' );

		// If the form submission includes the "g-captcha-response" field
		// Create an instance of the service using your secret
		$reCAPTCHA = new \ReCaptcha\ReCaptcha( $reCAPTCHA_private_key, new \ReCaptcha\RequestMethod\CurlPost() );

		// Make the call to verify the response and also pass the user's IP address
		$resp = $reCAPTCHA->verify( $_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR'] );

		if ( $resp->isSuccess() ) {
			// If the response is a success, Then all is good =)
		} else {
			// reference for error codes - https://developers.google.com/recaptcha/docs/verify
			$error_messages      = array(
				'missing-input-secret'   => 'The secret parameter is missing.',
				'invalid-input-secret'   => 'The secret parameter is invalid or malformed.',
				'missing-input-response' => 'The response parameter is missing.',
				'invalid-input-response' => 'The response parameter is invalid or malformed.',
			);
			$error_codes         = $resp->getErrorCodes();
			$final_error_message = $error_messages[ $error_codes[0] ];
			echo json_encode( array(
				'success' => false,
				'message' => __( 'reCAPTCHA Failed:', 'framework' ) . ' ' . $final_error_message
			) );
			die;
		}
	}
}