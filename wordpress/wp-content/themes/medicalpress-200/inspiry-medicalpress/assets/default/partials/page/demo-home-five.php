<?php
global $theme_options;

/* Revolution Slider */
$revolution_slider_alias = $theme_options['revolution_slider_alias'];
if( function_exists('putRevSlider') && (!empty($revolution_slider_alias)) ){
    putRevSlider( $revolution_slider_alias );
} else {
	get_template_part( INSPIRY_PARTIALS . '/common/banner' );
}

// show appointment form variation two
get_template_part( INSPIRY_PARTIALS . '/common/appoint-form' );

    /* Home page contents from page editor */
    if (have_posts()):
        while (have_posts()):
            the_post();
            $content = get_the_content();
            if (!empty($content)) {
                ?>
                <div class="default-contents">
                    <div class="container">
                        <div class="row">
                            <div class="<?php bc_all('12'); ?>">
                                <article <?php post_class(); ?>>
                                    <div class="entry-content">
                                        <?php
                                        /* output page contents */
                                        the_content();
                                        ?>
                                    </div>
                                </article>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
        endwhile;
    endif;

/* Home Features */
get_template_part( INSPIRY_PARTIALS . '/home/home-features-one' );

/* Doctors Section */
get_template_part( INSPIRY_PARTIALS . '/home/home-doctors' );

/* Services Section */
get_template_part( INSPIRY_PARTIALS . '/home/home-services' );

/* News Section */
get_template_part( INSPIRY_PARTIALS . '/home/home-blog' );

/* Testimonials Section */
get_template_part( INSPIRY_PARTIALS . '/home/home-testimonial' );