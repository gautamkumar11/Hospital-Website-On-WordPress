<?php
global $theme_options;

/* Revolution Slider */
$revolution_slider_alias = $theme_options['revolution_slider_alias'];
if( function_exists('putRevSlider') && (!empty($revolution_slider_alias)) ){
    putRevSlider( $revolution_slider_alias );
} else {
	get_template_part( INSPIRY_PARTIALS . '/common/banner' );
}

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
get_template_part( INSPIRY_PARTIALS . '/home/home-services' );

/* Doctors Section */
get_template_part( INSPIRY_PARTIALS . '/home/home-doctors' );

/* News Section */
get_template_part( INSPIRY_PARTIALS . '/home/home-blog' );

/* Testimonials Section */
get_template_part( INSPIRY_PARTIALS . '/home/home-testimonial' );