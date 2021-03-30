<?php



if ( function_exists('acf_add_options_page') )

{

    acf_add_options_page(array(

        'page_title' 	=> 'Thông Tin Website',

        'menu_title'	=> 'Thông Tin Website',

        'menu_slug' 	=> 'theme-options',

        'capability'	=> 'edit_posts',

        // 'redirect'		=> false

    ));

    acf_add_options_sub_page(array(

        'page_title' 	=> 'Quản lý thông tin chung',

        'menu_title'	=> 'Quản lý thông tin chung',

        'parent_slug'	=> 'theme-options',

    ));

    acf_add_options_sub_page(array(

        'page_title' 	=> 'Banner',

        'menu_title'	=> 'Banner',

        'parent_slug'	=> 'theme-options',

    ));

    acf_add_options_sub_page(array(

        'page_title' 	=> 'Liên hệ',

        'menu_title'	=> 'Liên hệ',

        'parent_slug'	=> 'theme-options',

    ));

    acf_add_options_sub_page(array(

        'page_title' 	=> 'Footer',

        'menu_title'	=> 'Footer',

        'parent_slug'	=> 'theme-options',

    ));



    acf_add_options_page(array(

        'page_title' 	=> 'Quản lý hình ảnh',

        'menu_title'	=> 'Quản lý hình ảnh',

        'menu_slug' 	=> 'image-options',

        'capability'	=> 'edit_posts'

    ));

    acf_add_options_sub_page(array(

        'page_title' 	=> 'Quản lý logo đối tác',

        'menu_title'	=> 'Quản lý logo đối tác',

        'parent_slug'	=> 'image-options',

    ));

    acf_add_options_sub_page(array(

        'page_title' 	=> 'Quản lý slider',

        'menu_title'	=> 'Quản lý slider',

        'parent_slug'	=> 'image-options',

    ));

}

?>