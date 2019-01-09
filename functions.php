<?php

/**
 * Enqueue scripts and styles.
 */

if(!defined('DEBUG_SPARKLING_CHILD')){
    define('DEBUG_SPARKLING_CHILD', false);
}


function acd_scripts() {
    $parent_style = 'sparkling-style';

    wp_enqueue_style(
        $parent_style,
        get_template_directory_uri() . '/style.css'
    );
    wp_enqueue_style(
        'acd-sparkling-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );

    $google_font_query_args = array(
        'family' => urlencode('Yanone Kaffeesatz:400,700:latin|IM Fell DW Pica:400|IM Fell DW Pica SC:400'),
    );
    wp_register_style( 'acd-google-fonts', add_query_arg( $google_font_query_args, "//fonts.googleapis.com/css" ), array(), null );
    wp_enqueue_style('acd-google-fonts');

    wp_enqueue_script( 'acd-sparkling-child-tether', get_stylesheet_directory_uri(). '/inc/js/tether.min.js', array('jquery') );
    wp_enqueue_script( 'acd-sparkling-child-functions', get_stylesheet_directory_uri(). '/inc/js/functions.min.js', array('jquery', 'sparkling-bootstrapjs') );

    wp_enqueue_script( 'acd-pingdom-rum', '//rum-static.pingdom.net/pa-5c35540f9a3f8300160002f8.js', array(), null);


}
add_action( 'wp_enqueue_scripts', 'acd_scripts' );


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
    if(DEBUG_SPARKLING_CHILD) {
        error_log("typography options:".serialize($typography_options));
    }
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

/**
 * WooCommerce Xero Invoice edits
 */

function acd_woocommerce_xero_invoice_to_xml_edit($xml, $_this){

    if(WP_DEBUG) error_log("received xml ".serialize($xml));

    // //Debugging line tax rates
    //
    // // Get Line Items
    // $line_items = $_this->get_line_items();
    //
    // $line_items_xml = '';
    //
    // // Check line items
    // if ( count( $line_items ) ) {
    //
    //     // Line Items wrapper open
    //     $line_items_xml .= '<LineItems>';
    //
    //     // Loop
    //     foreach ( $line_items as $line_item ) {
    //
    //         // if(WP_DEBUG) error_log("line_item ".print_r($line_item, true));
    //         $tax_rate = $line_item->get_tax_rate();
    //         $tax_type = '';
    //
    //         if(WP_DEBUG) {
    //             error_log("settings ".print_r($line_item->settings, true));
    //             error_log("tax_rate ".print_r($tax_rate, true));
    //         }
    //
    //
    //         $tax_type_request = new WC_XR_Request_Tax_Rate( $line_item->settings, $tax_rate['rate'], $tax_rate['label'] );
    //         $tax_type_request->do_request();
    //         $xml_response = $tax_type_request->get_response_body_xml();
    //         if(WP_DEBUG) error_log("WC_XR_Request_Tax_Rate response ".print_r($xml_response, true));
    //
    //         if ( empty ( $xml_response->TaxRates->TaxRate ) ) {
    //             $tax_type_create_request = new WC_XR_Request_Update_Tax_Rate( $line_item->settings, $tax_rate );
    //             $tax_type_create_request->do_request();
    //             $xml_response = $tax_type_create_request->get_response_body_xml();
    //
    //             if(WP_DEBUG) error_log("WC_XR_Request_Update_Tax_Rate response ".print_r($xml_response, true));
    //         }
    //
    //         if ( ! empty( $xml_response->TaxRates->TaxRate->TaxType ) ) {
    //             $tax_type = $xml_response->TaxRates->TaxRate->TaxType->__toString();
    //         }
    //
    //         // Add
    //         $line_items_xml .= $line_item->to_xml();
    //
    //     }
    //
    //     // Line Items wrapper close
    //     $line_items_xml .= '</LineItems>';
    // }
    //
    //
    // if(WP_DEBUG) error_log("LineItems xml ".serialize($line_items_xml));

    // change "<Status>AUTHORISED</Status>" to "<Status>DRAFT</Status>"

    $xml = preg_replace("/<Status>AUTHORISED<\/Status>/", "<Status>DRAFT</Status>", $xml);

    // change "</DueDate>" to "</DueDate><Reference>"

    $reference_xml = '';
    $order_number = '';
    $order = $_this->get_order();
    if($order){
        $order_number = $order->get_order_number();
    }
    $reference_xml .= '<Reference>' . 'invoice#' . $order_number . '</Reference>';

    if(WP_DEBUG) error_log("due_date xml ".serialize($reference_xml));

    // Delete old <Reference/> XML:

    $xml = preg_replace("/<Reference>[^<]*<\/Reference>/", "", $xml);

    $xml = preg_replace("/<\/DueDate>/", "</DueDate>{$reference_xml}", $xml);

    // Fix tax codes so that they are GST on Income

    $xml = preg_replace("/<TaxType>TAX\d+<\/TaxType>/", "<TaxType>OUTPUT</TaxType>", $xml);

    if(WP_DEBUG) error_log("returning xml ".serialize($xml));

    return $xml;
}

add_filter('woocommerce_xero_invoice_to_xml', 'acd_woocommerce_xero_invoice_to_xml_edit', 0, 2);

/**
 * Overwrite Sparkling main content bootstrap classes
 */

 function sparkling_main_content_bootstrap_classes() {
     if ( is_page_template( 'page-fullwidth.php' ) ) {
         return 'col-sm-12 col-md-12';
     } else if ( is_page_template( 'page-home.php' ) ) {
         return 'container';
     }
     return 'col-sm-12 col-md-8';
 }


/**
 * Disable Jetpack Devicepx Script
 */
function disable_devicepx() {
    wp_dequeue_script( 'devicepx' );
}
add_action( 'wp_enqueue_scripts', 'disable_devicepx' );

/**
 * conditionally hide afterpay messages for customers matching a list of roles
 */
function sparkling_conditional_hide_afterpay($html) {
    if( is_user_logged_in() ) {
        $user = wp_get_current_user();
        $roles = ( array ) $user->roles;
        $hidden_roles = of_get_option('hide_afterpay_roles', '');
        $hidden_roles = explode('|', $hidden_roles);
        if ($roles && array_intersect($hidden_roles, $roles)) {
            return "";
        }
    }
    return $html;
}

foreach (array(
    "afterpay_html_on_product_thumbnails",
    "afterpay_html_on_individual_product_pages",
    "afterpay_html_on_cart_page"
) as $output_filter) {
    add_filter($output_filter, 'sparkling_conditional_hide_afterpay', 10);
}
