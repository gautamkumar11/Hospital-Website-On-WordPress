<?php
if ( have_posts() ):

	while ( have_posts() ):

		the_post();

		$content = get_the_content();

		if ( has_post_thumbnail() || ! empty( $content ) ) : ?>
            <div class="page-content-wrapper">
                <div id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?>>
                    <?php
                    if ( ! is_home() || ! is_front_page() ) {

                        /*
                         * Display featured image
                         */
                        inspiry_standard_thumbnail();
                    }

                    if ( ! empty( $content ) ) : ?>
                        <div class="entry-content clearfix">
                            <?php the_content(); ?>
                        </div>
                        <?php
                    endif;
                    ?>
                </div>
            </div><!-- .page-content-wrapper -->
			<?php
		endif;
	endwhile;
endif;