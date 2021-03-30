<?php

/**

 * The template for displaying the footer

 *

 * Contains the closing of the #content div and all content after.

 *

 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials

 *

 * @package WP_Bootstrap_4

 */



?>



</div><!-- #content -->



<footer id="footer" class="footer_area">

    <?php get_template_part('/footer-parts/footer-main'); ?>

    <?php get_template_part('/footer-parts/copyright'); ?>

</footer><!-- #colophon -->

</main><!-- #page -->



<?php wp_footer(); ?>

<script type="text/javascript">;</script>



<!-- Load Facebook SDK for JavaScript -->

<div id="fb-root"></div>

<script>(function (d, s, id) {

        var js, fjs = d.getElementsByTagName(s)[0];

        if (d.getElementById(id)) return;

        js = d.createElement(s);

        js.id = id;

        js.src = "https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v3.0";

        fjs.parentNode.insertBefore(js, fjs);

    }(document, 'script', 'facebook-jssdk'));</script>


    <!-- Code geo meta -->

    <?php if( get_field('geo_meta', 'option')): ?>

        <?php the_field('geo_meta', 'option'); ?>

    <?php endif; ?>


<!-- Back To Top -->

<a href="#" class="cd-top cd-is-visible"><i class="fa fa-long-arrow-up"></i></a>


</body>

</html>

