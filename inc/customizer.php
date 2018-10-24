<?php

/**
 * Options for ACD Sparkling Child Theme Customizer.
 */
function acd_customizer( $wp_customize ) {

    /* modifications to sparkling typography options */

    $typography_defaults = array(
            'size'  => '14px',
            'face'  => 'Open Sans',
            'style' => 'normal',
            'color' => '#000000'
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

    $wp_customize->add_setting('sparkling[navbar_typography][face]', array(
        'default' => $typography_defaults['face'],
        'type' => 'option',
        'sanitize_callback' => 'sparkling_sanitize_typo_face'
    ));
    $wp_customize->add_control('sparkling[navbar_typography][face]', array(
        'section' => 'sparkling_typography_options',
        'label' => __('Navbars'),
        'description' => __('Navbar typography'),
        'type'    => 'select',
        'choices'    => $typography_options['faces']
    ));
    $wp_customize->add_setting('sparkling[navbar_typography][style]', array(
        'default' => $typography_defaults['style'],
        'type' => 'option',
        'sanitize_callback' => 'sparkling_sanitize_typo_style'
    ));
    $wp_customize->add_control('sparkling[navbar_typography][style]', array(
        'section' => 'sparkling_typography_options',
        // 'description' => __('Navbar typography style'),
        'type'    => 'select',
        'choices'    => $typography_options['styles']
    ));

    $wp_customize->add_setting('sparkling[header_message_typography][face]', array(
        'default' => $typography_defaults['face'],
        'type' => 'option',
        'sanitize_callback' => 'sparkling_sanitize_typo_face'
    ));
    $wp_customize->add_control('sparkling[header_message_typography][face]', array(
        'section' => 'sparkling_typography_options',
        'label' => __('Header Message'),
        'description' => __('Header Message typography'),
        'type'    => 'select',
        'choices'    => $typography_options['faces']
    ));
    $wp_customize->add_setting('sparkling[header_message_typography][style]', array(
        'default' => $typography_defaults['style'],
        'type' => 'option',
        'sanitize_callback' => 'sparkling_sanitize_typo_style'
    ));
    $wp_customize->add_control('sparkling[header_message_typography][style]', array(
        'section' => 'sparkling_typography_options',
        'type'    => 'select',
        'choices'    => $typography_options['styles']
    ));
    $wp_customize->add_setting('sparkling[header_message_typography][size]', array(
        'default' => $typography_defaults['size'],
        'type' => 'option',
        'sanitize_callback' => 'sparkling_sanitize_typo_size'
    ));
    $wp_customize->add_control('sparkling[header_message_typography][size]', array(
        'section' => 'sparkling_typography_options',
        'type'    => 'select',
        'choices'    => $typography_options['sizes']
    ));
    $wp_customize->add_setting(
        'sparkling[header_message_typography][color]',
        array(
            'default'=> $typography_defaults['color'],
            'type'=> 'option',
            'sanitize_callback' => 'sparkling_sanitize_hexcolor'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'sparkling[header_message_typography][color]',
            array(
                // 'label'=> __('Header Message Typography olour'),
                'settings'=>'sparkling[header_message_typography][color]',
                'section'=>'sparkling_typography_options'
            )
        )
    );

    /* modifications to sparkling layout options */

    // $wp_customize->add_setting('sparkling[page_width]', array(
    //     'default' => 960,
    //     'type'    => 'option',
    //     'sanitize_callback' => 'acd_sanitize_pagewidth'
    // ));
    // $wp_customize->add_control('sparkling[page_width]', array(
    //     'section'   => 'sparkling_layout_options',
    //     'type'      => 'text',
    //     'label'     => __('Page Width'),
    //     'description'  => __('The width of the page')
    // ));

    $wp_customize->add_setting('sparkling[constrain_header]', array(
        'default' => 0,
        'type' => 'option',
        'sanitize_callback' => 'sparkling_sanitize_checkbox',
    ));
    $wp_customize->add_control('sparkling[constrain_header]', array(
        'section'   => 'sparkling_header_options',
        'type'      => 'checkbox',
        'label'     => __('Constrain Header'),
        'description'  => __('Tick to constrain header, if off header is fullscreen')
    ));

    //TODO: remove sticky header

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

    /**
     * Homepage Options
     */

    $wp_customize->add_section('sparkling_home_options', array(
        'title' => __('Homepage', 'sparkling'),
        'priority' => 31,
        'panel' => 'sparkling_main_options'
    ));

    /* homepage signature image */

    $wp_customize->add_setting(
        'sparkling[signature_img_url]',
        array(
            'default' => '',
            'type'      => 'option',
            'sanitize_callback' => ''
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'sparkling[signature_img_url]',
            array(
                'label' => __( 'Upload an image for the homepage signature', 'sparkling' ),
                'settings' => 'sparkling[signature_img_url]',
                'section' => 'sparkling_home_options'
            )
        )
    );

    /**
     * Slider Options
     */

    $wp_customize->add_setting(
        'sparkling[carousel_title_background_color]',
        array(
            'default'=> '',
            'type'=> 'option',
            'sanitize_callback' => 'sparkling_sanitize_hexcolor'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'sparkling[carousel_title_background_color]',
            array(
                'label'=> __('Carousel title background colour'),
                'settings'=>'sparkling[carousel_title_background_color]',
                'section'=>'sparkling_slider_options'
            )
        )
    );

    $wp_customize->add_setting(
        'sparkling[carousel_excerpt_background_color]',
        array(
            'default'=> '',
            'type'=> 'option',
            'sanitize_callback' => 'sparkling_sanitize_hexcolor'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'sparkling[carousel_excerpt_background_color]',
            array(
                'label'=> __('Carousel excerpt background colour'),
                'settings'=>'sparkling[carousel_excerpt_background_color]',
                'section'=>'sparkling_slider_options'
            )
        )
    );

    $wp_customize->add_setting(
        'sparkling[carousel_title_text_color]',
        array(
            'default'=> '',
            'type'=> 'option',
            'sanitize_callback' => 'sparkling_sanitize_hexcolor'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'sparkling[carousel_title_text_color]',
            array(
                'label'=> __('Carousel title text colour'),
                'settings'=>'sparkling[carousel_title_text_color]',
                'section'=>'sparkling_slider_options'
            )
        )
    );

    $wp_customize->add_setting(
        'sparkling[carousel_excerpt_text_color]',
        array(
            'default'=> '',
            'type'=> 'option',
            'sanitize_callback' => 'sparkling_sanitize_hexcolor'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'sparkling[carousel_excerpt_text_color]',
            array(
                'label'=> __('Carousel excerpt text colour'),
                'settings'=>'sparkling[carousel_excerpt_text_color]',
                'section'=>'sparkling_slider_options'
            )
        )
    );

    $wp_customize->add_setting(
        'sparkling[carousel_caption_background_opacity]',
        array(
            'default'=> '0.9',
            'type'=> 'option',
        )
    );

    $wp_customize->add_control(
        'sparkling[carousel_caption_background_opacity]',
        array(
            'label'=> __('Carousel caption background opacity'),
            'settings'=>'sparkling[carousel_caption_background_opacity]',
            'section'=>'sparkling_slider_options',
            'type'=>'text'
        )
    );

    /**
     * Colour Options
     */

     $wp_customize->add_setting(
         'sparkling[highlight_color]',
         array(
             'default'=> '#DA4453',
             'type'=> 'option',
         )
     );

     $wp_customize->add_control(
         new WP_Customize_Color_Control(
             $wp_customize,
             'sparkling[highlight_color]',
             array(
                 'label'=> __('Highlight Color'),
                 'settings'=>'sparkling[highlight_color]',
                 'section'=>'colors'
             )
         )
     );

    /**
    * Other options
    */

    $wp_customize->add_setting(
        'sparkling[checkout_message]',
        array(
            'default' => 'Dear customer, <br/>'
                 .'Please note that this website is a testing website and no orders placed here '
                 .'will be fulfilled. '
                 .'we appologize for any inconvenience this may cause you. Thank you.',
            'type' => 'option'
        )
    );

    $wp_customize->add_control(
        'sparkling[checkout_message]',
        array(
            'label' => __('Checkout Message'),
            'settings' => 'sparkling[checkout_message]',
            'section' => 'sparkling_other_options',
            'type' => 'textarea'
        )
    );

    $wp_customize->add_setting(
        'sparkling[enable_checkout_message]',
        array(
            'type'=>'option',
            'default'=>0,
            'sanitize_callback' => 'sparkling_sanitize_checkbox'
        )
    );

    $wp_customize->add_control(
        'sparkling[enable_checkout_message]',
        array(
            'label'=> __('Enable Checkout Message'),
            'section' => 'sparkling_other_options',
            'type' => 'checkbox'
        )
    );

    $wp_customize->add_setting(
        'sparkling[header_message]',
        array(
            'default' => '',
            'type' => 'option'
        )
    );

    $wp_customize->add_control(
        'sparkling[header_message]',
        array(
            'label' => __('Header Message'),
            'settings' => 'sparkling[header_message]',
            'section' => 'sparkling_other_options',
            'type' => 'textarea'
        )
    );

    $wp_customize->add_setting(
        'sparkling[enable_header_message]',
        array(
            'type'=>'option',
            'default'=>0,
            'sanitize_callback' => 'sparkling_sanitize_checkbox'
        )
    );

    $wp_customize->add_control(
        'sparkling[enable_header_message]',
        array(
            'label'=> __('Enable Header Message'),
            'section' => 'sparkling_other_options',
            'type' => 'checkbox'
        )
    );

    /**
     * Shop Options
     */

    $wp_customize->add_section('sparkling_shop_options', array(
        'title' => __('Shop', 'sparkling'),
        'priority' => 31,
        'panel' => 'sparkling_main_options'
    ));

    $wp_customize->add_setting(
        'sparkling[hide_afterpay_roles]',
        array(
            'default' => '',
            'type' => 'option'
        )
    );

    $wp_customize->add_control(
        'sparkling[hide_afterpay_roles]',
        array(
            'label'=> __('Hide AfterPay From Roles'),
            'section' => 'sparkling_shop_options',
            'settings' => 'sparkling[hide_afterpay_roles]',
            'type' => 'textarea'
        )
    );



}
add_action( 'customize_register', 'acd_customizer' );

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
