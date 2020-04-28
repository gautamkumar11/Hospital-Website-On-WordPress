<?php
global $theme_options;

$header_contact_number_label = esc_html__( 'Make an Appointment', 'framework' );

if ( isset( $theme_options['header_contact_number_label'] ) && ! empty( $theme_options['header_contact_number_label'] ) ) {
	$header_contact_number_label = $theme_options['header_contact_number_label'];
}

if ( isset( $theme_options['header_contact_number'] ) && ! empty( $theme_options['header_contact_number'] ) ) :
	$header_contact_number = $theme_options['header_contact_number'];
	?>
    <div class="header-contact-number">
	    <?php include INSPIRY_ASSETS_DIR . '/images/svg/icon-phone.svg'; ?>
        <small><?php echo esc_html( $header_contact_number_label ); ?></small>
        <span class="desktop-version"><?php echo esc_html( $header_contact_number ); ?></span>
        <a class="mobile-version" href="tel://<?php echo esc_attr( preg_replace( "/[^0-9]/", "", $header_contact_number ) ); ?>" title="<?php esc_attr_e( 'Make a Call', 'framework' ); ?>"><?php echo esc_html( $header_contact_number ); ?></a>
    </div><!-- .header-contact-number -->
<?php endif; ?>