<?php

/**
 * Options for ACD Sparkling Child Theme Customizer.
 */
function acd_customizer( $wp_customize ) {

    /* modifications to sparkling typography options */

    $typography_defaults = array(
            'face'  => 'Open Sans',
            'style' => 'normal',
    );
    global $typography_options;

    $wp_customize->add_setting('sparkling[heading_typography][face]', array(
        'default' => $typography_defaults['face'],
        'type' => 'option',
        'sanitize_callback' => 'sparkling_sanitize_typo_face'
    ));
    $wp_customize->add_control('sparkling[heading_typography][face]', array(
        'section' => 'sparkling_typography_options',
        'label' => __('Headings'),
        'description' => __('Heading typography'),
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
        // 'description' => __('Heading typography style'),
        'type'    => 'select',
        'choices'    => $typography_options['styles']
    ));

    /* modifications to sparkling layout options */

    $wp_customize->add_setting('sparkling[page_width]', array(
        'default' => 960,
        'type'    => 'option',
        'sanitize_callback' => 'acd_sanitize_pagewidth'
    ));
    $wp_customize->add_control('sparkling[page_width]', array(
        'section'   => 'sparkling_layout_options',
        'type'      => 'text',
        'label'     => __('Page Width'),
        'description'  => __('The width of the page')
    ));

    /* modifications to sparkling header options */
    //
    $wp_customize->add_setting(
        'sparkling[header_background_url]',
        array(
            'default' => '',
            'type'      => 'option',
            'sanitize_callback' => ''
            // 'transport' => 'postMessage'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'sparkling[header_background_url]',
            array(
                'label' => __( 'Upload a background for the header', 'sparkling' ),
                'settings' => 'sparkling[header_background_url]',
                'section' => 'sparkling_header_options'
            )
        )
    );

    $wp_customize->add_setting(
        'sparkling[header_nav_position]',
        array(
            'default' => 'center',
            'type'      => 'option',
            'sanitize_callback' => ''
        )
    );

    $wp_customize->add_control('sparkling[header_nav_position]', array(
        'section' => 'sparkling_header_options',
        'description' => __('Header nav menu position'),
        'type'    => 'select',
        'choices'    => $typography_options['horizontal-positions']
    ));

}
add_action( 'customize_register', 'acd_customizer' );


/**
 * Sanitzie checkbox for WordPress customizer
 */
function acd_sanitize_pagewidth( $input ) {
    $number = (int)$input;
    if ( $number >= 240 && $number < 5120 ) {
        return $number;
    } else {
        return '';
    }
}

function acd_sanitize_horizontal_position( $input ) {
    global $typography_options;
    $options = $typography_options['horizontal-positions'];
    if(in_array($input, $options)){
        return $input;
    } else {
        return '';
    }
}
 ?>
