<?php

/**

 * The sidebar containing the main widget area

 *

 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials

 *

 * @package WP_Bootstrap_4

 */

?>


<aside id="secondary" class="widget-sidebar">


   <div class="_list_post_sidebar">

   	   <h3 class="_title_sidebar">Bài viết mới nhất</h3>

       <ul class="news__post__list">

        <?php

        $news = new WP_Query(array(

        'post_type'=>'post',

        'orderby' => 'ID',

        'order' => 'DESC',

        'posts_per_page'=> 5));

        ?>

        <?php while ($news->have_posts()) : $news->the_post(); ?>

             <li>

             	 <a href="<?php the_permalink(); ?>" class="d-flex align-items-center">

             	 	<?php the_post_thumbnail(); ?>

             	 	<h5><?php the_title(); ?></h5>

             	 </a>

             </li>

        <?php endwhile ; wp_reset_query() ;?>

       </ul>

   </div>
   <!-- list post -->

</aside><!-- #secondary -->

