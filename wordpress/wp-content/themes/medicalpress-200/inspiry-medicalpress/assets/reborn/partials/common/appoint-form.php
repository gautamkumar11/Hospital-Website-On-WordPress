<?php
global $theme_options;
if ( ! empty( $theme_options['appointment_form_email'] ) ) : ?>
    <div id="appointment-modal" class="appointment-modal modal fade" tabindex="-1" role="dialog" aria-labelledby="appointment-modal" aria-hidden="true">
        <div class="modal-dialog">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <form id="appointment_modal_form" class="appointment-modal-form" action="<?php echo admin_url( 'admin-ajax.php' ); ?>" method="post">
                <?php
                if ( $theme_options['display_appointment_form'] == '1' && ! empty( $theme_options['appointment_form_title'] ) ) : ?>
                    <h4 class="appointment-title"><?php echo esc_html( $theme_options['appointment_form_title'] ); ?></h4>
                <?php
                endif;
                ?>
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="name" id="app-name" class="required" placeholder="<?php esc_attr_e( 'Name', 'framework' ); ?>" title="<?php esc_attr_e( '* Please provide your name', 'framework' ); ?>"/>
                    </div>
                    <div class="col-md-6">
                        <input type="email" name="email" id="app-email" class="required email" placeholder="<?php esc_attr_e( 'Email Address', 'framework' ); ?>" title="<?php esc_attr_e( '* Please provide a valid email address', 'framework' ); ?>"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="number" id="app-number" class="phoneNumber" placeholder="<?php esc_attr_e( 'Phone Number', 'framework' ); ?>" title="<?php esc_attr_e( '* Please provide a valid phone number.', 'framework' ); ?>"/>
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="date" id="appointment-modal-form-datepicker" class="required" placeholder="<?php esc_attr_e( 'Appointment Date', 'framework' ); ?>" title="<?php esc_attr_e( '* Please provide appointment date', 'framework' ); ?>">
                    </div>
                </div>
                <textarea name="message" id="app-message" class="required" cols="50" rows="1" placeholder="<?php esc_attr_e( 'Message', 'framework' ); ?>" title="<?php esc_attr_e( '* Please provide your message', 'framework' ); ?>"></textarea>
                <?php get_template_part(INSPIRY_COMMON . '/recaptcha/custom-recaptcha'); ?>
                <input type="submit" name="Submit" class="btn" value="<?php esc_attr_e( 'Send', 'framework' ); ?>"/>
                <img src="<?php echo INSPIRY_COMMON_DIR_URI; ?>/images/loader.gif" id="appointment-loader" alt="<?php esc_attr_e( 'Loading...', 'framework' ); ?>">
                <input type="hidden" name="action" value="make_appointment">
                <input type="hidden" name="nonce" value="<?php echo wp_create_nonce( 'request_appointment_nonce' ); ?>">
                <div id="message-sent"></div>
                <div id="error-container"></div>
            </form>
        </div><!-- .modal-dialog -->
    </div><!-- .appointment-modal -->
<?php endif; ?>