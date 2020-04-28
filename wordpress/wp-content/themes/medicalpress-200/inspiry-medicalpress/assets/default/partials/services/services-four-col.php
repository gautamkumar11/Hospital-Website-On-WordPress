<div class="row">
	<?php
	global $paged, $theme_options, $services_args, $services_query;

	$services_args = array(
		'post_type'      => 'service',
		'posts_per_page' => -1
	);

	if ( isset( $theme_options['display_services_pagination'] ) ) {
		if ( '1' == $theme_options['display_services_pagination'] ) {

			if ( is_front_page() ) {
				$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
			}

			$services_args = array(
				'post_type'      => 'service',
				'posts_per_page' => 8,
				'paged'          => $paged
			);
		}
	}

	// The Query
	$services_query = new WP_Query( $services_args );

	// The Loop
	if ( $services_query->have_posts() ) {
		$loop_counter = 0;
		while ( $services_query->have_posts() ) {
			$services_query->the_post();
			?>
            <div class="<?php bc( '3', '4', '6', '' ); ?>">
                <article <?php post_class( 'four-col-service' ) ?>>
					<?php inspiry_standard_thumbnail( 'service-gallery-thumb' ) ?>
                    <div class="contents clearfix">
                        <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                        <div class="entry-content">
                            <p><?php inspiry_excerpt(15); ?></p>
                        </div>
                        <a class="read-more" href="<?php the_permalink(); ?>"><?php _e('Read More', 'framework'); ?></a>
                    </div>
                </article>
            </div>
			<?php
			$loop_counter ++;
			if ( ( $loop_counter % 4 ) == 0 ) {
				?>
                <div class="visible-lg clearfix"></div>
				<?php
			} else if ( ( $loop_counter % 3 ) == 0 ) {
				?>
                <div class="visible-md clearfix"></div>
				<?php
			} else if ( ( $loop_counter % 2 ) == 0 ) {
				?>
                <div class="visible-sm clearfix"></div>
				<?php
			}
		}
	} else {
		nothing_found( __( 'No Service found !', 'framework' ) );
	}
	?>
</div>