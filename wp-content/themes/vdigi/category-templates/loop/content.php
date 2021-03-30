<div class="col-12 col-md-6 col-lg-4 mt-4">
    <div class="card">
        <a class="image-blog" href="<?php the_permalink(); ?>">
            <?php the_post_thumbnail(); ?>
        </a>
        <div class="card-body">
            <h3 class="card-title card-title-style">
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
            </h3>
            <p class="card-text card-text-style"><?php echo get_the_excerpt() ?></p>
            <a href="<?php the_permalink() ?>" class="btn btn-primary">Xem thêm</a>
        </div>
    </div>
</div>