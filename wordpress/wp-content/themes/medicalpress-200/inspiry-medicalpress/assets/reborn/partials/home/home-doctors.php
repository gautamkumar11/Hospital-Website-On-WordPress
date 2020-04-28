<div class="home-section home-doctors">
    <div class="container">
		<?php
		global $theme_options;

		if ( ( ! empty( $theme_options['home_doctors_title'] ) ) || ( ! empty( $theme_options['home_doctors_description'] ) ) ) : ?>
            <header class="home-section-header animated fadeInUp">
				<?php
				if ( ! empty( $theme_options['home_doctors_title'] ) ) :
					echo '<h2 class="home-section-title">' . $theme_options['home_doctors_title'] . '</h2>';
				endif;

				if ( ! empty( $theme_options['home_doctors_description'] ) ) :
					echo '<p class="home-section-description">' . $theme_options['home_doctors_description'] . '</p>';
				endif;
				?>
            </header>
		<?php endif; ?>
        <div class="row">
			<?php
			$number_of_doctors = 4;
			if ( ! empty( $theme_options['reborn_home_doctors_count'] ) ) {
				$number_of_doctors = intval( $theme_options['reborn_home_doctors_count'] );
			}

			$classes = 'col-sm-6';

			if( $number_of_doctors == 3){
				$classes .= ' col-lg-4';
            }elseif( $number_of_doctors > 3){
				$classes .= ' col-lg-3';
            }

			$doctor_args = array(
				'post_type'      => 'doctor',
				'posts_per_page' => $number_of_doctors,
			);

			$inspiry_sort_doctors = apply_filters( 'inspiry_sort_doctors', $doctor_args );

			// The Query
			$doctor_query = new WP_Query( $inspiry_sort_doctors );

			// The Loop
			if ( $doctor_query->have_posts() ) :

				while ( $doctor_query->have_posts() ) :

					$doctor_query->the_post();

					/* Department terms slug needed to be used as classes in html for isotope functionality */
					$term_slug = '';
					$terms     = get_the_terms( $post->ID, 'department' );

					if ( ! empty( $terms ) ) {

						foreach ( $terms as $term ) {
							$term_slug .= ' ' . $term->slug;
						}
					}
					?>
                    <div class="<?php echo esc_attr( $classes . $term_slug ); ?>">
                        <article class="doctor-common doctor-grid doctor-grid-one hentry">
							<?php inspiry_standard_thumbnail( 'doctor-grid-thumb' ); ?>
                            <div class="entry-content">
                                <h3 class="entry-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
								<?php get_template_part( INSPIRY_PARTIALS . '/doctor/doctors-department' ); ?>
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
        </div>
	    <?php
	    if ( '1' == $theme_options['display_show_all_doctor_button'] ) : ?>
            <div class="text-center btn-wrapper">
                <a class="btn btn-primary" href="<?php echo esc_url( $theme_options['show_all_doctor_button_link'] ); ?>"><?php echo esc_html( $theme_options['show_all_doctor_button_text'] ); ?></a>
            </div>
	    <?php endif; ?>
    </div>
</div>