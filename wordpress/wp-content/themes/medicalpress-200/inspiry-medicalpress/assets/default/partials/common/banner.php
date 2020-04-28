<?php
global $theme_options;

if ( isset( $theme_options['display_page_banner'] ) ):
	if ( '1' == $theme_options['display_page_banner'] ): ?>
        <div class="banner clearfix" style="background-repeat: no-repeat; background-position: center top; background-image: url('<?php echo get_banner_image(); ?>'); background-size: cover;"></div>
		<?php
	endif;
endif;
?>