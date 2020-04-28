<?php
if ( ! function_exists( 'send_message' ) ) {
	/**
	 * File Name: contact_form_handler.php
	 *
	 * Send message function to process contact form submission
	 *
	 */
	function send_message() {

		if ( isset( $_POST['email'] ) ) {

			$nonce = $_POST['nonce'];

			if ( ! wp_verify_nonce( $nonce, 'send_message_nonce' ) ) {
				echo json_encode( array(
					'success' => false,
					'message' => __( 'Unverified Nonce!', 'framework' )
				) );
				die;
			}

			global $theme_options;

			/* Verify Google reCAPTCHA */
			if ( isset( $_POST['inspiry_is_reCAPTCHA_configured'] ) && '1' == $_POST['inspiry_is_reCAPTCHA_configured'] ) {
				inspiry_verify_google_recaptcha();
	        }

			/* Sanitize and Validate Target email address that will be configured from theme options */
			$to_email = sanitize_email( $theme_options['contact_email'] );
			$to_email = is_email( $to_email );
			if ( ! $to_email ) {
				echo json_encode( array(
					'success' => false,
					'message' => __( 'Target Email address is not properly configured!', 'framework' )
				) );
				die;
			}

			/* Sanitize and Validate contact form input data */
			$from_name    = sanitize_text_field( $_POST['name'] );
			$phone_number = sanitize_text_field( $_POST['number'] );
			$message      = stripslashes( $_POST['message'] );
			$from_email   = sanitize_email( $_POST['email'] );
			$from_email   = is_email( $from_email );
			if ( ! $from_email ) {
				echo json_encode( array(
					'success' => false,
					'message' => __( 'Provided Email address is invalid!', 'framework' )
				) );
				die;
			}

			$email_subject = __( 'New message sent by', 'framework' ) . ' ' . $from_name . ' ' . __( 'using contact form at', 'framework' ) . ' ' . get_bloginfo( 'name' );

			$email_body = __( "You have received a message from: ", 'framework' ) . $from_name . " <br/>";

			if ( ! empty( $phone_number ) ) {
				$email_body .= __( "Phone Number : ", 'framework' ) . $phone_number . " <br/>";
			}

			$email_body .= __( "Their additional message is as follows.", 'framework' ) . " <br/>";
			$email_body .= wpautop( $message ) . " <br/>";
			$email_body .= __( "You can contact ", 'framework' ) . $from_name . __( " via email, ", 'framework' ) . $from_email;

			/*
			 * Email Headers ( Reply To and Content Type )
			 */
			$headers = array();

			/* Send CC of contact form message if configured */
			if ( isset( $theme_options['contact_cc_email'] ) ) {
				$cc_email = $theme_options['contact_cc_email'];
				$cc_email = explode( ',', $cc_email );
				if ( ! empty( $cc_email ) ) {
					foreach ( $cc_email as $ind_email ) {
						$ind_email = sanitize_email( $ind_email );
						$ind_email = is_email( $ind_email );
						if ( $ind_email ) {
							$headers[] = "Cc: $ind_email";
						}
					}
				}
			}

			/* Send BCC of contact form message if configured */
			if ( isset( $theme_options['contact_bcc_email'] ) ) {
				$bcc_email = $theme_options['contact_bcc_email'];
				$bcc_email = explode( ',', $bcc_email );
				if ( ! empty( $bcc_email ) ) {
					foreach ( $bcc_email as $ind_email ) {
						$ind_email = sanitize_email( $ind_email );
						$ind_email = is_email( $ind_email );
						if ( $ind_email ) {
							$headers[] = "Bcc: $ind_email";
						}
					}
				}
			}

			$headers[] = "Reply-To: $from_name <$from_email>";
			$headers[] = "Content-Type: text/html; charset=UTF-8";
			$headers   = apply_filters( "inspiry_contact_mail_header", $headers );

			if ( wp_mail( $to_email, $email_subject, $email_body, $headers ) ) {
				echo json_encode( array(
					'success' => true,
					'message' => __( "Message Sent Successfully!", 'framework' )
				) );
			} else {
				echo json_encode( array(
						'success' => false,
						'message' => __( "Server Error: WordPress mail function failed!", 'framework' )
					)
				);
			}

		} else {
			echo json_encode( array(
					'success' => false,
					'message' => __( "Invalid Request !", 'framework' )
				)
			);
		}
		die;
	}

	add_action( 'wp_ajax_nopriv_send_message', 'send_message' );
	add_action( 'wp_ajax_send_message', 'send_message' );
}

if ( ! function_exists( 'make_appointment' ) ) {
	/**
	 * appointment request handler
	 */
	function make_appointment() {

		if ( isset( $_POST['email'] ) ):

			$nonce = $_POST['nonce'];

			if ( ! wp_verify_nonce( $nonce, 'request_appointment_nonce' ) ) {
				echo json_encode( array(
					'success' => false,
					'message' => __( 'Unverified Nonce!', 'framework' )
				) );
				die;
			}

			global $theme_options;

			/* Verify Google reCAPTCHA */
			if ( isset( $_POST['inspiry_is_reCAPTCHA_configured'] ) && '1' == $_POST['inspiry_is_reCAPTCHA_configured'] ) {
				inspiry_verify_google_recaptcha();
			}

			/* Sanitize and Validate Target email address that will be configured from theme options */
			$to_email = sanitize_email( $theme_options['appointment_form_email'] );
			$to_email = is_email( $to_email );
			if ( ! $to_email ) {
				echo json_encode( array(
					'success' => false,
					'message' => __( 'Target Email address is not properly configured!', 'framework' )
				) );
				die;
			}

			/* Getting Thank you page link for redirection */
			$thank_you_page = '';
			if ( isset( $theme_options['appointment_thankyou_page'] ) ) {
				$thank_you_page = get_permalink( $theme_options['appointment_thankyou_page'] );
			}

			/* Sanitize and Validate appointment form input data */
			$from_name        = sanitize_text_field( $_POST['name'] );
			$phone_number     = sanitize_text_field( $_POST['number'] );
			$appointment_date = sanitize_text_field( $_POST['date'] );
			$message          = stripslashes( $_POST['message'] );
			$from_email       = sanitize_email( $_POST['email'] );
			$from_email       = is_email( $from_email );
			if ( ! $from_email ) {
				echo json_encode( array(
					'success' => false,
					'message' => __( 'Provided Email address is invalid!', 'framework' )
				) );
				die;
			}

			$email_subject = __( 'New appointment request sent by', 'framework' ) . ' ' . $from_name . ' ' . __( 'using appointment form at', 'framework' ) . ' ' . get_bloginfo( 'name' );

			$email_body = __( "You have received an appointment request from: ", 'framework' ) . $from_name . " <br/>";

			if ( ! empty( $phone_number ) ) {
				$email_body .= __( "Phone Number : ", 'framework' ) . $phone_number . " <br/>";
			}

			if ( ! empty( $appointment_date ) ) {
				$email_body .= __( "Appointment Date : ", 'framework' ) . $appointment_date . " <br/>";
			}

			$email_body .= __( "Their additional message is as follows.", 'framework' ) . " <br/>";
			$email_body .= wpautop( $message ) . " <br/>";
			$email_body .= __( "You can contact ", 'framework' ) . $from_name . __( " via email, ", 'framework' ) . $from_email;

			/*
			 * Email Headers ( Reply To and Content Type )
			 */
			$headers = array();

			/* Send CC of appointment form message if configured */
			if ( isset( $theme_options['appointment_cc_form_email'] ) ) {
				$cc_email = $theme_options['appointment_cc_form_email'];
				$cc_email = explode( ',', $cc_email );
				if ( ! empty( $cc_email ) ) {
					foreach ( $cc_email as $ind_email ) {
						$ind_email = sanitize_email( $ind_email );
						$ind_email = is_email( $ind_email );
						if ( $ind_email ) {
							$headers[] = "Cc: $ind_email";
						}
					}
				}
			}

			/* Send BCC of appointment form message if configured */
			if ( isset( $theme_options['appointment_bcc_form_email'] ) ) {
				$bcc_email = $theme_options['appointment_bcc_form_email'];
				$bcc_email = explode( ',', $bcc_email );
				if ( ! empty( $bcc_email ) ) {
					foreach ( $bcc_email as $ind_email ) {
						$ind_email = sanitize_email( $ind_email );
						$ind_email = is_email( $ind_email );
						if ( $ind_email ) {
							$headers[] = "Bcc: $ind_email";
						}
					}
				}
			}

			$headers[] = "Reply-To: $from_name <$from_email>";
			$headers[] = "Content-Type: text/html; charset=UTF-8";
			$headers   = apply_filters( "inspiry_contact_mail_header", $headers );

			$appointment_confirmation_args                 = array();
			$appointment_confirmation_args['sender_name']  = $from_name;
			$appointment_confirmation_args['sender_email'] = $from_email;

			if ( wp_mail( $to_email, $email_subject, $email_body, $headers ) ) {
				do_action( 'inspiry_appointment_confirmation', $appointment_confirmation_args );
				echo json_encode( array(
					'success'  => true,
					'message'  => __( "Message Sent Successfully!", 'framework' ),
					'redirect' => $thank_you_page
				) );
			} else {
				echo json_encode( array(
						'success' => false,
						'message' => __( "Server Error: WordPress mail function failed!", 'framework' )
					)
				);
			}
		else:
			echo json_encode( array(
					'success' => false,
					'message' => __( "Invalid Request !", 'framework' )
				)
			);
		endif;
		die;
	}

	add_action( 'wp_ajax_nopriv_make_appointment', 'make_appointment' );
	add_action( 'wp_ajax_make_appointment', 'make_appointment' );
}

if ( ! function_exists( 'inspiry_appointment_confirmation_email' ) ) {
	/**
	 * appointment confirmation email
	 */
	function inspiry_appointment_confirmation_email( $appointment_confirmation_args ) {

		global $theme_options;
		$to_email                = $appointment_confirmation_args['sender_email'];
		$to_name                 = $appointment_confirmation_args['sender_name'];
		$blog_name               = get_bloginfo( 'name' );
		$from_email              = sanitize_email( $theme_options['contact_email'] );
		$email_confirmation_text = $theme_options['appointment_confirmation_email'];

		$email_subject = sprintf( __( 'Your appointment request has been received to  %1$s.', 'framework' ), $blog_name );

		if ( ! empty( $email_confirmation_text ) ) {
			$email_body = sprintf( "<pre style='font-family: inherit;'>" . esc_html( $email_confirmation_text ) . "</pre>", $to_name, $blog_name );
		} else {
			$email_body = __( 'Dear ', 'framework' ) . $to_name . ',<br/><br/>';
			$email_body .= sprintf( __( 'Thanks for booking your appointment with the %1$s. We will get back to you soon.</br></br>', 'framework' ), $blog_name );
			$email_body .= __( 'Thank You!', 'framework' );
		}

		$headers   = array();
		$headers[] = "Reply-To: $blog_name <$from_email>";
		$headers[] = "Content-Type: text/html; charset=UTF-8";
		$headers   = apply_filters( "inspiry_confirmation_email_header", $headers );

		wp_mail( $to_email, $email_subject, $email_body, $headers );
	}

	add_action( 'inspiry_appointment_confirmation', 'inspiry_appointment_confirmation_email' );
}