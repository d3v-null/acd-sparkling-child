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
				<div class="row">
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

					?>
					<div class="site-navigation-inner col-sm-12 col-xs-6">
						<div class="navbar-header">
							<?php if( get_header_image() != '' ) : ?>

							<div id="logo">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php header_image(); ?>"  height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="<?php bloginfo( 'name' ); ?>"/></a>
							</div><!-- end of #logo -->

							<?php endif; // header image was removed ?>

							<?php if( !get_header_image() ) : ?>

							<div id="logo">
								<?php echo is_home() ?  '<h1 class="site-name">' : '<p class="site-name">'; ?>
									<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
								<?php echo is_home() ?  '</h1>' : '</p>'; ?>
							</div><!-- end of #logo -->

							<?php endif; // header image was removed (again) ?>

						</div>
					</div>
					<div class="site-navigation-innter-bottom col-xs-12 col-sm-9">
						<button type="button" class="btn navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
							<span class="sr-only">Toggle navigation</span>
							<i class="fa fa-bars fa-lg" aria-hidden="true"></i>
						</button>
						<?php sparkling_header_menu(); // main navigation ?>
					</div>
					<div class="site-navigation-innter-icons hide-xs col-sm-3">
						<?php
							foreach($header_icons as $header_icon){
								$defaults = array(
									'icon'=>'question',
									'link'=>'#',
									'title'=>'title'
								);
								$header_icon = array_merge($defaults, $header_icon);
								?>
								<a href="<?php echo $header_icon['link']; ?>" type="button" class="btn navbar-toggle navbar-toggle-show" data-toggle="tooltip" data-placement="bottom" title="<?php echo $header_icon['title']; ?>">
								<i class="fa fa-<?php echo $header_icon['icon']; ?> fa-lg" aria-hidden="true"></i>
								</a>
							<?php }
						?>
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
