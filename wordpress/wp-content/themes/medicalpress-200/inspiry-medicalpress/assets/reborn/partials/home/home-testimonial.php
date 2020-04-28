<div class="home-section home-testimonial">
    <div class="container">
		<?php
		global $post, $theme_options;

		if ( ( $theme_options['testimonials_variation'] == '1' ) && ( ( ! empty( $theme_options['home_testimonials_title'] ) ) || ( ! empty( $theme_options['home_testimonials_description'] ) ) ) ) :
			?>
            <header class="home-section-header animated fadeInUp">
				<?php
				if ( ! empty( $theme_options['home_testimonials_title'] ) ) :
					echo '<h2 class="home-section-title">' . $theme_options['home_testimonials_title'] . '</h2>';
				endif;

				if ( ! empty( $theme_options['home_testimonials_description'] ) ) :
					echo '<p class="home-section-description">' . $theme_options['home_testimonials_description'] . '</p>';
				endif;
				?>
            </header>
			<?php
		endif;
		?>
        <div class="testimonials-carousel owl-carousel owl-theme animated fadeInUp">
			<?php
			$testimonials_per_page = isset( $theme_options['home_testimonials_per_page'] ) ? intval( $theme_options['home_testimonials_per_page'] ) : 2;
			$testimonial_args = array(
				'post_type'      => 'testimonial',
				'posts_per_page' => $testimonials_per_page,
			);

			// The Query
			$testimonial_query = new WP_Query( $testimonial_args );

			// The Loop
			if ( $testimonial_query->have_posts() ) :
				while ( $testimonial_query->have_posts() ) :
					$testimonial_query->the_post();
					$testimonial_author_name         = get_post_meta( $post->ID, 'testimonial_author', true );
					$testimonial_author_link         = get_post_meta( $post->ID, 'testimonial_author_link', true );
					$testimonial_author_organization = get_post_meta( $post->ID, 'testimonial_author_organization', true );
					?>
                    <div class="testimonials-carousel-item">
                        <header class="testimonials-carousel-item-header">
							<?php the_title( '<h3 class="testimonials-carousel-item-title">', '</h3>' ); ?>
                            <p class="testimonials-carousel-item-text"><?php echo get_post_meta( $post->ID, 'the_testimonial', true ); ?></p>
                        </header>
                        <footer class="testimonials-carousel-item-footer clearfix">
							<?php
							if ( has_post_thumbnail() ) :
								the_post_thumbnail( 'testimonial-thumb', array( 'class' => "testimonial-author-photo" ) );
							endif;
							?>
                            <div class="testimonial-author-content">
                                <h3 class="testimonial-author-name"><?php echo $testimonial_author_name; ?></h3>
	                            <?php
	                            if ( ! empty( $testimonial_author_link ) && ! empty( $testimonial_author_organization ) ) : ?>
                                    <a class="testimonial-author-link" href="<?php echo $testimonial_author_link; ?>" target="_blank">
			                            <?php echo $testimonial_author_organization; ?>
                                    </a>
		                            <?php
	                            endif;
	                            ?>
                            </div>
                        </footer>
                    </div><?php
				endwhile;
			else :
				echo '<p>';
				esc_html_e( 'No testimonial found !', 'framework' );
				echo '</p>';
			endif;

			/* Restore original Post Data */
			wp_reset_postdata();
			?>
        </div>
    </div>
</div>