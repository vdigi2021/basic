<div class="col-12">

	<?php

	while ( have_posts() ) : the_post(); ?>

      <h1 class="_title_single_post"><?php the_title(); ?></h1>

      <div class="_single_content">

      	  <?php the_content(); ?>          	  

      </div>

	<?php endwhile; // End of the loop. ?>

	<!-- social -->        

    <?php get_template_part( 'template-parts/social'); ?>


    <?php get_template_part( 'template-parts/comment-fb'); ?>

	<!-- end social -->

	<?php get_template_part( 'template-parts/related-post'); ?>

	<!-- Tin Liên quan -->	

</div>
<!-- /.col-md-12 -->