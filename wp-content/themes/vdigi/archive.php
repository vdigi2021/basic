<?php

/**

 * The template for displaying archive pages

 *

 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/

 *

 * @package WP_Bootstrap_4

 */

get_header(); ?>

<?php cat_breadcrumbs() ?>

<div class="wrapper-archive">	

	<div class="container">

		<div class="row">

		    <?php get_template_part( 'category-templates/one-column', get_post_format() );  ?>	

		</div>
		<!-- /.row -->

	</div>
	<!-- /.container -->

</div>

<?php get_footer();  ?>