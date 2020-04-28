<div class="home-section home-services">
    <div class="container">
		<?php
		global $theme_options;
		if ( ( ! empty( $theme_options['home_services_title'] ) ) || ( ! empty( $theme_options['home_services_description'] ) ) ) :
			?>
            <header class="home-section-header animated fadeInUp">
				<?php
				if ( ! empty( $theme_options['home_services_title'] ) ) :
					echo '<h2 class="home-section-title">' . $theme_options['home_services_title'] . '</h2>';
				endif;

				if ( ! empty( $theme_options['home_services_description'] ) ) :
					echo '<p class="home-section-description">' . $theme_options['home_services_description'] . '</p>';
				endif;
				?>
            </header>
			<?php
		endif;

		$post_excerpt       = 12;
		$post_classes       = 'services-item';
		$column_classes     = 'col-12 col-md-6 col-lg-4';
		$services_items     = isset( $theme_options['home_total_services'] ) ? intval( $theme_options['home_total_services'] ) : 3;
		$service_item_thumb = ( isset( $theme_options['service_item_thumb'] ) && '1' == $theme_options['service_item_thumb'] ) ? 'featured' : 'icon';

		$services_args = array(
			'post_type'      => 'service',
			'posts_per_page' => $services_items
		);

		// The Query
		$services_query = new WP_Query( $services_args );

		// The Loop
		if ( $services_query->have_posts() ) : ?>
            <div class="row">
				<?php
				while ( $services_query->have_posts() ) : $services_query->the_post();

					$services_icon_url = '';
					$post_classes      .= " services-item-$service_item_thumb";

					if ( 'icon' == $service_item_thumb ) {

						$services_icon = get_post_custom();

						if ( isset( $services_icon['MEDICAL_META_service_icon'][0] ) ) {
							$services_icon_url = wp_get_attachment_url( $services_icon['MEDICAL_META_service_icon'][0] );
						}
					}
					?>
                    <div class="<?php echo esc_attr( $column_classes ); ?>">
                        <article <?php post_class( $post_classes ) ?>>
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
				<?php endwhile; ?>
            </div>
			<?php
		else :
			nothing_found( __( 'No Service found !', 'framework' ) );
		endif;

		/* Restore original Post Data */
		wp_reset_postdata();
		?>
    </div>
	<?php
	if ( '1' == $theme_options['display_show_all_services_button'] ) : ?>
        <div class="text-center btn-wrapper">
            <a class="btn btn-primary" href="<?php echo esc_url( $theme_options['show_all_services_button_link'] ); ?>"></a>
        </div>
	<?php endif; ?>
</div>