<link rel="stylesheet" href="<?php bloginfo( 'url' ); ?>/wp-content/themes/vdigi/assets/css/slide/animate.min.css">
<section class="slide-homepage">
	<div class="owl-carousel owl-theme" id="owl-slide">
        <?php if ( have_rows( 'slide_style_2', 'option' ) ) : ?>
            <?php while ( have_rows( 'slide_style_2', 'option' ) ) : the_row(); ?>
                <div class="slide-item">
                    <?php $img_slide = get_sub_field( 'img_slide' ); ?>
                    <?php if ( $img_slide ) { ?>
                        <img src="<?php echo $img_slide['url']; ?>" alt="<?php echo $img_slide['alt']; ?>" />
                    <?php } ?> 
                    <?php if ( have_rows( 'content_slide' ) ) : ?>
                        <?php while ( have_rows( 'content_slide' ) ) : the_row(); ?>
                            <div class="o-caption">
                                <h1 data-animation-in="slideInDown" data-animation-out="animate-out zoomOut"><?php the_sub_field( 'title_slide' ); ?></h1>
                                <div class="_content" data-animation-in="lightSpeedIn" data-animation-out="animate-out lightSpeedOut">
                                    <?php the_sub_field( 'content_slide_txt' ); ?>
                                </div>
                                <button class="btn btn-lg" data-animation-in="lightSpeedIn" data-animation-out="animate-out fadeOutRight">XEM CHI TIẾT <i class="fa fa-arrow-right"></i></button>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>            
            <?php endwhile; ?>
        <?php else : ?>
        <?php endif; ?>
	</div>
</section>