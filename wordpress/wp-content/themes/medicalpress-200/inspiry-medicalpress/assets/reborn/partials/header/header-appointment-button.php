<?php
global $theme_options;

if ( $theme_options['display_appointment_form'] == '1' && ! empty( $theme_options['appointment_button_title'] ) && ! empty( $theme_options['appointment_form_email'] ) ) : ?>
    <a id="header-appointment-button" class="header-appointment-button" href="#appointment-modal" data-toggle="modal">
		<?php include INSPIRY_ASSETS_DIR . '/images/svg/icon-calendar.svg'; ?>
		<?php echo esc_html( $theme_options['appointment_button_title'] ); ?>
    </a>
<?php endif; ?>