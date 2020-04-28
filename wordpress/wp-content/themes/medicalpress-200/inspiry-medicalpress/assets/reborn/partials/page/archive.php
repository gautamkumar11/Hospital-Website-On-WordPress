<?php
get_header(); ?>

    <div class="blog-page clearfix">
        <div class="container">
            <div class="row">
                <div class="<?php bc('9', '8', '12', ''); ?>">
                    <div class="blog-post-listing clearfix">
                        <?php get_template_part('loop'); ?>
                    </div>
                </div>
                <div class="<?php bc('3', '4', '12', ''); ?>">
                    <?php get_sidebar(); ?>
                </div>
            </div>
        </div>
    </div>

<?php get_footer(); ?>