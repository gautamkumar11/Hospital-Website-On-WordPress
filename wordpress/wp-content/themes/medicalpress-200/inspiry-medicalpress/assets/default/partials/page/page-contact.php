<?php
/*
 *  Template Name: Contact Template
 */

get_header(); ?>

    <div class="page-top clearfix">
        <div class="container">
            <div class="row">
                <div class="<?php bc_all('12'); ?>">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    <nav class="bread-crumb">
						<?php theme_breadcrumb(); ?>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="contact-page clearfix">
        <div class="container">
            <div class="row">
				<?php
				if (have_posts()):
					while (have_posts()):
						the_post();
						$content = get_the_content();
						if (!empty($content)) {
							?>
                            <div class="<?php bc_all('12'); ?>">
                                <div class="blog-page-single clearfix">
                                    <article id="post-<?php the_ID(); ?>" <?php post_class(' clearfix'); ?>>
                                        <div class="full-width-contents">
                                            <div class="entry-content">
												<?php
												/* output page contents */
												the_content();
												?>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            </div>
                            <div class="clearfix"></div>
							<?php
						}
					endwhile;
				endif;

				global $theme_options;

				if ($theme_options['display_contact_form']) {
					?>
                    <div class="<?php bc('6', '6', '', '') ?>">
                        <form id="contact_form" class="contact-form" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post">
                            <input type="text" name="name" id="name" class="required" placeholder="<?php _e('Full Name', 'framework'); ?>" title="<?php _e('* Please provide your name', 'framework'); ?>">
                            <input type="text" name="email" id="email" class="required email" placeholder="<?php _e('Email Address', 'framework'); ?>" title="<?php _e('* Please provide a valid email address', 'framework'); ?>">
                            <input type="text" name="number" id="number" class="phoneNumber" placeholder="<?php _e('Phone Number', 'framework'); ?>" title="<?php _e('* Please provide a valid phone number.', 'framework'); ?>">
                            <input type="hidden" name="action" value="send_message"/>
                            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('send_message_nonce'); ?>"/>
                            <textarea name="message" id="message" class="required" cols="30" rows="5" placeholder="<?php _e('Message', 'framework'); ?>" title="<?php _e('* Please provide your message', 'framework'); ?>"></textarea>
                            <div class="row">
                                <div class="col-sm-6">
	                                <?php get_template_part( INSPIRY_COMMON . '/recaptcha/custom-recaptcha' ); ?>
                                </div>
                                <div class="col-sm-6">
                                    <input id="contact-form-submit" type="submit" class="btn btn-primary" value="<?php esc_attr_e('Submit', 'framework'); ?>">
                                    <img src="<?php echo INSPIRY_COMMON_DIR_URI; ?>/images/loader.gif" id="contact-loader" alt="Loading...">
                                </div>
                            </div>
                            <div id="error-container"></div>
                            <div id="response-container"></div>
                        </form>
                    </div>
					<?php
				}

				if ($theme_options['display_contact_details']) {
					?>
                    <div class="<?php bc('5', '6', '', '');
					if ($theme_options['display_contact_form']) {
						echo ' col-lg-offset-1';
					} ?>">
                        <div class="contact-sidebar clearfix">
                            <article class="address-area clearfix">
								<?php
								if (!empty($theme_options['contact_details_title'])) {
									echo '<h2><span>' . $theme_options['contact_details_title'] . '</span></h2>';
								}
								?>
                                <div class="row">
									<?php
									if (!empty($theme_options['contact_address'])) {
										?>
                                        <div class="<?php bc('6', '6', '12', ''); ?>">
                                            <address><?php echo $theme_options['contact_address']; ?></address>
                                        </div>
										<?php
									}

									if ((!empty($theme_options['contact_phone'])) || (!empty($theme_options['contact_fax']))) {
										?>
                                        <div class="<?php bc('6', '6', '12', ''); ?>">
											<?php
											if (!empty($theme_options['contact_phone'])) {
												?><p>
                                                <strong><?php _e('Phone :', 'framework'); ?></strong><?php echo $theme_options['contact_phone']; ?>
                                                </p><?php
											}
											if (!empty($theme_options['contact_fax'])) {
												?><p>
                                                <strong><?php _e('Fax :', 'framework'); ?></strong><?php echo $theme_options['contact_fax']; ?>
                                                </p><?php
											}
											?>
                                        </div>
										<?php
									}
									?>
                                </div>
                            </article>
							<?php
							if ($theme_options['display_social_icons']) {
								?>
                                <article class="social-icon clearfix">
                                    <h5><span><?php _e('Social :', 'framework'); ?></span></h5>
	                                <?php inspiry_social_nav( '', 'display_social_icons'); ?>
                                </article>
								<?php
							}
							?>
                        </div>
                    </div>
					<?php
				}
				?>
            </div>
        </div>

		<?php
		$map_notification = __('Google Map API key is missing! in order to show Google Map, please provide Google Map API key in Theme Options > Contact > Google Map Api Key.', 'framework');
		if ( isset( $theme_options['display_google_map'], $theme_options['google_map_style'] ) ) :
			if ( '1' == $theme_options['display_google_map'] && '2' != $theme_options['google_map_style'] ) : ?>
                <div class="container">
                    <div class="row">
                        <div class="<?php bc_all( '12' ); ?>">
                            <div class="map-wrapper map-wrapper-fixed-width">
								<?php
								if ( ! empty( $theme_options['google_map_title'] ) ) : ?>
                                    <h5><?php echo $theme_options['google_map_title']; ?></h5><?php
								endif;

								if ( isset( $theme_options[ 'google_map_api_key' ] ) && ! empty( $theme_options[ 'google_map_api_key' ] ) ) :?>
                                    <div id="map-canvas" class="default-map"></div>
									<?php
								else: ?>
                                    <p class="message bg-danger text-danger">
                                        <strong><?php esc_html_e( 'Error: ', 'framework' ); ?></strong><?php echo esc_html( $map_notification ); ?>
                                    </p>
									<?php
								endif;
								/* Contact map related JavaScript code reside in functions.php in function named generate_dynamic_javascript */ ?>
                            </div>
                        </div>
                    </div>
                </div>
				<?php
			endif;
		endif;
		?>
    </div>
<?php
if ( isset( $theme_options['display_google_map'], $theme_options['google_map_style'] ) ) :
	if ( '1' == $theme_options['display_google_map'] && '2' == $theme_options['google_map_style'] ) :
		if ( isset( $theme_options['google_map_api_key'] ) && ! empty( $theme_options['google_map_api_key'] ) ) :?>
            <div class="map-wrapper">
                <div id="map-canvas" class="full-width-map"></div>
            </div>
			<?php
		else: ?>
            <p class="message bg-danger text-danger">
                <strong><?php esc_html_e( 'Error: ', 'framework' ); ?></strong><?php echo esc_html( $map_notification ); ?>
            </p>
			<?php
		endif;
	endif;
endif;

get_footer(); ?>