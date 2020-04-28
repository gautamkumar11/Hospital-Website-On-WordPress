<?php
global $theme_options;

get_header(); ?>
    <div class="contact-page">
        <div class="container">
	        <?php get_template_part( INSPIRY_PARTIALS . '/common/page-content' ); ?>
            <div class="row">
				<?php if ($theme_options['display_contact_form']) : ?>
                    <div class="col-md-7 col-lg-6">
                        <form id="contact_form" class="contact-form" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post">
                            <input type="text" name="name" id="name" class="required" placeholder="<?php esc_attr_e('Full Name', 'framework'); ?>" title="<?php esc_attr_e('* Please provide your name', 'framework'); ?>">
                            <input type="text" name="email" id="email" class="required email" placeholder="<?php esc_attr_e('Email Address', 'framework'); ?>" title="<?php esc_attr_e('* Please provide a valid email address', 'framework'); ?>">
                            <input type="text" name="number" id="number" class="phoneNumber" placeholder="<?php esc_attr_e('Phone Number', 'framework'); ?>" title="<?php _e('* Please provide a valid phone number.', 'framework'); ?>">
                            <input type="hidden" name="action" value="send_message"/>
                            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('send_message_nonce'); ?>"/>
                            <textarea name="message" id="message" class="required" cols="30" rows="5" placeholder="<?php esc_attr_e('Message', 'framework'); ?>" title="<?php esc_attr_e('* Please provide your message', 'framework'); ?>"></textarea>
	                        <div class="row">
                                <div class="col-xl-6">
	                                <?php get_template_part( INSPIRY_COMMON . '/recaptcha/custom-recaptcha' ); ?>
                                </div>
                                <div class="col-xl-6">
                                    <input id="contact-form-submit" type="submit" class="btn btn-primary" value="<?php esc_attr_e('Submit', 'framework'); ?>">
                                    <img src="<?php echo INSPIRY_COMMON_DIR_URI; ?>/images/loader.gif" id="contact-loader" alt="Loading...">
                                </div>
                            </div>
                            <div id="error-container"></div>
                            <div id="response-container"></div>
                        </form>
                    </div>
                <?php endif; ?>
				<?php if ( $theme_options['display_contact_details'] ) : ?>
                    <div class="col-md-5 col-lg-6">
                        <div class="contact-sidebar">
                            <?php if ( ! empty( $theme_options['contact_details_title'] ) ) : ?>
                                <h2><span><?php echo $theme_options['contact_details_title'] ?></span></h2>
                            <?php endif; ?>

                            <?php if ( ! empty( $theme_options['contact_address'] ) ) : ?>
                                <address><?php echo $theme_options['contact_address']; ?></address>
                            <?php endif; ?>

                            <?php if ( ! empty( $theme_options['contact_phone'] ) ) : ?>
                                <p><strong><?php esc_html_e( 'Phone:', 'framework' ); ?></strong> <?php echo $theme_options['contact_phone']; ?></p>
                            <?php endif; ?>

                            <?php if ( ! empty( $theme_options['contact_fax'] ) ) : ?>
                                <p><strong><?php esc_html_e( 'Fax:', 'framework' ); ?></strong> <?php echo $theme_options['contact_fax']; ?></p>
                            <?php endif; ?>
							<?php if ( $theme_options['display_social_icons'] ) : ?>
                                <div class="contact-page-social-media">
                                    <h5 class="contact-page-social-media-title"><?php esc_html_e( 'Social:', 'framework' ); ?></h5>
									<?php inspiry_social_nav( 'contact-page-social-media-list', 'display_social_icons' ); ?>
                                </div>
							<?php endif; ?>
                        </div>
                    </div>
				<?php endif; ?>
            </div>
        </div>
		<?php
		$alert_classes    = ( 'default' == INSPIRY_DESIGN_VARIATION ? 'message bg-danger text-danger' : 'message alert-danger' );
		$map_notification = __( 'Google Map API key is missing! in order to show Google Map, please provide Google Map API key in Theme Options > Contact > Google Map Api Key.', 'framework' );

		if ( isset( $theme_options['display_google_map'], $theme_options['google_map_style'] ) ) :
			if ( '1' == $theme_options['display_google_map'] && '2' != $theme_options['google_map_style'] ) : ?>
                <div class="container">
                    <div class="default-map-wrapper map-wrapper">
                        <?php
                        if ( ! empty( $theme_options['google_map_title'] ) ) : ?>
                            <h5><?php echo $theme_options['google_map_title']; ?></h5><?php
                        endif;

                        if ( isset( $theme_options[ 'google_map_api_key' ] ) && ! empty( $theme_options[ 'google_map_api_key' ] ) ) :?>
                            <div id="map-canvas" class="default-map"></div>
                            <?php
                        else: ?>
                            <p class="<?php echo esc_attr($alert_classes); ?>">
                                <strong><?php esc_html_e( 'Error: ', 'framework' ); ?></strong><?php echo esc_html( $map_notification ); ?>
                            </p>
                            <?php
                        endif;
                        /* Contact map related JavaScript code reside in functions.php in function named generate_dynamic_javascript */ ?>
                    </div>
                </div>
				<?php
			endif;
		endif;
		?>
    </div>

<?php
if ( isset( $theme_options['display_google_map'], $theme_options['google_map_style'] ) ) :
	if ( '1' == $theme_options['display_google_map'] &&  '2' == $theme_options['google_map_style'] ) :
		if ( isset( $theme_options['google_map_api_key'] ) && ! empty( $theme_options['google_map_api_key'] ) ) :?>
            <div class="map-wrapper">
                <div id="map-canvas" class="full-width-map"></div>
            </div>
			<?php
		else: ?>
            <p class="<?php echo esc_attr($alert_classes); ?>">
                <strong><?php esc_html_e( 'Error: ', 'framework' ); ?></strong><?php echo esc_html( $map_notification ); ?>
            </p>
			<?php
		endif;
	endif;
endif;

get_footer(); ?>