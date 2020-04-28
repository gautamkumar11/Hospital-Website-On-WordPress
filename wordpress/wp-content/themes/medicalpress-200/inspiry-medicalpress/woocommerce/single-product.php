<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>

<?php if ( 'default' == INSPIRY_DESIGN_VARIATION ): ?>
    <div class="page-top clearfix">
        <div class="container">
            <div class="row">
                <div class="<?php bc_all( '12' ); ?>">
                    <h2 class="entry-title"><?php the_title(); ?></h2>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="shop-page clearfix">

    <div class="container">

        <div class="row">

            <div class="<?php bc_all('12'); ?>">

                <div class="blog-page-single clearfix">

                    <?php while ( have_posts() ) : the_post(); ?>

                        <?php wc_get_template_part( 'content', 'single-product' ); ?>

                    <?php endwhile; // end of the loop. ?>

                </div><!-- /.blog-page-single -->

            </div>

        </div><!-- /.row -->

    </div><!-- /.container -->

</div><!-- /.shop-page -->

<?php get_footer( 'shop' ); ?>
