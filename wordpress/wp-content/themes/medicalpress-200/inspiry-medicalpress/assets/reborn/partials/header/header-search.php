<?php
global $theme_options;

if ( isset( $theme_options['display_top_header_search'] ) && '1' == $theme_options['display_top_header_search'] ) : ?>
    <div id="header-search-form-container" class="header-search-form-container">
        <form class="header-search-form" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <input type="search" name="s" class="search-field" placeholder="<?php esc_attr_e( 'Search', 'framework' ); ?>">
            <button type="submit" class="search-submit">
	            <?php include INSPIRY_ASSETS_DIR . '/images/svg/icon-search.svg'; ?>
            </button>
        </form>
    </div><!-- .header-search-form-container -->
<?php endif; ?>