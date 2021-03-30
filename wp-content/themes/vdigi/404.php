<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package WP_Bootstrap_4
 */

get_header(); ?>
    <section id="error">
        <div class="container">
            <div class="error_title">
                <img src="<?php echo IMAGE_URL . '404.svg' ?>">
                <p>Xin lỗi! Trang bạn tìm kiếm không tồn tại</p>
            </div>
            <div class="error_bottom">
                <a href="<?php echo get_home_url() ?>">QUAY LẠI TRANG CHỦ</a>
            </div>
        </div>
    </section>
<?php
get_footer();
