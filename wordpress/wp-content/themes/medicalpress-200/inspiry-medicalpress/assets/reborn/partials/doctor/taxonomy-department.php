<?php
global $theme_options;

get_header(); ?>

    <div class="default-page">
        <div class="container">
            <div class="row">
				<?php
				if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                        <div class="col-sm-6 col-lg-4">
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
				?>
            </div>
        </div>
    </div>

<?php get_footer(); ?>