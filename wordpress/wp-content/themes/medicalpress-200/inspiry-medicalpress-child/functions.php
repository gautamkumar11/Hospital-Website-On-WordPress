<?php
/*-----------------------------------------------------------------------------------*/
/*	Enqueue Styles in Child Theme
/*-----------------------------------------------------------------------------------*/
if (!function_exists('inspiry_enqueue_child_styles')) {
    function inspiry_enqueue_child_styles(){
        if ( !is_admin() ) {
            // dequeue and deregister parent default css
            wp_dequeue_style( 'parent-default' );
            wp_deregister_style( 'parent-default' );

            // dequeue parent custom css
            wp_dequeue_style( 'parent-custom' );

            // parent default css
            wp_enqueue_style( 'parent-default', get_template_directory_uri().'/style.css' );

            // parent custom css
            wp_enqueue_style( 'parent-custom' );

            // child default css
            wp_enqueue_style('child-default', get_stylesheet_uri(), array('parent-default'), '1.1', 'all' );

            // child custom css
            wp_enqueue_style('child-custom',  get_stylesheet_directory_uri() . '/child-custom.css', array('child-default'), '1.1', 'all' );
        }
    }
}
add_action( 'wp_enqueue_scripts', 'inspiry_enqueue_child_styles', PHP_INT_MAX );

/**

Custom function for filtering the sections array. Good for child themes to override or add to the sections.

NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
so you must use get_template_directory_uri() if you want to use any of the built in icons
**/

// REMOVE COMMENTS AROUND THIS FUNCTION IF YOU WANT TO PLAY WITH THEME OPTIONS
/*
function dynamic_section($sections) {
    //$sections = array();
    $sections[] = array(
        'title' => __('Section via hook', 'framework'),
        'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'framework'),
        'icon' => 'el-icon-paper-clip',
        // Leave this as a blank section, no options just some intro text set above.
        'fields' => array()
    );

    return $sections;
}
*/


if ( !function_exists( 'inspiry_load_translation_from_child' ) ) {
    /**
     * Load translation files from child theme
     */
    function inspiry_load_translation_from_child () {
        load_child_theme_textdomain ( 'framework', get_stylesheet_directory () . '/languages' );
    }
    add_action ( 'after_setup_theme', 'inspiry_load_translation_from_child' );
}