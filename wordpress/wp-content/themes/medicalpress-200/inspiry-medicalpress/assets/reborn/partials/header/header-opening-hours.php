<?php
global $theme_options;
if ( isset( $theme_options['header_opening_hours'] ) && ! empty( $theme_options['header_opening_hours'] ) ) :
	$header_opening_hours_label = isset( $theme_options['header_opening_hours_label'] ) ? $theme_options['header_opening_hours_label'] : __( 'Opening Hours', 'framework' ); ?>
    <p class="opening-hours header-opening-hours">
	    <?php include INSPIRY_ASSETS_DIR . '/images/svg/icon-clock.svg'; ?>
        <span class="opening-hours-label"><?php echo esc_html( $header_opening_hours_label ) . ' :'; ?></span>
        <span class="opening-hours-content"><?php echo esc_html( $theme_options['header_opening_hours'] ); ?></span>
    </p>
<?php endif; ?>