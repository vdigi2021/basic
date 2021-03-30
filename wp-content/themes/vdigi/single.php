<?php

/**

 * The template for displaying all single posts

 *

 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post

 *

 * @package WP_Bootstrap_4

 */



get_header(); ?>

<?php cat_breadcrumbs() ?>

<div class="wrapper-single">

	<div class="container">

		<div class="row">

            <?php get_template_part( 'single-templates/right-sidebar', get_post_type() ); ?>


		</div>

		<!-- /.row -->

	</div>

	<!-- /.container -->

</div>

<?php

get_footer();

