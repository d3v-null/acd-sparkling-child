<?php

/**
 * Enqueue scripts and styles.
 */
function acd_scripts() {
    $google_font_query_args = array(
        'family' => 'Yanone+Kaffeesatz:400,700:latin|IM+Fell+DW+Pica:400|IM+Fell+DW+Pica+SC:400',
    );
    wp_register_style( 'acd-google-fonts', add_query_arg( $google_font_query_args, "//fonts.googleapis.com/css" ), array(), null );
    wp_enqueue_style('acd-google-fonts');
}
add_action( 'wp_enqueue_scripts', 'acd_scripts' );


function add_extra_typography_faces(){
    global $typography_options;
    $extra_typography_faces = array(
        'yanone-kaffeesatz'    => 'Yanone Kaffeesatz',
        'im-fell-dw-pica-sc'   => 'IM Fell DW Pica SC',
        'im-fell-dw-pica'      => 'IM Fell DW Pica',
    );
    if(!isset($typography_options) or !is_array($typography_options)){
        $typography_options = array('faces' => $extra_typography_faces);
    } else {
        $typography_options['faces'] = array_merge(
            $typography_options['faces'],
            $extra_typography_faces
        );
    }
    error_log("typography options:".serialize($typography_options));
}
add_action('init', 'add_extra_typography_faces', 99);

/**
 * Customizer additions.
 */
require get_stylesheet_directory() . '/inc/customizer.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_stylesheet_directory() . '/inc/extras.php';
