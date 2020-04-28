<?php
global $theme_options;

get_header(); ?>

    <div class="default-page">
        <div class="container">
            <div class="row">
		        <?php
		        if (have_posts()) {
			        while (have_posts()) {
				        the_post();
				        ?>
                        <div class="col-md-6 col-lg-4">
                            <article <?php post_class( 'gallery-common gallery-grid gallery-grid-one' ) ?>>
						        <?php
						        if ( has_post_thumbnail( $post->ID ) ) {
							        $image_id       = get_post_thumbnail_id();
							        $full_image_url = wp_get_attachment_url( $image_id );
							        ?>
                                    <figure class="overlay-effect">
								        <?php the_post_thumbnail( 'common-grid-thumb' ); ?>
                                        <a class="overlay" href="<?php echo $full_image_url; ?>">
                                            <i class="top"></i> <i class="bottom"></i>
                                        </a>
                                    </figure>
							        <?php
						        }
						        ?>
                                <div class="entry-content">
                                    <h3 class="entry-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
							        <?php get_template_part( INSPIRY_PARTIALS . '/gallery/gallery-types' ); ?>
                                </div>
                            </article>
                        </div>
			        <?php }
		        } else {
			        nothing_found(__('No gallery item found!','framework'));
		        }
		        ?>
            </div>
        </div><!-- .container -->
    </div>

<?php get_footer(); ?>