<?php

/**
 * Options for ACD Sparkling Child Theme Customizer.
 */
function acd_customizer( $wp_customize ) {

    $typography_defaults = array(
            'face'  => 'Open Sans',
            'style' => 'normal',
    );
    global $typography_options;

    // $wp_customize->add_setting('sparkling[heading_typography][size]', array(
    //     'default' => $typography_defaults['size'],
    //     'type' => 'option',
    //     'sanitize_callback' => 'sparkling_sanitize_typo_size'
    // ));
    // $wp_customize->add_control('sparkling[heading_typography][size]', array(
    //     'label' => __('Heading Typography', 'sparkling'),
    //     'description' => __('Used in h tags', 'sparkling'),
    //     'section' => 'sparkling_typography_options',
    //     'type'    => 'select',
    //     'choices'    => $typography_options['sizes']
    // ));
    $wp_customize->add_setting('sparkling[heading_typography][face]', array(
        'default' => $typography_defaults['face'],
        'type' => 'option',
        'sanitize_callback' => 'sparkling_sanitize_typo_face'
    ));
    $wp_customize->add_control('sparkling[heading_typography][face]', array(
        'section' => 'sparkling_typography_options',
        'type'    => 'select',
        'choices'    => $typography_options['faces']
    ));
    $wp_customize->add_setting('sparkling[heading_typography][style]', array(
        'default' => $typography_defaults['style'],
        'type' => 'option',
        'sanitize_callback' => 'sparkling_sanitize_typo_style'
    ));
    $wp_customize->add_control('sparkling[heading_typography][style]', array(
        'section' => 'sparkling_typography_options',
        'type'    => 'select',
        'choices'    => $typography_options['styles']
    ));
}
add_action( 'customize_register', 'acd_customizer' );

 ?>
