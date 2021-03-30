<?php



/*



 *  GLOBAL VARIABLES



 */



define('THEME_DIR', get_stylesheet_directory());



define('THEME_URL', get_stylesheet_directory_uri());



define('IMAGE_URL', get_stylesheet_directory_uri() . '/assets/images/');





/*



 *  INCLUDED FILES



 */





$file_includes = [



    'includes/theme-assets.php',                 // Style and JS



    'includes/theme-setup.php',                  // General theme setting



    'includes/acf-options.php',                  // ACF Option page



    'includes/breadcrumb.php',                   // breadcrumb



    'includes/meta.php',                        // meta



    'includes/profile-user.php',                 // Profile User





];





foreach ($file_includes as $file) {



    if (!$filePath = locate_template($file)) {



        trigger_error(sprintf(__('Missing included file'), $file), E_USER_ERROR);



    }



    require_once $filePath;



}


unset($file, $filePath);



//Admin CSS Override
if( current_user_can('admin-client') ) { 
    function sp_admin_style(){
        wp_register_style( 'sp_admin_css', get_bloginfo('stylesheet_directory') . '/assets/css/admin/wp-admin.css', false, '1.0.0' );
        wp_enqueue_style( 'sp_admin_css' );
    }
    add_action('admin_enqueue_scripts', 'sp_admin_style');
}

if ( ! function_exists( 'nb_login_style' ) ) :
    function nb_login_style() {
        wp_enqueue_style( 'nublue-login', get_bloginfo('stylesheet_directory') . '/assets/css/admin/wp-admin.css' );
    }
    add_action( 'login_enqueue_scripts', 'nb_login_style' );
endif;