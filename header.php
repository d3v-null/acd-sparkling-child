<?php
/* *
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package sparkling
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
<a class="sr-only sr-only-focusable" href="#content">Skip to main content</a>
<div id="page" class="hfeed site">

	<header id="masthead" class="site-header" role="banner">
		<?php
		 	$nav_classes = array('navbar', 'navbar-default');
			$sub_nav_classes = array('container');
			if( of_get_option('sticky_header') ) {
				$nav_classes[] = 'navbar-fixed-top';
			}
			if( of_get_option('constrain_header') ) {
				$nav_classes[] = 'container';
				$sub_nav_classes = array_diff($sub_nav_classes, array('container'));
			}
		?>
		<nav class="<?php echo implode(' ', $nav_classes); ?>" role="navigation">
			<div class="<?php echo implode(' ', $sub_nav_classes); ?>">
				<?php
					$header_icons = array();
					if ( is_user_logged_in() ){
						$header_icons[] = array(
							'icon'=>'user',
							'link'=>site_url( "/my-account"),
							'title'=>'My Account'
						);
						$header_icons[] = array(
							'icon'=>'sign-out',
							'link'=>wp_logout_url( ),
							'title'=>'Sign out'
						);
					} else {
						$header_icons[] = array(
							'icon'=>'sign-in',
							'link'=>wp_login_url( ),
							'title'=>'Sign in'
						);
						$header_icons[] = array(
							'icon'=>'user-plus',
							'link'=>site_url( "/wholesale-access" ),
							'title'=>'Create Account'
						);
					}

					function get_icons($header_icons)
					{
						$out = '';
						foreach($header_icons as $header_icon){
							$defaults = array(
								'icon'=>'question',
								'link'=>'#',
								'title'=>'title'
							);
							$header_icon = array_merge($defaults, $header_icon);
							$out .= "<a type=\"button\"";
							$out .= "   href=\"{$header_icon['link']}\"";
							$out .= "   title=\"{$header_icon['title']}\"";
							$out .= "   class=\"btn navbar-toggle show\"";
							$out .= "   data-toggle=\"tooltip\" data-placement=\"bottom\">";
							$out .= "<i class=\"fa fa-{$header_icon['icon']} fa-lg\"";
							$out .= "   aria-hidden=\"true\"></i>";
							$out .= "</a>";
						}
						return $out;
					}

					function get_logo(){
						$out = "<div id=\"logo\">";
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
						$out .= "</div> <!-- end of #logo -->";
						return $out;
					}
				?>
				<div class="row">
					<div class="col-xs-9 col-sm-12">
						<div class="fa fa-lg btn navbar-toggle site-navigation-xs-top-hack-spacing visible-xs-block">
							&nbsp;
						</div>
						<div class="navbar-header site-navigation-xs-top-hack-outer">
							<div class="site-navigation-xs-top-hack-inner site-navigation-xs-top-hack-inner-left">
								<?php echo get_logo(); ?>
							</div>
						</div>
					</div>
					<div class="site-navigation-xs-top-inner col-xs-3 col-sm-push-9">
						<div class="fa fa-lg btn navbar-toggle site-navigation-xs-top-hack-spacing visible-xs-block">
							&nbsp;
						</div>
						<div class="navbar-header site-navigation-xs-top-hack-outer">
							<div class="site-navigation-xs-top-hack-inner site-navigation-xs-top-hack-inner-right">
								<?php echo get_icons($header_icons); ?>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-9 col-sm-pull-3">
						<button type="button" class="btn navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
							<span class="sr-only">Toggle navigation</span>
							<i class="fa fa-bars fa-lg" aria-hidden="true"></i>
						</button>
						<?php sparkling_header_menu(); // main navigation ?>
					</div>
				</div>
			</div>
		</nav><!-- .site-navigation -->
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
