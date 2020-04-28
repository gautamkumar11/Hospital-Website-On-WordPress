<?php

get_header(); ?>

<div class="faq-page">

    <div class="filters-wrapper">
        <div class="container">
			<?php inspiry_filters( 'faq-group', __( 'All FAQs', 'framework' ), false ); ?>
        </div>
    </div><!-- .filter-wrapper -->

    <div class="container">

	    <?php get_template_part( INSPIRY_PARTIALS . '/common/page-content' ); ?>

        <?php
        $faq_args = array(
            'post_type' => 'faq',
            'posts_per_page' => -1,
        );

        // The Query
        $faq_query = new WP_Query($faq_args);

        // The Loop
        if ($faq_query->have_posts()) {
            echo '<div class="toggle-main faq">';
            while ($faq_query->have_posts()) {
                $faq_query->the_post();

                /* faq group terms slug needed to be used as classes in html for isotope functionality */
                $faq_group_terms = get_the_terms($post->ID, 'faq-group');
                $faq_group_terms_slugs = '';
                if (!empty($faq_group_terms)) {

                    foreach ($faq_group_terms as $term) {
                        if (!empty($faq_group_terms_slugs))
                            $faq_group_terms_slugs .= ' ';

                        $faq_group_terms_slugs .= $term->slug;
                    }
                }

                ?>
                <div class="toggle <?php echo $faq_group_terms_slugs; ?>">
                    <div class="toggle-title">
                        <h3><i class="fa fa-question"></i><?php the_title(); ?></h3>
                    </div>
                    <div class="toggle-content">
                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>
            <?php
            }
            echo '</div>';
        } else {
            nothing_found( __('No FAQ found!', 'framework') );
        }

        /* Restore original Post Data */
        wp_reset_postdata();
        ?>
    </div>
</div>

<?php get_footer(); ?>
