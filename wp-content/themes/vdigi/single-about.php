<?php

/*

 * Template Name: Giới Thiệu

 * Template Post Type: post

 */
get_header();  ?>


<?php while ( have_posts() ) : the_post(); ?>

  <?php cat_breadcrumbs() ?>

  <section class="post__about">

    <div class="container">

        <div class="section__title__post mt-5">

           <h1 class="_single_title_about"><?php the_title(); ?></h1>

       </div>


       <div class="about__post__content">

         <?php the_content(); ?>

       </div>

       <?php get_template_part( 'template-parts/social'); ?>

    </div> <!-- end container -->

  </section>

<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>