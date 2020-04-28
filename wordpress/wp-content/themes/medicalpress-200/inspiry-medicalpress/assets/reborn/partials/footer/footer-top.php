<?php
if ( is_active_sidebar( 'footer-1st-column' ) || is_active_sidebar( 'footer-2nd-column' ) ||  is_active_sidebar( 'footer-3rd-column' ) ||  is_active_sidebar( 'footer-4th-column' )  ) : ?>
    <div class="site-footer-top footer-widgets-area">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-3">
					<?php dynamic_sidebar( 'footer-1st-column' ); ?>
                </div>

                <div class="col-md-6 col-lg-3">
					<?php dynamic_sidebar( 'footer-2nd-column' ); ?>
                </div>

                <div class="clearfix visible-sm"></div>

                <div class="col-md-6 col-lg-3">
					<?php dynamic_sidebar( 'footer-3rd-column' ); ?>
                </div>

                <div class="col-md-6 col-lg-3">
		            <?php dynamic_sidebar( 'footer-4th-column' ); ?>
                </div>
            </div>
        </div>
    </div><!-- .site-footer-top -->
    <?php
endif;