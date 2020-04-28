<!DOCTYPE html>
<!--[if IE 7]><html class="ie ie7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]><html class="ie ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!--><html <?php language_attributes(); ?>><!--<![endif]-->
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <meta name="format-detection" content="telephone=no"/>
	<?php
	if ( is_singular() && pings_open( get_queried_object() ) ) {
		?><link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>"><?php
	}
	?>
    <link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?>" href="<?php bloginfo( 'rss2_url' ); ?>"/>
    <link rel="alternate" type="application/atom+xml" title="<?php bloginfo( 'name' ); ?>" href="<?php bloginfo( 'atom_url' ); ?>"/>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="page">
    <?php get_template_part( INSPIRY_PARTIALS . '/header/header' ); ?>