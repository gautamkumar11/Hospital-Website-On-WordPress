<?php
global $theme_options;

/* Slider */
if ( $theme_options['display_slider_on_home'] == '1' ) {
	if ( $theme_options['slider_type'] == '2' ) {
		$revolution_slider_alias = $theme_options['revolution_slider_alias'];
		if ( function_exists( 'putRevSlider' ) && ( ! empty( $revolution_slider_alias ) ) ) {
			putRevSlider( $revolution_slider_alias );
		} else {
			get_template_part( INSPIRY_PARTIALS . '/common/banner' );
		}
	} else {
		get_template_part( INSPIRY_PARTIALS . '/home/home-slider' );
	}
} else {
	get_template_part( INSPIRY_PARTIALS . '/common/banner' );
}

/* Homepage Layout Manager */
$enabled_sections = $theme_options['home_sections']['enabled'];

if ( $enabled_sections ) {

	foreach ( $enabled_sections as $key => $val ) {

		switch ( $key ) {

			/* Home page contents from page editor */
			case 'content':
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
				break;

			/* Features Section */
			case 'features':
				get_template_part( INSPIRY_PARTIALS . '/home/home-features' );
				break;

			/* Doctors Section */
			case 'doctors':
				get_template_part( INSPIRY_PARTIALS . '/home/home-doctors' );
				break;

			/* Services Section */
			case 'services':
				get_template_part( INSPIRY_PARTIALS . '/home/home-services' );
				break;

			/* News Section */
			case 'news':
				get_template_part( INSPIRY_PARTIALS . '/home/home-blog' );
				break;

			/* Testimonials Section */
			case 'testimonials':
				get_template_part( INSPIRY_PARTIALS . '/home/home-testimonial' );
				break;
		}
	}
}