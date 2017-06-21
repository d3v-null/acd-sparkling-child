<?php
/**
 * Template Name: Home (Sparkling Child)
 *
 * This is the template that displays the home page
 *
 * @package sparkling-child
 */

 get_header(); ?>

   <div id="primary" class="content-area homepage">

     <main id="main" class="site-main">

       <?php while ( have_posts() ) : the_post(); ?>

         <?php get_template_part( 'content', 'homepage' ); ?>

       <?php endwhile; // end of the loop. ?>

     </main><!-- #main -->

   </div><!-- #primary -->

 </div><!-- close .main-content-inner -->

 <?php get_footer(); ?>
