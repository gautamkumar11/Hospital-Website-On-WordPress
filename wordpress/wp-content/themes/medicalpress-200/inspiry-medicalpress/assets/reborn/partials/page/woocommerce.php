<?php get_header(); ?>

<div class="shop-page clearfix">
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
                                    <div class="entry-content">
										<?php
										/* output page contents */
										the_content();
										?>
                                    </div>
                                </div>
                            </article>
							<?php
						endwhile;
					endif;
					?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>