<?php
global $theme_options;

if ( isset( $theme_options['header_contact_address'] ) && ! empty( $theme_options['header_contact_address'] ) ) :?>
    <div class="header-address">
	    <?php include INSPIRY_ASSETS_DIR . '/images/svg/icon-pin.svg'; ?>
        <address><?php echo esc_html( $theme_options['header_contact_address'] ); ?></address>
    </div>
	<?php
endif;