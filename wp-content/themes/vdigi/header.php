<?php

/**

 * The header for our theme

 *

 * This is the template that displays all of the <head> section and everything up until <div id="content">

 *

 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials

 *

 * @package WP_Bootstrap_4

 */



?>

<!doctype html>

<html <?php language_attributes(); ?>>

<head>

	<meta charset="<?php bloginfo( 'charset' ); ?>">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="profile" href="http://gmpg.org/xfn/11">

	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php if(is_home() || is_front_page()) { ?>

	   <title><?php $seo = get_field('thong_tin_seo','option'); echo $seo['title']; ?></title>

	   <meta name="description" content="<?php echo $seo['description']; ?>">

       <meta name="keywords" content="<?php echo $seo['meta_keyword']; ?>">

	<?php } else { ?>

       <title><?php wp_title(); ?></title>

	<?php } ?>



    <link rel="shortcut icon" type="image/png" href="<?php $favicon = get_field('favicon','option');  echo $favicon['url']; ?>"/>   



	<?php wp_head(); ?>

	    <link rel="stylesheet" type="text/css" href="<?php bloginfo( 'url' ); ?>/wp-content/themes/vdigi/style.css">

	    <!-- Analytics -->

	    <?php if( get_field('google_analytics', 'option')): ?>		    

		    <?php the_field('google_analytics', 'option'); ?>

	    <?php endif; ?>

	    <!-- Code Chat -->

	    <?php if( get_field('code_chat', 'option')): ?>

	        <?php the_field('code_chat', 'option'); ?>

	    <?php endif; ?>

</head>



<!-- Start CSS Banner Header -->

<style type="text/css">

	    @media (min-width:1024px) {

	           .header-main{

	          background-image:url('<?php $banner = get_field('banner_top_pc','option');  echo $banner['url']; ?>');

	          background-size: cover;

	        }

        }

	    @media (max-width:1023px) {

	           .header-main{

	          background-image:url('<?php $banner_mb = get_field('banner_top_mb','option');  echo $banner_mb['url']; ?>');

	        }

        }

</style>

<!-- End CSS Banner Header -->



<body <?php body_class(); ?>>

<main id="page" class="site">

	<header id="masthead" class="site-header">

		<?php get_template_part( 'header-parts/header-main' ); ?>

		<!-- Header Main -->

		<?php get_template_part( 'header-parts/header-bottom'); ?>

		<!-- Header Bottom -->

		<?php get_template_part( 'header-parts/header-mobile'); ?>

	</header><!-- #masthead -->



	<div id="content" class="site-content">

