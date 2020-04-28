<?php
global $paged, $theme_options, $services_args;

get_header(); ?>

    <div class="services-page">
        <div class="container">
			<?php
			get_template_part( INSPIRY_PARTIALS . '/common/page-content' );

			$service_item_thumb = ( isset( $theme_options['service_page_item_thumb'] ) && '1' == $theme_options['service_page_item_thumb'] ) ? 'featured' : 'icon';
			$post_classes       = 'services-item';
			$column_classes     = 'col-12';
			$post_excerpt       = 13;
			$services_items     = - 1;
			$single_column      = false;

			if ( isset( $theme_options['display_services_pagination'] ) ) {

				if ( '1' == $theme_options['display_services_pagination'] ) {

					if ( is_front_page() ) {
						$services_args['paged'] = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
					}
				}
			}

			if ( is_page_template( 'templates/services-four-col.php' ) ) {

				$services_items = 8;
				$column_classes .= ' col-lg-3';

			} else if ( is_page_template( 'templates/services-three-col.php' ) ) {

				$services_items = 6;
				$column_classes .= ' col-lg-4';

			} else if ( is_page_template( 'templates/services-two-col.php' ) ) {

				$services_items = 4;
				$column_classes .= ' col-md-6';

			} else {

				$single_column  = true;
				$post_excerpt   = 35;
				$column_classes .= ' col-md-6 services-item-one-column';

			}

			$services_args = array(
				'post_type'      => 'service',
				'posts_per_page' => $services_items
			);

			// The Query
			$services_query = new WP_Query( $services_args );

			// The Loop
			if ( $services_query->have_posts() ) :
				?>
                <div class="row">
					<?php
					while ( $services_query->have_posts() ) :
						$services_query->the_post();

						if ( ! $single_column ){
							$post_classes .= " services-item-$service_item_thumb";
                        }

						$services_icon_url = '';

						if ( 'icon' == $service_item_thumb ) {

							$services_icon = get_post_custom();

							if ( isset( $services_icon['MEDICAL_META_service_icon'][0] ) ) {
								$services_icon_url = wp_get_attachment_url( $services_icon['MEDICAL_META_service_icon'][0] );
							}
						}
					    ?>
                        <div class="<?php echo esc_attr( $column_classes ); ?>">
                            <article <?php post_class( $post_classes ) ?>>
	                            <?php if ( $single_column ):
		                            inspiry_standard_thumbnail( 'common-grid-thumb' );
	                            else :
		                            ?>
                                    <div class="services-item-thumb-wrapper">
			                            <?php
			                            if ( 'featured' == $service_item_thumb ) : ?>
                                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
					                            <?php the_post_thumbnail( 'common-grid-thumb' ); ?>
                                            </a>
				                            <?php
                                        elseif ( ! empty( $services_icon_url ) ) : ?>
                                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                                <img src="<?php echo esc_url( $services_icon_url ); ?>" alt="<?php the_title(); ?>">
                                            </a>
				                            <?php
			                            endif;
			                            ?>
                                    </div>
		                            <?php
	                            endif;
	                            ?>
                                <div class="services-item-content-wrap">
                                    <h3 class="services-item-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    <div class="services-item-content">
                                        <p><?php inspiry_excerpt( $post_excerpt, '' ); ?></p>
                                    </div>
                                </div>
                            </article>
                        </div>
						<?php
					endwhile; ?>
                </div><!-- .row -->
				<?php
			else :
				nothing_found( __( 'No Service found !', 'framework' ) );
			endif;

			if ( isset( $theme_options['display_services_pagination'] ) ) {
				if ( '1' == $theme_options['display_services_pagination'] ) {
					inspiry_pagination( $services_query );
				}
			}

			/* Restore original Post Data */
			wp_reset_postdata();
			?>
        </div><!-- .container -->
    </div><!-- .services-page -->

<?php get_footer(); ?>