<?php

/**
 * Enqueue scripts and styles.
 */


function acd_scripts() {
    $parent_style = 'sparkling';

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'acd-sparkling-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );

    $google_font_query_args = array(
        'family' => 'Yanone+Kaffeesatz:400,700:latin|IM+Fell+DW+Pica:400|IM+Fell+DW+Pica+SC:400',
    );
    wp_register_style( 'acd-google-fonts', add_query_arg( $google_font_query_args, "//fonts.googleapis.com/css" ), array(), null );
    wp_enqueue_style('acd-google-fonts');

    wp_enqueue_script( 'acd-sparkling-child-tether', get_stylesheet_directory_uri(). '/inc/js/tether.min.js', array('jquery') );
    wp_enqueue_script( 'acd-sparkling-child-functions', get_stylesheet_directory_uri(). '/inc/js/functions.min.js', array('jquery', 'sparkling-bootstrapjs') );
}
add_action( 'wp_enqueue_scripts', 'acd_scripts', 9 );


function add_extra_typography_options(){
    global $typography_options;
    $extra_typography_options = array(
        // 'positions' => array(
        //     'top left', 'top', 'top right',
        //     'left', 'center', 'right',
        //     'bottom left', 'bottom', 'bottom right'
        // ),
        'horizontal-positions' => array(
            'left', 'center', 'right'
        )
    );
    if(isset($typography_options) and is_array($typography_options)){
        $typography_options = array_merge($typography_options, $extra_typography_options);
    } else {
        $typography_options = $extra_typography_options;
    }

    $extra_typography_faces = array(
        'yanone-kaffeesatz'    => 'Yanone Kaffeesatz',
        'im-fell-dw-pica-sc'   => 'IM Fell DW Pica SC',
        'im-fell-dw-pica'      => 'IM Fell DW Pica',
    );
    if(isset($typography_options) and is_array($typography_options)){
        $typography_options['faces'] = array_merge(
            $typography_options['faces'],
            $extra_typography_faces
        );
    } else {
        $typography_options = array('faces' => $extra_typography_faces);
    }
    error_log("typography options:".serialize($typography_options));
}
add_action('init', 'add_extra_typography_options', 99);

/**
 * Customizer additions.
 */
require get_stylesheet_directory() . '/inc/customizer.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_stylesheet_directory() . '/inc/extras.php';
