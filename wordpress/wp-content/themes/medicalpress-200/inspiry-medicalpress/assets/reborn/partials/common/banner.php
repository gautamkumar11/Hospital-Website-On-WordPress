<?php
global $theme_options;

$inspiry_page_title      = get_the_title();
$inspiry_banner_bg_image = get_banner_image();

if ( is_home() ) {

	$blog_page_id = get_option( 'page_for_posts' );

	if ( ! empty( $blog_page_id ) ) {
		$inspiry_page_title = get_the_title( $blog_page_id );
	} else {
		$inspiry_page_title = __( 'Blog', 'framework' );
	}

} elseif ( is_404() ) {

	$inspiry_page_title = __( 'Page 404', 'framework' );

} elseif ( is_search() ) {

	$inspiry_page_title = sprintf( __( 'Search Results for: %s', 'framework' ), get_search_query() );

} elseif ( is_author() ) {

	global $wp_query;
	$current_author = $wp_query->get_queried_object();

	if ( ! empty( $current_author->display_name ) ) {
		$inspiry_page_title = $current_author->display_name;
	}

} elseif ( is_archive() ) {

	$inspiry_page_title = get_the_archive_title();

	if ( function_exists( 'is_shop' ) ) {

		if ( is_shop() ) {
			$inspiry_page_title = __( 'Shop', 'framework' );
		}
	}
}

if ( isset( $theme_options['display_page_banner'] ) ):
	if ( '1' == $theme_options['display_page_banner'] ): ?>
        <div class="banner<?php echo ( is_front_page() && ! is_home() ) ? ' hide-banner-text' : ''; ?>" style="background-image: url('<?php echo esc_url( $inspiry_banner_bg_image ); ?>');">
            <div class="banner-image-overlay"></div>
            <div class="container">
				<?php
				if ( ! empty( $inspiry_page_title ) ) :
					if ( is_front_page() || is_singular( array( 'product', 'gallery-item' ) ) || is_404() ) :?>
                        <h2 class="page-title"><?php echo esc_html( $inspiry_page_title ); ?></h2>
                    <?php else : ?>
                        <h1 class="page-title"><?php echo esc_html( $inspiry_page_title ); ?></h1>
                    <?php
                    endif;
				endif; ?>
                <nav class="breadcrumb-nav"><?php theme_breadcrumb(); ?></nav>
            </div>
        </div><!-- .banner -->
		<?php
	endif;
endif;
?>