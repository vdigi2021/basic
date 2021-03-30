<div class="col-lg-3 d-none d-lg-block">	

	<?php get_sidebar(); ?>

</div>

<!-- /.col-md-3 -->

<div class="col-lg-9 col-12">

    <?php if ( have_posts() ) : ?>

	<div class="heading-archive">

		<?php the_archive_title('<h1>','</h1>') ?>

	</div>

	<div class="blog-content">    

		<div class="row">

		<?php while ( have_posts() ) : the_post(); ?>

		<!-- Begin: Nội dung blog -->		

		<div class="col-lg-6 col-md-6 col-12">

			<div class="article-item">

				<a class="article-image" href="<?php the_permalink(); ?>">

					<?php if ( has_post_thumbnail() ) : ?>

	                  <?php the_post_thumbnail(); ?>

	                <?php elseif ( !has_post_thumbnail() ) : ?>

	                  <img src="<?php bloginfo( 'url' ); ?>/wp-content/themes/vdigi/assets/images/default-thumbnail.jpg">

	                <?php endif; ?>

				</a>

				<div class="article-info">

					<h5><a href="<?php the_permalink(); ?>" class="article-title"><?php the_title(); ?></a></h5>

					<div class="article-desc">					

						<?php the_excerpt(); ?>					

					</div>

				</div>

		    </div>

		</div>            						

		<?php endwhile; ?>				

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



<style type="text/css">

.article-item {

    margin-bottom: 2rem;

    box-shadow: 1px 2px 6px #3333;

}

.article-item .article-image {

    display: block;

    overflow: hidden;

}

.article-info {

    padding: 0.6rem;

}

.article-item .article-image img {

    width: 100%;

    height: 250px;

    transition: all 1s;

}

.article-item .article-info .article-title {

    font-weight: 600;

    padding: 4px 0px;

    font-size: 18px;

    line-height: 22px;

    display: -webkit-box;

    -webkit-line-clamp: 2;

    overflow: hidden;

    -webkit-box-orient: vertical;

    text-overflow: ellipsis;

}

.article-desc p {

    display: -webkit-box;

    -webkit-line-clamp: 3;

    overflow: hidden;

    -webkit-box-orient: vertical;

    text-overflow: ellipsis;

    line-height: 1.4em;

    margin-bottom: 0;

}

</style>

