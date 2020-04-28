<?php
global $theme_options;

get_header(); ?>

    <div class="default-page">
        <div class="container">
            <div class="row">
                <main id="main" class="col-lg-9 site-main">
					<?php
					if ( have_posts() ):
						while ( have_posts() ):
							the_post();
							?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> >
								<?php
								/*
								 * Display featured image
								 */
								inspiry_standard_thumbnail();
								?>
                                <div class="entry-content clearfix">
									<?php the_content(); ?>
									<?php
									wp_link_pages( array(
										'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'inspiry-yachtpress' ),
										'after'  => '</div>',
									) );
									?>
                                </div>
                                <footer class="entry-footer">
									<?php edit_post_link( esc_html__( 'Edit', 'inspiry-yachtpress' ), '<span class="edit-link">', '</span>' ); ?>
                                </footer>
                            </article>
							<?php
							// If comments are open or we have at least one comment, load up the comment template
							if ( comments_open() || '0' != get_comments_number() ) :
								comments_template();
							endif;
						endwhile;
					endif;
					?>
                </main>
                <div class="col-lg-3">
					<?php get_sidebar(); ?>
                </div>
            </div><!-- .row -->
        </div><!-- .container -->
    </div><!-- .container -->

<?php get_footer(); ?>