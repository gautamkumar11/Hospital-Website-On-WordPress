<div id="site-logo" class="site-logo">
    <div class="site-logo-inner">
		<?php
		global $theme_options;

		$logo_path        = isset( $theme_options['website_logo']['url'] ) ? $theme_options['website_logo']['url'] : '';
		$retina_logo_path = isset( $theme_options['website_retina_logo']['url'] ) ? $theme_options['website_retina_logo']['url'] : '';

		if ( ! empty( $logo_path ) || ! empty( $retina_logo_path ) ) : ?>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php inspiry_logo_img( $logo_path, $retina_logo_path ); ?></a>
			<?php
		else :
			if ( is_front_page() ) : ?>
                <h1 class="site-title">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
                </h1>
				<?php
			else : ?>
                <p class="site-title">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
                </p>
				<?php
			endif;
		endif;

		$inspiry_tag_line = get_bloginfo( 'description' );
		if ( $inspiry_tag_line ) : ?>
            <small class="tag-line"><?php echo esc_html( $inspiry_tag_line ); ?></small><?php
		endif;
		?>
    </div>
</div><!-- .site-logo -->