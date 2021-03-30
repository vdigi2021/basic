<?php
/*
Template Name: Liên hệ 1
*/
get_header(); ?>
<?php cat_breadcrumbs() ?>


<div class="contact_5">
	<div class="container">
			<div class="contact_5__top">
				<div class="left">
						<h2>Để lại lời nhắn cho chúng tôi</h2>
						<?php echo do_shortcode('[contact-form-7 id="228" title="Form Liên Hệ 2"]') ?>
				</div>
				<!-- end left -->
				<div class="right">
						<h2>Liên hệ</h2>
						<?php the_field( 'contact', 'options' ); ?>
						<h2>Hỗ trợ 24/7</h2>
				</div>
				<!-- end right -->
			</div>
			<!-- end top -->
			
			<div class="contact_5__bottom">
				<h2>Bản đồ</h2>
				<div class="_maps">
					<?php the_field( 'ban_do', 'option' ); ?>
				</div>
			</div>
			<!-- end bottom -->
	</div>


</div>
<!-- end contact -->


<?php get_footer(); ?>