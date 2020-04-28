<?php
/**
 * Sidebar
 *
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<?php if ( 'default' == INSPIRY_DESIGN_VARIATION ): ?>
    <div class="<?php bc( '3', '4', '12', '' ); ?>">
	<?php else: ?>
    <div class="col-lg-4 col-xl-3">
    <?php endif; ?>
		<?php dynamic_sidebar( 'shop' ); ?>
    </div>