<?php get_header(); ?>

    <div class="page-top clearfix">
        <div class="container">
            <div class="row">
                <div class="<?php bc_all( '12' ); ?>">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    <nav class="bread-crumb">
						<?php theme_breadcrumb(); ?>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="services-page clearfix">
        <div class="container">
            <div class="row">
                <div class="<?php bc_all( '12' ); ?>">
					<?php
					if ( have_posts() ):
						while ( have_posts() ):
							the_post();
							?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class( ' clearfix' ); ?>>
                                <div class="entry-content">
									<?php
									/* output page contents */
									the_content();
									?>
                                </div>
                            </article>
							<?php
						endwhile;
					endif;
					?>
                </div>
            </div>
	        <?php
	        global $theme_options, $services_query;

	        if ( is_page_template( 'templates/services-four-col.php' ) ) {

		        get_template_part( INSPIRY_PARTIALS . '/services/services-four-col' );

	        } else if ( is_page_template( 'templates/services-three-col.php' ) ) {

		        get_template_part( INSPIRY_PARTIALS . '/services/services-three-col' );

	        } else if ( is_page_template( 'templates/services-two-col.php' ) ) {

		        get_template_part( INSPIRY_PARTIALS . '/services/services-two-col' );

	        }else{

		        get_template_part( INSPIRY_PARTIALS . '/services/services-one-col' );

	        }

	        if ( isset( $theme_options['display_services_pagination'] ) ) {
	        	if ( '1' == $theme_options['display_services_pagination'] ) {
	        		inspiry_pagination( $services_query );
	        	}
	        }

	        //* Restore original Post Data */
	        wp_reset_postdata();
	        ?>
        </div>
    </div>

<?php get_footer(); ?>