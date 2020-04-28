<?php
global $theme_options;

// force to show slider
get_template_part( INSPIRY_PARTIALS . '/home/home-slider' );

/* Home page contents from page editor */
if ( have_posts() ) :
	while ( have_posts() ):
		the_post();
		$content = get_the_content();
		if ( ! empty( $content ) ) : ?>
            <div class="home-contents">
                <div class="container">
                    <article <?php post_class(); ?>>
                        <div class="entry-content"><?php the_content(); ?></div>
                    </article>
                </div>
            </div>
		<?php
		endif;
	endwhile;
endif;

/* Home Features */
get_template_part( INSPIRY_PARTIALS . '/home/home-features' );


/* Services Section */
$theme_options['service_item_thumb'] = '1';
$theme_options['display_show_all_services_button'] = '';
get_template_part( INSPIRY_PARTIALS . '/home/home-services' );

/* Doctors Section */
get_template_part( INSPIRY_PARTIALS . '/home/home-doctors' );

/* News Section */
$theme_options['home_news_per_page'] = '3';
get_template_part( INSPIRY_PARTIALS . '/home/home-blog' );

/* Testimonials Section */
get_template_part( INSPIRY_PARTIALS . '/home/home-testimonial' );