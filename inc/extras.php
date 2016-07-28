<?php
if ( ! function_exists( 'get_acd_theme_options' ) ) {
    /**
     * Get information from Theme Options and add it into wp_head
     */
    function get_acd_theme_options(){
        echo '<style type="text/css">';
        global $typography_options;
        $typography = of_get_option('heading_typography');
        if ( $typography ) {
            $css_line = 'h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, .entry-title {';
            if(isset($typography_options['faces'][$typography['face']])){
                $css_line .= 'font-family: '. $typography_options['faces'][$typography['face']];
            }
            if(isset($typography_options['style'])){
                $css_line .= '; font-weight: ' . $typography['style'];
            }
            // . '; font-size:' . $typography['size']
            //   . '; color:'.$typography['color']
            $css_line .= ';} ';
            echo $css_line;
        }

        $page_width = of_get_option('page_width');
        if ( $page_width ) {
            echo "header#masthead nav { max-width:{$page_width}px; margin: 0 auto;}";
        }
        echo '</style>';
    }

}


add_action( 'wp_head', 'get_acd_theme_options', 10 );

?>
