<?php

get_header(); ?>

    <div class="blog-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-xl-9">
                    <div class="blog-post-listing">
	                    <?php
	                    /* Main loop */
	                    if ( have_posts() ) :

		                    while ( have_posts() ) :

			                    the_post();

                                get_template_part( INSPIRY_PARTIALS . '/blog/post/blog-post' );

		                    endwhile;

		                    global $wp_query;

		                    inspiry_pagination( $wp_query );
	                    else :
		                    nothing_found( __( 'No Post Found!', 'framework' ) );
	                    endif;
	                    ?>
                    </div>
                </div>
                <div class="col-lg-4 col-xl-3">
                    <?php get_sidebar(); ?>
                </div>
            </div>
        </div>
    </div>

<?php get_footer(); ?>