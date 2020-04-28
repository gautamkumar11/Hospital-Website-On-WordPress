<?php
global $theme_options;

get_header(); ?>

<div class="appoint-page">
    <div class="container">
	    <?php get_template_part( INSPIRY_PARTIALS . '/common/page-content' ); ?>

        <div class="appoint-section clearfix">

            <div class="top-icon">
                <img src="<?php echo INSPIRY_ASSETS_DIR_URI; ?>/images/appoint-form-top.png" alt=""/>
            </div>

            <form id="appointment_form_main" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post">

                <div class="row">
                    <div class="<?php bc('6','6','12',''); ?>">
                        <input type="text" name="name" id="app-name" class="required" placeholder="<?php _e('Name', 'framework'); ?>" title="<?php _e('* Please provide your name', 'framework'); ?>"/>
                    </div>
                    <div class="<?php bc('6','6','12',''); ?>">
                        <input type="text" name="number" id="app-number" class="phoneNumber" placeholder="<?php _e('Phone Number', 'framework'); ?>" title="<?php _e('* Please provide a valid phone number.', 'framework'); ?>"/>
                    </div>
                </div>

                <div class="row">
                    <div class="<?php bc('6','6','12',''); ?>">
                        <input type="email" name="email" id="app-email" class="required email" placeholder="<?php _e('Email Address', 'framework'); ?>" title="<?php _e('* Please provide a valid email address', 'framework'); ?>"/>
                    </div>
                    <div class="<?php bc('6','6','12',''); ?>">
                        <input type="text" name="date" id="datepicker" class="required" placeholder="<?php _e('Appointment Date', 'framework'); ?>"/  title="<?php _e('* Please provide appointment date', 'framework'); ?>">
                    </div>
                </div>

                <textarea name="message" id="app-message" class="required" cols="50" rows="1" placeholder="<?php _e('Message', 'framework'); ?>" title="<?php _e('* Please provide your message', 'framework'); ?>"></textarea>
                <input type="hidden" name="action" value="make_appointment">
                <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('request_appointment_nonce'); ?>" />

                <?php get_template_part(INSPIRY_COMMON . '/recaptcha/custom-recaptcha'); ?>

                <div class="row">
                    <div class="col-sm-12">
                        <input type="submit" name="Submit" class="btn btn-primary" value="<?php _e('Submit Request', 'framework'); ?>"/>
                        <img src="<?php echo INSPIRY_COMMON_DIR_URI; ?>/images/loader.gif" id="appointment-loader" alt="<?php _e('Loading...', 'framework'); ?>">
                    </div>
                    <div class="col-sm-12">
                        <div id="message-sent"></div>
                        <div id="error-container"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php get_footer(); ?>
