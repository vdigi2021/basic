<div class="col-lg-3 d-none d-lg-block">

    <?php get_sidebar(); ?>

</div>

<!-- /.col-lg-3 -->

<div class="col-lg-9 col-12">

    <?php if (have_posts()) : ?>

    <div class="heading-archive">

        <?php the_archive_title('<h1>','</h1>') ?>

    </div>

    <div class="blog-content">

        <div class="list-article-content blog-posts">

            <?php while (have_posts()) : the_post(); ?>

                <!-- Begin: Nội dung blog -->

                <article class="blog-loop">

                    <div class="blog-post">

                        <div class="card mb-3">

                            <div class="row">

                                <div class="col-md-4 card-image pr-md-0">

                                    <a href="<?php the_permalink(); ?>">

                                        <?php the_post_thumbnail() ?>

                                    </a>

                                </div>

                                <div class="col-md-8 pl-md-0">

                                    <div class="card-body">

                                        <h3 class="card-title card-title-style">

                                            <a href="<?php the_permalink(); ?>"><?php the_title() ?></a>

                                        </h3>

                                        <p class="card-text card-text-style">

                                            <?php echo get_the_excerpt() ?>

                                        </p>

                                        <p class="card-text">

                                            <small class="text-muted">Ngày đăng: <?php echo get_the_date() ?></small>

                                        </p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </article>

            <?php endwhile; ?>

            <!-- Phân Trang -->

            <?php get_template_part('category-templates/pagination/pagination'); ?>

            <!-- End Phân Trang -->

            <?php else :

                get_template_part('template-parts/content', 'none');

            endif; ?>

        </div>

    </div>

</div>

<!-- /.col-lg-9 -->