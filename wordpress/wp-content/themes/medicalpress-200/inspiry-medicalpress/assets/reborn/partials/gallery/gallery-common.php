<?php
global $theme_options;

get_header(); ?>

<div class="gallery-page">
    <div class="filters-wrapper">
        <div class="container">
			<?php inspiry_filters( 'gallery-item-type', __( 'All', 'framework' ) ); ?>
        </div>
    </div><!-- .filter-wrapper -->

	<?php get_template_part( INSPIRY_PARTIALS . '/common/page-content' ); ?>

    <div class="container">
        <div id="isotope-container" class="isotope-container row">
			<?php
			$column_classes = 'isotope-item col-12';

			if ( is_page_template( 'templates/gallery-four-col.php' ) ) {

				$column_classes .= ' col-lg-3';

			} else if ( is_page_template( 'templates/gallery-three-col.php' ) ) {

				$column_classes .= ' col-lg-4';

			} else if ( is_page_template( 'templates/gallery-two-col.php' ) ) {

				$column_classes .= ' col-md-6';

			} else {

				$column_classes .= ' gallery-item-one-column';

			}

			$gallery_args = array(
				'post_type'      => 'gallery-item',
				'posts_per_page' => -1,
			);

			// The Query
			$gallery_query = new WP_Query( $gallery_args );

			// The Loop
			if ( $gallery_query->have_posts() ) :

				while ( $gallery_query->have_posts() ) :

					$gallery_query->the_post();

					/* Department terms slug needed to be used as classes in html for isotope functionality */
					$term_slug = '';
					$terms     = get_the_terms( $post->ID, 'gallery-item-type' );

					if ( ! empty( $terms ) ) {
						foreach ( $terms as $term ) {
							$term_slug .= ' ' . $term->slug;
						}
					}
					?>
                    <div class="<?php echo esc_attr( $column_classes . $term_slug ); ?>">
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
					<?php
				endwhile;

			else :
				nothing_found( __( 'No doctor found !', 'framework' ) );
			endif;

			/* Restore original Post Data */
			wp_reset_postdata();
			?>
        </div><!-- .isotope-container -->
    </div><!-- .container -->
</div>
<?php get_footer(); ?>
