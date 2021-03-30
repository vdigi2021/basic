<?php

// Open graph Meta
//Adding the Open Graph in the Language Attributes
function add_opengraph_doctype($output)
{
    return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
}
add_filter('language_attributes', 'add_opengraph_doctype');

//Lets add Open Graph Meta Info
function insert_fb_in_head()
{
    global $post;
    if (!is_singular()) //if it is not a post or a page
        return;
    echo '<meta property="og:title" content="' . get_the_title() . '"/>';
    echo '<meta property="og:type" content="website"/>';
    echo '<meta property="og:url" content="' . get_permalink() . '"/>';
    echo '<meta property="og:site_name" content="' . get_field('ten_cong_ty', 'option') . '"/>';
    if (!has_post_thumbnail($post->ID)) {
        $default_image = get_field('logo', 'option');
        echo '<meta property="og:image" content="' . $default_image['url'] . '"/>';
    } else {
        $thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'medium');
        echo '<meta property="og:image" content="' . esc_attr($thumbnail_src[0]) . '"/>';
    }
    echo "
";
}

add_action('wp_head', 'insert_fb_in_head', 5);