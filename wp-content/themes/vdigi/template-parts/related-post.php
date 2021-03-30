<section class="related__post my-4">
	<div class="title__related">
		<h2><span>Tin liên quan</span></h2>
	</div>
	<ul class="related__list">
          <?php
              $categories = get_the_category($post->ID);
              if ($categories) 
              {
                  $category_ids = array();
                  foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
           
                  $args=array(
                  'category__in' => $category_ids,
                  'post__not_in' => array($post->ID),
                  'showposts'=>5, // Số bài viết bạn muốn hiển thị.
                  'caller_get_posts'=>1
                  );
                  $my_query = new wp_query($args);
                  if( $my_query->have_posts() ) 
                  {                      
                      while ($my_query->have_posts())
                      {
                          $my_query->the_post(); ?>
                          <li>                                               
                            <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>    
                          </li>
                          <?php
                      }                      
                  }
              }
          ?>
	</ul>
</section>