<?php
global $theme_options;

if ( isset( $theme_options['display_gallery_categories'] ) && '1' == $theme_options['display_gallery_categories'] ) : ?>
    <div class="gallery-item-types">
		<?php the_terms( $post->ID, 'gallery-item-type', ' ', ', ', ' ' ); ?>
    </div>
	<?php
endif;