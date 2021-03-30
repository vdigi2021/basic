	<div class="col-lg-9 col-12">		

		<?php

		if ( have_posts() ) : ?>

			<div class="heading-archive">

				<?php the_archive_title( '<h1>', '</h1>' ); ?>

			</div>
			<!-- .page-header -->
			
            <div class="blog-content">

				<div class="row">

	                <?php

	                /* Start the Loop */

	                while ( have_posts() ) : the_post();

	                    get_template_part( 'category-templates/loop/content', get_post_format() );

	                endwhile; ?>

	            </div>

            </div>

		    <!-- Phân Trang -->

		    <?php get_template_part( 'category-templates/pagination/pagination' );  ?>

		    <!-- End Phân Trang -->

		<?php else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

	</div>

	<!-- /.col-md-9 -->

	<div class="col-lg-3 d-none d-lg-block">	

		<?php get_sidebar(); ?>

	</div>

	<!-- /.col-md-3 -->