<header id="site-header" class="site-header">
    <?php
	global $theme_options;

	if ( $theme_options['display_top_header'] ) : ?>
        <div class="site-header-top">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-7 col-lg-6 site-header-top-col-left">
						<?php get_template_part( INSPIRY_PARTIALS . '/header/header-opening-hours' ); ?>
                    </div>
                    <div class="col-md-5 col-lg-6 site-header-top-col-right">
						<?php inspiry_social_nav('header-social-nav', 'display_top_header_social_links'); ?>
						<?php get_template_part( INSPIRY_PARTIALS . '/header/header-search' ); ?>
                    </div>
                </div>
            </div>
        </div><!-- .site-header-top -->
		<?php
	endif;
	?>

    <div class="site-header-middle">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-4 col-lg-5 site-header-middle-col-left">
					<?php get_template_part( INSPIRY_PARTIALS . '/header/header-logo' ); ?>
                </div>
                <div class="col-md-8 col-lg-7 site-header-middle-col-right">
                    <?php get_template_part( INSPIRY_PARTIALS . '/header/header-address' ); ?>
                    <?php get_template_part( INSPIRY_PARTIALS . '/header/header-contact-number' ); ?>
                </div>
            </div>
        </div>
    </div><!-- .site-header-middle -->

    <div class="site-header-bottom">
        <div class="container clearfix">
			<?php get_template_part( INSPIRY_PARTIALS . '/header/header-menu' ); ?>
            <div id="mobile-navigation" class="mobile-navigation"></div>
	        <?php get_template_part( INSPIRY_PARTIALS . '/header/header-appointment-button' ); ?>
        </div>
    </div><!-- .site-header-bottom -->
</header><!-- .site-header -->

<?php
/*
 * Include Banner
 */
if ( ! is_page_template( array(
	'templates/home.php',
	'templates/demo-home-two.php',
	'templates/demo-home-three.php',
	'templates/demo-home-four.php',
	'templates/demo-home-five.php'
) ) ) {
	get_template_part( INSPIRY_PARTIALS . '/common/banner' );
}
?>