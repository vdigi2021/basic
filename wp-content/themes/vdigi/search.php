<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package WP_Bootstrap_4
 */

get_header(); ?>

<?php
	$default_sidebar_position = get_theme_mod( 'default_sidebar_position', 'right' );
?>

	<div class="container">
		<div class="row">

				<div class="col-md-12 wp-bp-content-width">

					<section id="primary" class="content-area">
						<main id="main" class="site-main">

						<?php
						if ( have_posts() ) : ?>

							<header class="page-header mt-3r">
								<h1 class="page-title"><?php
									/* translators: %s: search query. */
									printf( esc_html__( 'Kết quả tìm kiếm: %s', 'wp-bootstrap-4' ), '<span>' . get_search_query() . '</span>' );
								?></h1>
							</header><!-- .page-header -->
                            <div class="row">
							<?php
							/* Start the Loop */
							while ( have_posts() ) : the_post();

								/**
								 * Run the loop for the search to output the results.
								 * If you want to overload this in a child theme then include a file
								 * called content-search.php and that will be used instead.
								 */
								get_template_part( 'template-parts/content', 'search' );

							endwhile; ?>

							</div>

                        <?php 
						/** Phân Trang **/
						       get_template_part( 'category-parts/pagination/pagination' );
					    /** End Phân Trang **/

						else :

							get_template_part( 'template-parts/content', 'none' );

						endif; ?>

						</main><!-- #main -->
					</section><!-- #primary -->

				</div>
				<!-- /.col-md-12 -->

		</div>
		<!-- /.row -->
	</div>
	<!-- /.container -->

<?php
get_footer();
