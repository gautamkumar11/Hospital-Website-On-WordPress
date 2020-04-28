<?php
global $theme_options;

get_header(); ?>

    <div class="doctors-single-page">
        <div class="container">
            <article id="post-<?php the_ID(); ?>" <?php post_class('doctor-single'); ?>>
                <div class="row">
                    <?php
                    if (have_posts()) :
                        while (have_posts()) :
                            the_post(); ?>
                            <div class="col-lg-4">
                                <div class="single-doctor-info">
                                    <?php inspiry_standard_thumbnail('doctor-grid-thumb'); ?>
                                    <h3 class="doctor-title"><?php the_title(); ?></h3>
                                    <div class="doctor-departments"><?php the_terms($post->ID, 'department', ' ', ', ', ' '); ?></div><?php get_template_part(INSPIRY_PARTIALS . '/doctor/doctor-social-icons'); ?>
                                    <div class="single-doctor-specialities">
		                                <?php
		                                $speciality = get_post_meta($post->ID, 'doctor_speciality', true);
		                                if (!empty($speciality)) {
			                                echo "<p><strong>" . __('Speciality', 'framework') . "</strong><span>" . $speciality . "</span></p>";
		                                }

		                                $education = get_post_meta($post->ID, 'doctor_education', true);
		                                if (!empty($education)) {
			                                echo "<p><strong>" . __('Education', 'framework') . "</strong><span>" . $education . "</span></p>";
		                                }

		                                $work_days = get_post_meta($post->ID, 'doctor_work_days', true);
		                                if (!empty($work_days)) {
			                                echo "<p><strong>" . __('Work Days', 'framework') . "</strong><span>" . $work_days . "</span></p>";
		                                }
		                                ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="single-side-content">
                                    <h2 class="entry-title"><?php the_title(); ?></h2>
                                    <div class="entry-content">
                                        <?php the_content(); ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                        endwhile;
                    endif;
                    ?>
                </div>
            </article>
        </div>

        <?php if ( $theme_options['display_related_doctors'] ) : ?>
            <div class="related-doctors">
                <div class="container">
                    <?php
                    if ( ( ! empty( $theme_options['related_doctors_title'] ) ) || ( ! empty( $theme_options['related_doctors_description'] ) ) ) : ?>
                        <header class="home-section-header">
                            <?php
                            if ( ! empty( $theme_options['related_doctors_title'] ) ) :
                                echo '<h2 class="home-section-title">' . $theme_options['related_doctors_title'] . '</h2>';
                            endif;

                            if ( ! empty( $theme_options['related_doctors_description'] ) ) :
                                echo '<p class="home-section-description">' . $theme_options['related_doctors_description'] . '</p>';
                            endif;
                            ?>
                        </header>
                    <?php endif; ?>

                    <div class="row">
                        <?php get_template_part( INSPIRY_PARTIALS . '/doctor/related-doctors' ); ?>
                    </div>

                    <?php if ( '1' == $theme_options['display_all_doctor_button'] && ! empty( $theme_options['display_all_doctor_button_link'] ) ) : ?>
                        <div class="text-center btn-wrapper">
                            <a class="btn btn-primary" href="<?php echo esc_url( $theme_options['display_all_doctor_button_link'] ); ?>">
                                <?php echo esc_html( $theme_options['display_all_doctor_button_text'] ); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

<?php get_footer(); ?>