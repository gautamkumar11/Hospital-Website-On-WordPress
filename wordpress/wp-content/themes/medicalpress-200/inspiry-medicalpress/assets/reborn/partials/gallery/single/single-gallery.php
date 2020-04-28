<?php
get_header(); ?>

    <div class="gallery-single-wrapper">
        <article class="gallery-single clearfix hentry">
            <div class="container">
                <div class="next-prev-posts clearfix">
                    <?php previous_post_link('%link', ''); ?>
                    <?php next_post_link('%link', ''); ?>
                </div>
				<?php
				if (have_posts()) :
					while (have_posts()) :
						the_post();
						?>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="gallery-single-post clearfix">
                                    <div class="clearfix" id="slider">
										<?php inspiry_list_custom_gallery_images('gallery-post-single'); ?>
                                    </div>
									<?php
									$size_thumb = 'gallery-post-single-thumb';
									$gallery_images = rwmb_meta('MEDICAL_META_custom_gallery', 'type=plupload_image&size=' . $size_thumb, $post->ID);
									if (!empty($gallery_images)) {
										?>
                                        <div id="carousel" class="flexslider">
                                            <ul class="slides">
												<?php
												foreach ($gallery_images as $gallery_image) {
													$caption = (!empty($gallery_image['caption'])) ? $gallery_image['caption'] : $gallery_image['alt'];
													echo '<li>';
													echo '<img src="' . $gallery_image['url'] . '" alt="' . $gallery_image['title'] . '" />';
													echo '</li>';
												}
												?>
                                            </ul>
                                        </div>
										<?php
									}
									?>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="side-content clearfix">
                                    <h1 class="entry-title"><?php the_title(); ?></h1>
                                    <div class="gallery-item-types">
                                        <i class="fa fa-tags"></i>
										<?php the_terms($post->ID, 'gallery-item-type', ' ', ', ', ' '); ?>
                                    </div>
                                    <div class="entry-content">
										<?php
										/* output contents */
										the_content();
										?>
                                    </div>
                                </div>
                            </div>
                        </div>
						<?php
					endwhile;
				endif;
				?>
            </div>
        </article>

		<?php
		global $theme_options;
		if ( $theme_options[ 'display_related_gallery_items' ] ) :
			get_template_part( INSPIRY_PARTIALS . '/gallery/related-gallery' );
		endif;
		?>
    </div>

<?php get_footer(); ?>