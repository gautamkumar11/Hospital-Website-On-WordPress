<?php
get_header(); ?>

<div class="blog-page clearfix">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-xl-9">
                <div class="blog-post-single clearfix">
                    <?php
                    if (have_posts()):
                        while (have_posts()):
                            the_post();
                            ?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class(' clearfix'); ?> >
                                <div class="left_meta clearfix entry-meta">
                                    <time class="entry-date published updated" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo get_the_date( 'M' ); ?>
                                        <strong><?php echo get_the_date( 'd' ); ?></strong></time>
                                    <span class="comments_count clearfix entry-comments-link"><?php comments_popup_link(__('0', 'framework'), __('1', 'framework'), __('%', 'framework')); ?></span>
                                </div>
                                <div class="right-contents">
                                    <header class="entry-header">
                                        <?php
                                        /* Get post header based on format */
                                        $format = get_post_format($post->ID);
                                        if (false === $format) {
                                            $format = 'standard';
                                        }

                                        get_template_part(INSPIRY_PARTIALS . "/blog/post/formats/$format");

                                        if ( $format !== 'link' && $format !== 'quote' ) {
                                            ?>
                                            <h2 class="entry-title"><?php the_title(); ?></h2>

                                            <span class="entry-author">
                                                <?php esc_html_e('Posted by', 'framework') ?>
                                                <span class="entry-author-link vcard">
                                                    <?php
                                                    printf( '<a class="url fn" href="%1$s" title="%2$s" rel="author">%3$s</a>',
                                                        esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
                                                        esc_attr( sprintf( __( 'View all posts by %s', 'framework' ), get_the_author() ) ),
                                                        get_the_author()
                                                    );
                                                    ?>
                                                </span>
                                                <span class="entry-categories">
                                                    <?php esc_html_e('in', 'framework'); ?>&nbsp;<?php the_category(', '); ?>
                                                </span>
                                            </span>
                                            <?php
                                        }
                                        ?>
                                    </header>
                                    <div class="entry-content clearfix">
                                        <?php
                                        /* output post contents */
                                        the_content();

                                        // WordPress Link Pages
                                        wp_link_pages(array('before' => '<div class="page-nav-btns clearfix">', 'after' => '</div>', 'next_or_number' => 'next'));
                                        ?>
                                    </div>
                                    <footer class="entry-footer clearfix">
                                        <p class="entry-meta">
	                                        <?php
	                                        if ( get_the_tags() ): ?>
                                                <span class="entry-tags">
                                                    <i class="fas fa-tags"></i>&nbsp;&nbsp;<?php the_tags( '', ', ', '' ); ?>
                                                </span>
		                                        <?php
	                                        endif; ?>
                                        </p>
                                    </footer>
                                </div>
                            </article>
                        <?php
                        endwhile;
                    endif;
                    ?>
                    <div class="right-contents single-right-contents">
                        <div class="comments-wrapper">
		                    <?php comments_template(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xl-3">
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>