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
            echo 'h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, .entry-title {'
                .'font-family: '. $typography_options['faces'][$typography['face']]
                // . '; font-size:' . $typography['size']
                . '; font-weight: ' . $typography['style']
                //   . '; color:'.$typography['color']
                . ';}';
            }
        echo '</style>';
    }

}


add_action( 'wp_head', 'get_acd_theme_options', 10 );

?>
