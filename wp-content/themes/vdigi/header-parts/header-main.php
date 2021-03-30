<div class="header__main d-none d-lg-block d-xl-block">

    <div class="container">

        <div class="row align-items-center">

            <div class="col-md-3">

                <div class="header__main__logo">

                    <a href="<?php echo home_url(); ?>" class="header__logo__link">

                        <?php $logo = get_field('logo', 'options'); ?>

                        <img src="<?php echo $logo['url']; ?>" alt="Logo Website">

                    </a>

                </div>

            </div>

            <!-- Logo header -->

            <div class="col-md-6">

                <div class="header__main__info">

                    <h2 class="text-center">CÔNG TY TNHH CÔNG NGHÊ VIRTUE</h2>

                    <p class="text-center">Địa chỉ: <?php the_field('dia_chi', 'options'); ?></p>

                </div>

            </div>

            <!-- Info website -->

            <div class="col-md-3">

                <div class="hotline text-center">

                    <span><?php the_field('hotline', 'options'); ?></span>

                </div>

            </div>

            <!-- Hotline -->

        </div>

    </div>

</div>

<!-- end header main -->

<section id="menu-screen">

    <div class="header__menu d-none d-lg-block d-xl-block">

        <?php wp_nav_menu(array('theme_location' => 'menu-1')); ?>

    </div>

</section>

