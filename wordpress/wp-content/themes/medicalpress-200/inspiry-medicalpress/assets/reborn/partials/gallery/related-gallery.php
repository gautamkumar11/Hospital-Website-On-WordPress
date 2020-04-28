<?php
global $post;
global $theme_options;

// Main gallery-item-types terms
$item_type_terms = get_the_terms( $post->ID, "gallery-item-type" );

if ( $item_type_terms && ! is_wp_error( $item_type_terms ) ) {

	$gallery_item_types_array = array();
	foreach ( $item_type_terms as $single_term ) {
		$gallery_item_types_array[] = $single_term->term_id;
	}

	if ( 0 < count( $gallery_item_types_array ) ) {

		$related_items_args = array(
			'post_type'      => 'gallery-item',
			'posts_per_page' => 4,
			'post__not_in'   => array( $post->ID ),
			'orderby'        => 'rand',
			'tax_query'      => array(
				array(
					'taxonomy' => 'gallery-item-type',
					'field'    => 'id',
					'terms'    => $gallery_item_types_array,
				),
			),
		);

		// Related items query
		$related_items_query = new WP_Query( $related_items_args );

		if ( $related_items_query->have_posts() ) {
            ?>
            <div class="related-gallery-items container">
                <?php
                if ( ( ! empty( $theme_options['related_doctors_title'] ) ) || ( ! empty( $theme_options['related_doctors_description'] ) ) ) : ?>
                    <header class="home-section-header">
                        <?php
                        if ( ! empty( $theme_options['related_gallery_items_title'] ) ) :
                            echo '<h2 class="home-section-title">' . $theme_options['related_gallery_items_title'] . '</h2>';
                        endif;

                        if ( ! empty( $theme_options['related_gallery_items_description'] ) ) :
                            echo '<p class="home-section-description">' . $theme_options['related_gallery_items_description'] . '</p>';
                        endif;
                        ?>
                    </header>
                <?php endif; ?>
                <div class="row">
					<?php
					$post_classes   = 'gallery-common gallery-grid gallery-grid-one';
					while ( $related_items_query->have_posts() ) {
						$related_items_query->the_post();
						$gallery_terms = get_the_terms( $post->ID, 'gallery-item-type' );
						?>
                        <div class="<?php bc( '3', '4', '6', '' ); ?>">
                            <article <?php post_class( $post_classes ) ?>>
	                            <?php if ( has_post_thumbnail( get_the_ID() ) ) : ?>
                                    <figure>
                                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				                            <?php the_post_thumbnail( 'common-grid-thumb' ); ?>
                                        </a>
                                    </figure>
	                            <?php endif; ?>
                                <div class="entry-content">
                                    <h4 class="entry-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h4>
									<?php get_template_part( INSPIRY_PARTIALS . '/gallery/gallery-types' ); ?>
                                </div>
                            </article>
                        </div>
						<?php
					}

					wp_reset_postdata();
					?>
                </div>
            </div>
			<?php
		}
	}
}
?>