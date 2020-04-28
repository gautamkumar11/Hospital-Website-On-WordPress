<?php
global $paged, $theme_options, $services_args, $services_query;

$services_args = array(
	'post_type' => 'service',
	'posts_per_page' => -1
);

if ( isset( $theme_options['display_services_pagination'] ) ) {
    if ( '1' == $theme_options['display_services_pagination'] ) {

        if ( is_front_page() ) {
            $paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
        }

        $services_args = array(
            'post_type'      => 'service',
            'posts_per_page' => 4,
            'paged'          => $paged
        );
    }
}

// The Query
$services_query = new WP_Query($services_args);

// The Loop
if ($services_query->have_posts()) {
    while ($services_query->have_posts()) {
        $services_query->the_post();
        ?>
        <article <?php post_class('row one-col-service'); ?>>
            <div class="<?php bc('6','7','12',''); ?>">
                <?php inspiry_standard_thumbnail('services-one-col-thumb') ?>
            </div>
            <div class="<?php bc('6','5','12',''); ?>">
                <div class="service-contents">
                    <h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <div class="entry-content">
                        <p><?php inspiry_excerpt(35); ?></p>
                    </div>
                    <a class="read-more" href="<?php the_permalink(); ?>"><?php _e('Read More', 'framework'); ?></a>
                </div>
            </div>
        </article>
        <?php
    }
} else {
    nothing_found(__('No Service found !', 'framework'));
}
