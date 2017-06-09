<?php
/* *
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package sparkling-child
 */

if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)) header('X-UA-Compatible: IE=edge,chrome=1'); ?>
<!doctype html>
<!--[if !IE]>
<html class="no-js non-ie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]>
<html class="no-js ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]>
<html class="no-js ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9 ]>
<html class="no-js ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="<?php echo of_get_option( 'nav_bg_color' ); ?>">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
<?php

	$icon_container = 'div';
	$header_classes = array(
		'site-header'
	);
	$header_content_classes = array(
		'header-content'
	);
	$nav_classes = array(
		'navbar',
		// 'navbar-default',
		'navbar-inverted'
		// 'navbar-derwent',
	);
	$nav_header_classes = array(
		'navbar-header',
		'navbar-right',
		'container-fluid'
	);
	// $nav_header_classes = array(
	// 	'navbar',
	// 	// 'navbar-nav',
	// 	'navbar-form',
	// 	'clearfix',
	// 	// 'navbar-right'
	// );
	$nav_content_classes = array(
		'navbar-content',
		// 'container-fluid',
		// 'container'
	);

	$branding_classes = array();
	$icon_container_classes = array(
		'navbar',
		// 'navbar-form',
		// 'navbar-right',
		// 'clearfix',
		// 'pull-left',
		// 'pull-right',
		// 'hidden-xs'
	);
	// $icon_container_classes = array(
	// 	// 'navbar',
	// 	// 'navbar-form',
	// 	// 'navbar-right'
	// 	'clearfix'
	// );
	$icon_a_classes = array(
		'btn',
		'navbar-toggle',
		'btn-square',
	);
    $title_d_classes = array(
        'icon-title'
    );
	// $icon_a_classes = array(
	// 	'btn',
	// 	'navbar-btn',
	// 	'btn-square'
	// );
	$icon_i_classes = array(
		'fa',
		'fa-lg',
	);
	if( of_get_option('constrain_header') ) {
		$header_classes[] = 'container';
		// $header_content_classes[] = 'container-fluid';
	} else {
		$header_classes[] = 'container-fluid';
		$header_content_classes[] = 'container';
	}

	$header_icons = array();
	if ( is_user_logged_in() ){
		$header_icons[] = array(
			'icon'=>'user',
			'link'=>site_url( "/my-account"),
			'title'=>'My Account',
            'show_title'=>False
		);
		$header_icons[] = array(
			'icon'=>'sign-out',
			'link'=>wp_logout_url( ),
			'title'=>'Sign out',
            'show_title'=>True
		);
	} else {
		$header_icons[] = array(
			'icon'=>'sign-in',
			'link'=>wp_login_url( ),
			'title'=>__('Log in'),
            'show_title'=>True
		);
		$header_icons[] = array(
			'icon'=>'user-plus',
			'link'=>site_url( "/wholesale-access" ),
			'title'=>'Create Account',
            'show_title'=>False
		);
	}

	function get_icons($header_icons, $icon_container='div',
        $icon_container_classes, $icon_i_classes, $icon_a_classes,
        $title_d_classes)
	{
		$out = '';
		if(!empty($header_icons)){
			// $out .= "<{$icon_container}";
			// $out .="  class=\"";
			// $out .=   	implode(' ', $icon_container_classes);
			// $out .= " \">";
			foreach($header_icons as $header_icon){
				$defaults = array(
					'icon'=>'question',
					'link'=>'#',
					'title'=>'title',
                    'show_title'=>False,
				);
				$header_icon = array_merge($defaults, $header_icon);
				// $out .= "<li>";
				$out .= "<a";
				$out .= "   href=\"{$header_icon['link']}\"";
				$out .= "   title=\"{$header_icon['title']}\"";
				$out .= "   class=\"";
				$out .= 		implode(" ", $icon_a_classes);
				$out .= 		" show\"";
				$out .= "   data-toggle=\"tooltip\" data-placement=\"bottom\">";
				$out .= "<i class=\"";
				$out .=     	implode(' ', $icon_i_classes);
				$out .= 		" fa-{$header_icon['icon']}\"";
				$out .= 		" aria-hidden=\"true\"></i>";
                if($header_icon['show_title']){
                    $out .= "<div class=\"";
                    $out .= implode(' ', $title_d_classes);
                    $out .= "\">";
                    $out .= $header_icon['title'];
                    $out .="</div>";
                }
				$out .= "</a>";
				// $out .= "</li>";
			}
			// $out .= "</$icon_container>";
		}
		return $out;
	}

	function get_branding($branding_classes){
		$out = "<div id=\"branding\" class=\"";
		$out .= implode(' ', $branding_classes);
		$out .= "\">";
		if( get_header_image() != '' ) {
			$out .= "<a ";
			$out .= "   class=\"centre-block\"";
			$out .= "   href=\"" . esc_url( home_url( '/' ) ). "\">";
			$out .= "<img ";
			$out .= "     class=\"img-responseive\"";
			$out .= "     src=\"" . get_header_image() . "\"";
			$out .= " 	  height=\"" . get_custom_header()->height . "\"";
			$out .= " 	  width=\"" . get_custom_header()->width . "\"";
			$out .= " 	  alt=\"" . get_bloginfo( 'name' ) . "\"";
			$out .= " 	  />";
			$out .= "</a>";
		} else {
			$a_tag = "<a class=\"navbar-brand\"";
			$a_tag .= "  href=\"" . esc_url( home_url( '/' ) ) . "\"";
			$a_tag .= "  title=\"" . esc_attr( get_bloginfo( 'name', 'display' ) ) . "\"";
			$a_tag .= "  rel=\"home\">";
			$a_tag .= bloginfo( 'name' );
			$a_tag .= "</a>";
			if( is_home() ){
				$out .= '<h1 class="site-name">' . $a_tag . '</h1>';
			} else {
				$out .= '<p class="site-name">' . $a_tag . '</p>';
			}
		}
		$out .= "</div> <!-- end of #branding -->";
		return $out;
	}

    function acd_output_header_message() {
        $enable = of_get_option('enable_header_message');

        if( $enable ){
            $message = of_get_option('header_message');
            if(!empty($message)){
                $out = $message;
                $out = "<div class=\"" . implode(" ", array('header-message-inner')) . "\">"
                    . $out
                    . "</div>";
                $out = "<div class=\"" . implode(" ", array('header-message')) . "\">"
                    . $out
                    . "</div>";
                echo( $out );
            }
        }
    }
?>

<a class="sr-only sr-only-focusable" href="#content">Skip to main content</a>
<div id="page" class="hfeed site">
	<header id="masthead" class="<?php echo implode(' ', $header_classes); ?>" role="banner">
		<div class="<?php echo implode(' ', $header_content_classes); ?>">
			<?php echo get_branding($branding_classes); ?>
			<nav class="<?php echo implode(' ', $nav_classes); ?>" role="navigation">
				<div class="<?php echo implode(' ', $nav_header_classes); ?>">
					<a type="button" class="<?php echo implode(' ', $icon_a_classes); ?>" data-toggle="collapse" data-target=".navbar-ex1-collapse">
						<span class="sr-only">Toggle navigation</span>
						<i class="<?php echo implode(' ', $icon_i_classes); ?> fa-bars" aria-hidden="true"></i>
					</a>
					<?php echo get_icons($header_icons, $icon_container,
                        $icon_container_classes, $icon_i_classes, $icon_a_classes,
                        $title_d_classes); ?>
				</div>
				<div class="<?php echo implode(' ', $nav_content_classes); ?>">
					<?php acd_header_menu(); // main navigation ?>
				</div>
			</nav>
            <?php acd_output_header_message(); ?>
		</div><!-- .header-content -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">

		<div class="top-section">
			<?php sparkling_featured_slider(); ?>
			<?php sparkling_call_for_action(); ?>
		</div>

		<div class="container main-content-area">
            <?php $layout_class = get_layout_class(); ?>
			<div class="row <?php echo $layout_class; ?>">
				<div class="main-content-inner <?php echo sparkling_main_content_bootstrap_classes(); ?>">
