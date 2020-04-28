<?php
get_header(); ?>

    <div class="container">
        <div class="jumbotron text-center">
            <h1>4<span>0</span>4</h1>
            <div class="entry-content">
                <p><?php esc_html_e('Look like something went wrong! The page you were looking for is not here', 'framework'); ?></p>
                <p><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Visit Homepage','framework'); ?></a></p>
            </div>
        </div>
    </div>

<?php get_footer(); ?>