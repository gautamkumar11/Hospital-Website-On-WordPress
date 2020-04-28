<?php

get_header(); ?>

<div class="default-page full-width">
    <div class="container">
        <div class="row">
            <div class="<?php bc_all('12'); ?>">
                <div class="blog-page-single clearfix">
                    <?php
                    if (have_posts()):
                        while (have_posts()):
                            the_post();
                            ?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class(' clearfix'); ?>>
                                <div class="full-width-contents">
	                                <?php
	                                /*
									 * Display featured image
									 */
	                                inspiry_standard_thumbnail();
	                                ?>
                                    <div class="entry-content">
                                        <?php
                                        /* output page contents */
                                        the_content();

                                        // WordPress Link Pages
                                        wp_link_pages(array('before' => '<div class="page-nav-btns clearfix">', 'after' => '</div>', 'next_or_number' => 'next'));
                                        ?>
                                    </div>
                                </div>
                            </article>
                        <?php
                        endwhile;
                    endif;
                    ?>
                </div>
                <div class="row">
                    <div class="<?php bc_all('12'); ?>">
                        <?php comments_template(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>