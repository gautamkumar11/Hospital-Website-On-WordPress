<div class="home-section home-blog">
    <div class="container">
		<?php
		global $theme_options;

		if ( ! empty( $theme_options['home_news_title'] ) || ! empty( $theme_options['home_news_description'] ) ) : ?>
            <header class="home-section-header animated fadeInUp">
				<?php
				if ( ! empty( $theme_options['home_news_title'] ) ) :
					echo '<h2 class="home-section-title">' . $theme_options['home_news_title'] . '</h2>';
				endif;

				if ( ! empty( $theme_options['home_news_description'] ) ) :
					echo '<p class="home-section-description">' . $theme_options['home_news_description'] . '</p>';
				endif;
				?>
            </header>
			<?php
		endif;

		$posts_per_page = isset( $theme_options['home_news_per_page'] ) ? intval( $theme_options['home_news_per_page'] ) : 5;

		$home_blog_args = array(
			'post_type'           => 'post',
			'posts_per_page'      => $posts_per_page,
			'ignore_sticky_posts' => 1,
			'tax_query'           => array(
				array(
					'taxonomy' => 'post_format',
					'field'    => 'slug',
					'terms'    => array( 'post-format-quote', 'post-format-link', 'post-format-audio' ),
					'operator' => 'NOT IN'
				)
			),
			'meta_query'          => array(
				array(
					'key'     => '_thumbnail_id',
					'compare' => 'EXISTS'
				)
			)
		);

		// The Query
		$home_blog_query = new WP_Query( $home_blog_args );
		$found_posts     = $home_blog_query->post_count;
		$column_class    = 'col-md-6';

		if ( 3 == $found_posts ) {
			$column_class .= ' col-lg-4';
		} elseif ( 4 == $found_posts ) {
			$column_class .= ' col-lg-3';
		}

		// The Loop
		if ( $home_blog_query->have_posts() ) :
			$counter = 1;
			?>
            <div class="row">
				<?php
				while ( $home_blog_query->have_posts() ) : $home_blog_query->the_post();
					if ( 4 >= $found_posts ) : ?>
                        <div class="<?php echo esc_attr( $column_class ); ?> col-large-post">
                            <article <?php post_class( 'clearfix' ); ?>>
								<?php inspiry_standard_thumbnail( 'common-grid-thumb' ); ?>
                                <div class="entry-content-wrapper">
                                    <h4 class="entry-title text-truncate">
                                        <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
                                    </h4>
                                    <p><?php inspiry_excerpt( 26, '' ); ?></p>
                                </div>
                            </article><!-- .hentry -->
                        </div>
					<?php else : ?>
						<?php if ( 1 == $counter ) : ?>
                            <div class="<?php //echo esc_attr( $column_class ); ?>col-lg-6 col-large-post">
                                <article <?php post_class( 'clearfix' ); ?>>
									<?php inspiry_standard_thumbnail( 'common-grid-thumb' ); ?>
                                    <div class="entry-content-wrapper">
                                        <h4 class="entry-title">
                                            <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
                                        </h4>
                                        <p><?php inspiry_excerpt( 16, '' ); ?></p>
                                    </div>
                                </article><!-- .hentry -->
                            </div>
						<?php
						else :
							if ( 2 == $counter ) {
								echo '<div class="col-lg-6 col-small-post"><div class="row">';
							}
							?>
                            <div class="<?php echo esc_attr( $column_class ); ?>">
                                <article <?php post_class( 'clearfix' ); ?>>
									<?php inspiry_standard_thumbnail( 'common-grid-thumb' ); ?>
                                    <div class="entry-content-wrapper">
                                        <h4 class="entry-title">
                                            <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
                                        </h4>
                                    </div>
                                </article><!-- .hentry -->
                            </div>
							<?php
							if ( 3 == $counter ) {
								echo '</div><div class="row">';
							}

							if ( 5 == $counter ) {
								echo '</div></div>';
							}
						endif;
					endif;
					$counter ++;
				endwhile;
				?>
            </div>
			<?php
			wp_reset_postdata();
		else :
			nothing_found( __( 'No post found !', 'framework' ) );
		endif;
		?>
    </div>
</div>