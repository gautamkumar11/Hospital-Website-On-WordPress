<?php
global $theme_options;

$contact_methods = array();

if ( inspiry_get_option( 'display_call_to_action' ) && '1' == inspiry_get_option( 'display_call_to_action' ) ) {

	if ( inspiry_get_option( 'CTA_address' ) ) {
		$contact_methods[] = array(
			'image'   => inspiry_get_option( 'CTA_address_icon' )['url'],
			'title'   => '',
			'content' => inspiry_get_option( 'CTA_address' ),
			'url'     => '',
		);
	}

	if ( inspiry_get_option( 'CTA_number_title' ) || inspiry_get_option( 'CTA_number' ) ) {
		$contact_methods[] = array(
			'image'   => inspiry_get_option('CTA_number_icon')['url'],
			'title'   => inspiry_get_option( 'CTA_number_title' ),
			'content' => inspiry_get_option( 'CTA_number' ),
			'url'     => '',
		);
	}

	if ( inspiry_get_option( 'CTA_email_title' ) || inspiry_get_option( 'CTA_email' ) ) {
		$contact_methods[] = array(
			'image'   => inspiry_get_option('CTA_email_icon')['url'],
			'title'   => inspiry_get_option( 'CTA_email_title' ),
			'content' => inspiry_get_option( 'CTA_email' ),
			'url'     => '',
		);
	}

	if ( inspiry_get_option( 'CTA_appointment_title' ) || inspiry_get_option( 'CTA_appointment' ) ) {
		$contact_methods[] = array(
			'image'   => inspiry_get_option( 'CTA_appointment_icon')['url'],
			'title'   => inspiry_get_option( 'CTA_appointment_title' ),
			'content' => inspiry_get_option( 'CTA_appointment' ),
			'url'     => inspiry_get_option( 'CTA_appointment_page_url' ),
		);
	}
}

if ( ! empty( $contact_methods ) ) :
	$count = 1;
	$total_items = count( $contact_methods );
	$col_class   = 'col-md-6';

	if ( 4 == $total_items ) {
		$col_class .= ' col-xl-3';
	} elseif ( 3 == $total_items ) {
		$col_class .= ' col-lg-4';
	}
    ?>
    <div class="call-to-action">
        <div class="container">
            <div class="row align-items-center">
                <?php
                foreach ( $contact_methods as $contact_method ) :
                    $contact_method_image = $contact_method['image'];
                    $contact_method_title = $contact_method['title'];
                    $contact_method_content = $contact_method['content'];
                    $contact_method_url = $contact_method['url'];
                    if ( ! empty( $contact_method_title ) || ! empty( $contact_method_content ) ) : ?>
                        <div class="<?php echo esc_attr( $col_class ); ?>">
                            <div class="call-to-action-item call-to-action-contact-<?php echo $count; ?>">
                                <?php
                                if ( ! empty( $contact_method_image ) ) : ?>
                                    <div class="call-to-action-icon">
                                        <img src="<?php echo $contact_method_image; ?>" alt="<?php echo $contact_method_title; ?>">
                                    </div>
                                <?php endif; ?>
                                <div class="call-to-action-action">
                                    <?php
                                    if ( ! empty( $contact_method_title ) ) {
                                        echo '<h4 class="call-to-action-title">' . esc_html( $contact_method_title ) . '</h4>';
                                    }

                                    if ( ! empty( $contact_method_url ) ) {
                                        echo '<p class="call-to-action-content"><a href=' . get_page_link( $contact_method_url ) . '>' . esc_html( $contact_method_content ) . '</a></p>';
                                    } elseif ( ! empty( $contact_method_content ) ) {
                                        echo '<p class="call-to-action-content">' . esc_html( $contact_method_content ) . '</p>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    endif;

                    if ( $count % 4 == 0 && $count < $total_items ) {
                        echo '</div><div class="row align-items-center">';
                    }

	                $count++;
                endforeach; ?>
            </div>
        </div>
    </div><!-- .call-to-action -->
<?php endif; ?>