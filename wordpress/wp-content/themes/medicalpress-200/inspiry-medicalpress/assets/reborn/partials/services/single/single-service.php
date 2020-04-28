<?php
get_header(); ?>

    <div class="blog-page service-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 site-main">
                    <div class="blog-page-single clearfix">
						<?php
						if (have_posts()):
							while (have_posts()):
								the_post();
								?>
                                <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
                                    <header class="entry-header">
                                        <div class="gallery gallery-slider flexslider clearfix">
                                            <?php inspiry_list_gallery_images('service-gallery-thumb') ?>
                                        </div>
                                    </header>
                                    <div class="entry-content">
                                        <?php
                                        /* output contents */
                                        the_content();
                                        ?>
                                    </div>
                                </article>
								<?php
							endwhile;
						endif;
						?>
                    </div>
                </div>
                <div class="col-lg-3">
					<?php get_sidebar('service'); ?>
                </div>
            </div>
        </div>
    </div>

<?php get_footer(); ?>