<?php

/*

* Register Menus

*/

function register_my_menu()

{

    register_nav_menu('menu-1', __('Menu Main'));

    register_nav_menu('Menu_2', __('Menu 2'));


}



add_action('init', 'register_my_menu');



function register_widget_init() {

    register_sidebar( array(

        'name'          => 'Sidebar',

        'id'            => 'sidebar',

    ) );

}

add_action('widgets_init', 'register_widget_init');



//*

//* Tự động xóa revision của bài viết

//*

// $wpdb->query("DELETE FROM $wpdb->posts WHERE post_type = 'revision'");



// Add item admin bar

function add_item($admin_bar)

{

    $args = array(

        'id' => 'home-link', // Must be a unique name

        'title' => 'Vào website', // Label for this item

        'href' => __('/'),

        'meta' => array(

            'target' => '_blank', // Opens the link with a new tab

            'title' => __('Vào website'), // Text will be shown on hovering

        ),

    );

    $admin_bar->add_menu($args);

}



add_action('admin_bar_menu', 'add_item', 100); // 10 = Position on the admin bar



// Remove category

add_filter('get_the_archive_title', function ($title) {

    if (is_category()) {

        $title = single_cat_title('', false);

    } elseif (is_tag()) {

        $title = single_tag_title('', false);

    } elseif (is_author()) {

        $title = '<span class="vcard">' . get_the_author() . '</span>';

    }

    return $title;

});





//*

//* Cho phép author chỉ xem được comment của bài họ viết

//*

function get_comment_list_by_user($clauses)

{

    if (is_admin()) {

        global $user_ID, $wpdb;

        $clauses['join'] = ", wp_posts";

        $clauses['where'] .= " AND wp_posts.post_author = " . $user_ID . " AND wp_comments.comment_post_ID = wp_posts.ID";

    };

    return $clauses;

}



;

if (!current_user_can('edit_others_posts')) {

    add_filter('comments_clauses', 'get_comment_list_by_user');

}



//*

//* Cho phép viết PHP vào Text Widget

//*

function php_text($text)

{

    if (strpos($text, '<' . '?') !== false) {

        ob_start();

        eval('?' . '>' . $text);

        $text = ob_get_contents();

        ob_end_clean();

    }

    return $text;

}



add_filter('widget_text', 'php_text', 99);





// Remove size image library

function remove_unused_image_size($sizes)

{

    unset($sizes['thumbnail']);

    unset($sizes['medium']);

    unset($sizes['large']);

}



add_filter('intermediate_image_sizes_advanced', 'remove_unused_image_size');



/**

 * Classic Editor.

 */

add_filter('use_block_editor_for_post', '__return_false');



// Remove Parent Category from Child Category URL

add_filter('term_link', 'devvn_no_category_parents', 1000, 3);

function devvn_no_category_parents($url, $term, $taxonomy) {

    if($taxonomy == 'category'){

        $term_nicename = $term->slug;

        $url = trailingslashit(get_option( 'home' )) . user_trailingslashit( $term_nicename, 'category' );

    }

    return $url;

}

// Rewrite url mới

function devvn_no_category_parents_rewrite_rules($flash = false) {

    $terms = get_terms( array(

        'taxonomy' => 'category',

        'post_type' => 'post',

        'hide_empty' => false,

    ));

    if($terms && !is_wp_error($terms)){

        foreach ($terms as $term){

            $term_slug = $term->slug;

            add_rewrite_rule($term_slug.'/?$', 'index.php?category_name='.$term_slug,'top');

            add_rewrite_rule($term_slug.'/page/([0-9]{1,})/?$', 'index.php?category_name='.$term_slug.'&paged=$matches[1]','top');

            add_rewrite_rule($term_slug.'/(?:feed/)?(feed|rdf|rss|rss2|atom)/?$', 'index.php?category_name='.$term_slug.'&feed=$matches[1]','top');

        }

    }

    if ($flash == true)

        flush_rewrite_rules(false);

}

add_action('init', 'devvn_no_category_parents_rewrite_rules');



/*Sửa lỗi khi tạo mới category bị 404*/

function devvn_new_category_edit_success() {

    devvn_no_category_parents_rewrite_rules(true);

}

add_action('created_category','devvn_new_category_edit_success');

add_action('edited_category','devvn_new_category_edit_success');

add_action('delete_category','devvn_new_category_edit_success');



//*

//* Loại Bỏ ver

//*

remove_action('wp_head', 'wp_generator');

add_filter('the_generator', '__return_empty_string');



function mmolee_remove_version_scripts_styles($src) {

    if (strpos($src, 'ver=')) {

        $src = remove_query_arg('ver', $src);

    }

    return $src;

}

add_filter('style_loader_src', 'mmolee_remove_version_scripts_styles', 9999);

add_filter('script_loader_src', 'mmolee_remove_version_scripts_styles', 9999);


/* Tạo shortcode website */

add_action( 'init', function() {

    add_shortcode( 'site_url', function( $atts = null, $content = null ) {
        return site_url();
    } );

} );