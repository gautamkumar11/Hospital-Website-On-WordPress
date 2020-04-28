<?php
/*
 *  Template Name: Demo - Home Variation Four
 */

global $theme_options;

/* Include Header */
get_header();

/* Slider */

// force to show appointment form variation 1
$theme_options['appointment_form_variation'] = '1';

// show slider
get_template_part( INSPIRY_PARTIALS . '/home/home-slider' );

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
                        <div class="<?php bc_all( '12' ); ?>">
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

// force to show 2nd variation for features
get_template_part( INSPIRY_PARTIALS . '/home/home-features-two' );

// force to show 2nd variations for doctors
$theme_options['doctors_variation'] = '1';
get_template_part( INSPIRY_PARTIALS . '/home/home-doctors' );

// force to show services
get_template_part( INSPIRY_PARTIALS . '/home/home-services' );

// force to show variation 2
$theme_options['news_variation'] = '2';
get_template_part( INSPIRY_PARTIALS . '/home/home-blog' );

// force to show variation 2
$theme_options['testimonials_variation'] = '1';
get_template_part( INSPIRY_PARTIALS . '/home/home-testimonial' );


/* Include Footer */
get_footer();