<?php

add_action('admin_menu', 'profile_user_menu');
function profile_user_menu()
{
    add_menu_page('Quản lý tài khoản', 'Quản lý tài khoản', 'manage_options', 'profile-user', 'profile_user', '');
    add_submenu_page('profile-user', 'Thông tin', 'Thông tin', 'manage_options', 'profile-user', 'profile_user');
    add_submenu_page('profile-user', 'Chỉnh sửa thông tin', 'Chỉnh sửa thông tin', 'manage_options', 'upload-user', 'upload_user');
    add_submenu_page('profile-user', 'Cập nhật mật khẩu', 'Cập nhật mật khẩu', 'manage_options', 'upload-password', 'upload_password');
}

function profile_user(){
    include 'profile-user/profile-user.php';
}

function upload_user(){
    include 'profile-user/upload-user.php';
}
function upload_password(){
    include 'profile-user/upload-password.php';
}