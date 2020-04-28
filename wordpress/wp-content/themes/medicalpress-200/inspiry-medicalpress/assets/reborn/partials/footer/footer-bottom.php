<div class="site-footer-bottom">
    <div class="container">
        <div class="row">
            <div class="col-md-7 site-footer-bottom-left-col">
                <nav id="footer-navigation" class="footer-navigation">
		            <?php
		            wp_nav_menu( array(
			            'theme_location' => 'footer-menu',
			            'container'      => false,
			            'menu_class'     => 'footer-menu clearfix'
		            ) );
		            ?>
                </nav>

	            <?php
	            global $theme_options;

	            $site_info = sprintf( __( 'Copyright %d. All Rights Reserved by %s', 'framework' ), date( 'Y' ), get_bloginfo( 'name' ) );

	            if ( ! empty( $theme_options['footer_copyright'] ) ) {
		            $site_info = $theme_options['footer_copyright'];
	            }
	            ?>
                <div class="site-info">
                    <p><?php echo $site_info; ?></p>
                </div><!-- .site-info -->
            </div>
            <div class="col-md-5 site-footer-bottom-right-col">
                <?php if ( isset( $theme_options['display_footer_social_icons'] ) && '1' == $theme_options['display_footer_social_icons'] ) : ?>
                    <div class="footer-social-nav-wrapper">
                        <?php if ( inspiry_get_option( 'footer_social_nav_title' ) ) : ?>
                            <h4 class="footer-social-nav-title"><?php echo inspiry_get_option( 'footer_social_nav_title' ); ?></h4>
                        <?php endif; ?>
                        <?php inspiry_social_nav( 'footer-social-nav', 'display_footer_social_icons'); ?>
                    </div><!-- .footer-social-nav-wrapper -->
                <?php endif; ?>
            </div>
        </div>
    </div>
</div><!-- .site-footer-bottom -->