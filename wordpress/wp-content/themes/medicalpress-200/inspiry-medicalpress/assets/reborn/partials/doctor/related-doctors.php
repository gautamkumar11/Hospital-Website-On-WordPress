<?php
global $post;

/* Basic Arguments for related doctors query */
$related_doctors_args = array(
    'post_type' => 'doctor',
    'posts_per_page' => 4,
    'post__not_in' => array($post->ID),
    'orderby' => 'rand'
);

/* Main Post( Doctor ) Departments */
$tax_query = array();
$department_terms = get_the_terms($post->ID, "department");
if (!empty($department_terms) && is_array($department_terms)) {
    $departments_array = array();
    foreach ($department_terms as $department_term) {
        $departments_array[] = $department_term->term_id;
    }
    $tax_query[] = array(
        'taxonomy' => 'department',
        'field' => 'id',
        'terms' => $departments_array
    );
}

/* if there are departments assigned to main post then add those in related doctors query */
$tax_count = count($tax_query); // count number of taxonomies
if ($tax_count > 0) {
    $related_doctors_args['tax_query'] = $tax_query; // add taxonomies query
}

$related_doctors_query = new WP_Query($related_doctors_args);

/* Related doctors query */
if ( $related_doctors_query->have_posts() ) :
	$loop_counter = 0;
	while ( $related_doctors_query->have_posts() ) :
		$related_doctors_query->the_post(); ?>
        <div class="col-sm-6 col-lg-3">
            <article class="doctor-common doctor-grid doctor-grid-one hentry">
                <?php if ( has_post_thumbnail( get_the_ID() ) ) : ?>
                    <figure>
                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                            <?php the_post_thumbnail( 'doctor-grid-thumb' ); ?>
                        </a>
                    </figure>
	            <?php endif; ?>
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

/* Restore original Post Data */
wp_reset_postdata();
?>