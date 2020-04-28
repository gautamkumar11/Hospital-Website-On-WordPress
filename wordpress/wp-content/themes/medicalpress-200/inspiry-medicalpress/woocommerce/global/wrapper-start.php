<?php
/**
 * Content wrappers
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<?php if ( 'default' == INSPIRY_DESIGN_VARIATION ): ?>
<div class="<?php bc('9', '8', '12', ''); ?>">
    <?php else: ?>
    <div class="col-lg-8 col-xl-9">
    <?php endif; ?>

    <div id="container">
        <div id="content" role="main">
