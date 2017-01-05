<?php

if ( ! function_exists( 'get_acd_theme_options' ) ) {
    /**
     * Get information from Theme Options and add it into wp_head
     */
    function get_acd_theme_options(){
        echo '<style id="acd-theme-options" type="text/css">';
        echo "/* Defined in ACD theme options of inc/extras.php */\n";

        function get_typography_css_rules($typography){
            global $typography_options;
            $rules = array();
            if ( !empty($typography ) ) {
                if(isset($typography_options['faces'][$typography['face']])){
                    $rules[] = 'font-family: '. $typography_options['faces'][$typography['face']];
                }
                if(isset($typography_options['style'])){
                    $rules[] = 'font-weight: ' . $typography['style'];
                }
                if(isset($typography['color'])){
                    $rules[] = 'color: '. $typography['color'];
                }
            }
            $response = implode('; ', $rules);
            // echo "/* typography_options: ".serialize($typography_options)." */\n";
            // echo "/* typography array: ".serialize($typography)." */\n";
            // echo "/* rules: ".serialize($rules)." */\n";
            // echo "/* response: ".serialize($response)." */\n";
            return $response;
        }

        function hex2rgba($color, $opacity=false ){

            $default = 'rgb(0,0,0)';

            //Return default if no color provided
            if(empty($color))
            return $default;

            //Sanitize $color if "#" is provided
            if ($color[0] == '#' ) {
                $color = substr( $color, 1 );
            }

            //Check if color has 6 or 3 characters and get values
            if (strlen($color) == 6) {
                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
            } elseif ( strlen( $color ) == 3 ) {
                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
            } else {
                return $default;
            }

            //Convert hexadec to rgb
            $rgb =  array_map('hexdec', $hex);

            //Check if opacity is set(rgba or rgb)
            if($opacity){
                if(abs($opacity) > 1)
                    $opacity = 1.0;
                $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
            } else {
                $output = 'rgb('.implode(",",$rgb).')';
            }

            //Return rgb(a) color string
            return $output;
        }

        $heading_typography = of_get_option('heading_typography');
        // echo "/* heading typography: ".serialize($heading_typography)." */\n";

        $heading_typo_css = get_typography_css_rules($heading_typography);
        // echo "/* heading typo css: ".serialize($heading_typo_css)." */\n";
        if(!empty($heading_typo_css)){
            echo " h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, .entry-title { $heading_typo_css ;} \n";
        }


        $header_content_css = '';
        // $page_width = of_get_option('page_width');
        // if ( $page_width ) {
        //     $header_nav_css .= "max-width:{$page_width}px; margin: 0 auto;";
        // }

        $header_content_bg_url = of_get_option('header_background_url');
        if( !empty($header_content_bg_url) ) {
            $header_content_css .= "background-image: url( \"$header_content_bg_url\"); ";
            $header_content_css .= "background-position: bottom; ";
            $header_content_css .= "background-size: cover; ";
        }

        if(!empty($header_content_css)){
            echo " header#masthead { $header_content_css ;} \n";
        }

        $navbar_css = '';
        $navbar_typography = of_get_option('navbar_typography');
        if(of_get_option('nav_link_color')){
            $navbar_typography['color'] = of_get_option('nav_link_color');
        }
        $navbar_typo_css = get_typography_css_rules($navbar_typography);
        if(!empty($navbar_typo_css)){
            echo ".navbar a { $navbar_typo_css ;} \n";
        }

        // $header_nav_menu_css = '';
        // $header_nav_position = of_get_option('header_nav_position');
        // $header_nav_position_str = $typography_options['horizontal-positions'][$header_nav_position];
        // if( !empty($header_nav_position_str)){
        //     $header_nav_menu_css .= " /* position: $header_nav_position_str; */ ";
        //     switch ($header_nav_position_str) {
        //         case 'left':
        //         case 'right':
        //             $header_nav_menu_css .= "float: $header_nav_position_str; ";
        //             break;
        //         case 'center':
        //         default:
        //             $header_nav_menu_css .=
        //                 "float: left; position: relative; left:50%; transform: translate(-50%, 0);";
        //                 // TODO FIX this for better browser compat, something like;
        //                 // "float: none; display: block; margin: auto;";
        //             break;
        //     }
        // }

        // if(!empty($header_nav_menu_css)){
        //     echo " header#masthead nav ul.nav { $header_nav_menu_css ;} ";
        // }

        $carousel_typography = array(
            '.entry-title'=>array(),
            '.excerpt'=>array()
        );
        $carousel_caption_background_opacity = 1.0;
        if(of_get_option('carousel_caption_background_opacity')){
            // echo "/* raw opacity: ".serialize(of_get_option('carousel_caption_background_opacity'))."*/\n";
            $carousel_caption_background_opacity = floatval(of_get_option('carousel_caption_background_opacity'));
            // echo "/* floatval: ".serialize($carousel_caption_background_opacity)."*/\n";

        }
        if(of_get_option('carousel_title_background_color')){
            $carousel_typography['.entry-title']['background'] =
                hex2rgba(
                    of_get_option('carousel_title_background_color'),
                    $carousel_caption_background_opacity
                );
        }
        if(of_get_option('carousel_excerpt_background_color')){
            $carousel_typography['.excerpt']['background'] =
                hex2rgba(
                    of_get_option('carousel_excerpt_background_color'),
                    $carousel_caption_background_opacity
                );
        }
        if(of_get_option('carousel_title_text_color')){
            $carousel_typography['.entry-title']['color'] =
                of_get_option('carousel_title_text_color');
        }
        if(of_get_option('carousel_excerpt_text_color')){
            $carousel_typography['.excerpt']['color'] =
                of_get_option('carousel_excerpt_text_color');
        }

        // echo "/* carousel_typography: ".serialize($carousel_typography)."*/\n";
        // echo "/* carousel_caption_background_opacity: ".serialize($carousel_caption_background_opacity)."*/\n";

        foreach ($carousel_typography as $selector => $properties) {
            if (! empty($properties)){
                $css_pieces = array();
                foreach ($properties as $property => $value) {
                    $css_pieces[] = "$property: $value";
                }
                echo "#content .flexslider ".$selector."{".
                    implode('; ', $css_pieces).
                    "} \n";
            }
        }

        if(of_get_option('highlight_color')){
            $highlight_color = of_get_option('highlight_color');
            echo ".woocommerce div.product p.price, .woocommerce div.product span.price { color: $highlight_color; }\n";
            // echo ".woocommerce div.product .stock { color: $highlight_color ; }\n";
            echo ".woocommerce span.onsale { background-color: $highlight_color ; }\n";
            echo ".woocommerce ul.products li.product .price { color: $highlight_color ; }\n";
        }

        echo '</style>';

        /**
         * Add notice to cart
         */

        function acd_output_cart_notices() {
            $enable = of_get_option('enable_checkout_message');
            if(WP_DEBUG) error_log("acd_output_cart_notices enable_checkout_message "
                .serialize($enable));

            if( $enable ){
                if(WP_DEBUG) error_log("acd_output_cart_notices enable_checkout_message true");

                $message = of_get_option('checkout_message');
                if(WP_DEBUG) error_log("acd_output_cart_notices checkout_message"
                    .serialize($message));
                if(!empty($message)){
                    wc_add_notice( $message );
                }
            }
        }

        add_action('woocommerce_before_cart_contents', 'acd_output_cart_notices');
    }

}

if ( ! function_exists( 'acd_header_menu' ) ) :
/**
 * Header menu (should you choose to use one)
 */
function acd_header_menu() {
  // display the WordPress Custom Menu if available
  wp_nav_menu(array(
    'menu'              => 'primary',
    'theme_location'    => 'primary',
    'depth'             => 2,
    'container'         => 'div',
    'container_class'   => 'collapse navbar-collapse navbar-ex1-collapse navbar-left',
    'menu_class'        => 'nav navbar-nav',
    'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
    'walker'            => new wp_bootstrap_navwalker()
  ));
} /* end header menu */
endif;


add_action( 'wp_head', 'get_acd_theme_options', 10 );

?>
