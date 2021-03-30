<div class="col-12">

    <?php if ( have_posts() ) : ?>

	<div class="heading-archive">

		<?php the_archive_title('<h1>','</h1>') ?>

	</div>

	<div class="blog-content">

		<div class="list-article-content blog-posts">

	        <div class="row">

				<?php while ( have_posts() ) : the_post(); ?>

					<!-- Begin: Nội dung blog -->

	                <div class="col-12 col-md-6 col-lg-4 mb-5">

	                    <div class="card post-items">

	                        <a class="image-blog" href="<?php the_permalink(); ?>">

	                            <?php if ( has_post_thumbnail() ) : ?>

				                  <?php the_post_thumbnail(); ?>

				                <?php elseif ( !has_post_thumbnail() ) : ?>

				                  <img src="<?php bloginfo( 'url' ); ?>/wp-content/themes/vdigi/assets/images/default-thumbnail.jpg">

				                <?php endif; ?>

	                        </a>

	                        <div class="card-body">

	                            <h3 class="card-title card-title-style">

	                                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>

	                            </h3>

	                            <p class="card-text card-text-style"><?php echo get_the_excerpt() ?></p>

	                            <a href="<?php the_permalink(); ?>" class="btn btn-primary">Xem thêm</a>

	                        </div>

	                    </div>

	                </div>

				<?php endwhile; ?>

			</div> 
			<!-- END ROW POST -->

			<div class="row">

				<div class="col-12 text-center">

			        <!-- Phân Trang -->

					<?php get_template_part( 'category-templates/pagination/pagination' );  ?>

					<!-- End Phân Trang -->

				</div>

			</div> 
			<!-- END ROW PAGINATION -->

		</div>

     </div>
     <!-- end blog content -->

	 <?php else :

		get_template_part( 'template-parts/content', 'none' );

	 endif; ?>

</div>

<!-- /.col-12 -->

