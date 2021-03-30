<?php
/*
Plugin Name: WP Extra
Plugin URI: https://wordpress.org/plugins/wp-extra/
Description: ❤ This is a simple and perfect tool to use as your website’s functionality plugin. Awesome !!!
Version: 5.1
Author: COP
Author URI: https://profiles.wordpress.org/wpvncom/
Text Domain: vnex
License: GPLv2
*/
include plugin_dir_path( __FILE__ ) . 'vnex-extra-aio.php';
add_action('admin_menu', 'add_vnex_menu');
add_action('plugins_loaded', 'vnex_translation');
function vnex_activation_hook() {
	set_transient('vnex-activation', true, 5 );
}
register_activation_hook( __FILE__, 'vnex_activation_hook' );
function vnex_activation_notice() {
	if ( get_transient('vnex-activation') ) {
		?>
		<div class="notice notice-success is-dismissible">
			<p>WP Extra activated! Click <a href="<?php echo admin_url('admin.php?page=wp-extra'); ?>">WP Extra</a> to configure.</p>
		</div>
		<?php
		delete_transient( 'vnex-activation' );
	}
}
add_action( 'admin_notices', 'vnex_activation_notice' );
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'vnex_add_action_links' );
function vnex_add_action_links ( $extra_links ) {
	$vnex_extra_links = array(
	'<a href="' . admin_url( 'admin.php?page=wp-extra' ) . '">' . __( 'Settings' ) . '</a>',
	);
	return array_merge( $extra_links, $vnex_extra_links );
}

function add_vnex_menu()
{
	global $current_user;
	$vnexoption = vnex_all_options();
	if ( is_admin() && $vnexoption['vnex_role'] == 1 &&  $vnexoption['vnex_role_id'] == get_current_user_id() ) {
		add_menu_page('WP Extra', 'WP Extra', 'manage_options', 'wp-extra', 'vnex_menu_page','dashicons-heart', 30);
	} elseif ( is_admin() && $vnexoption['vnex_role'] == 0 ) {
		add_menu_page('WP Extra', 'WP Extra', 'manage_options', 'wp-extra', 'vnex_menu_page','dashicons-heart', 30);
	}
}

function vnex_translation()
{
    $plugin_dir = basename(dirname(__FILE__));
    load_plugin_textdomain('vnex', false, $plugin_dir . '/languages/');
}
function vnex_menu_page()
{
	global $current_user;
	if (current_user_can('manage_options') ) {
    if (vnex_save())
        echo "<div id='message' class='updated fade'><p>" . __("Options successfully saved. Please <a href='#' onClick='window.location.reload()'>click refresh</a> this page.", "vnex") . "</p></div>";
    $vnexoption = vnex_all_options();
	$vnexargs =   array(
		'wpautop' => false,
		'tinymce'       => array(
			'toolbar1'      => 'formatselect,fontselect,fontsizeselect,bold,italic,underline,bullist,numlist,link,unlink,blockquote,forecolor,backcolor,separator,alignleft,aligncenter,alignright,alignjustify',
			'toolbar2'      => '',
			'toolbar3'      => '',
		),
		'editor_height' => 300,
	);
    echo "<div class='wrap wpextra'>
    <h1>" . __(" WP Extra Option ", "vnex") . " <sup>5.1</sup> <a class='button button-large' style='float: right;'>" . __("✅ Momo: 0907671900", "vnex") . "</a> <a class='button button-large' style='float: right; margin-right: 10px;' href='https://www.paypal.me/copvn/10usd/' target='_blank'>" . __("✅ Paypal", "vnex") . "</a>
    </h1>
    <form id='vnex_save_options' name='vnex_save_options' method='post' action=''>
	<div id='poststuff'>
	<div id='post-body' class='metabox-holder columns-2'>
	<div id='post-body-content'>
	<div id='vnex-tabs'>
	<input class='tab-checked' type='radio' id='tab1' name='tabs' checked />
	<label class='first tab' for='tab1'><span class='dashicons dashicons-admin-post'></span> " . __("Post") . "</label>
	<input class='tab-checked' type='radio' id='tab2' name='tabs' />
	<label class='tab' for='tab2'><span class='dashicons dashicons-admin-media'></span> " . __("Images") . "</label>
	<input class='tab-checked' type='radio' id='tab3' name='tabs' />
	<label class='tab' for='tab3'><span class='dashicons dashicons-admin-settings'></span> " . __("Settings") . "</label>
	<input class='tab-checked' type='radio' id='tab4' name='tabs' />
	<label class='tab' for='tab4'><span class='dashicons dashicons-dashboard'></span> " . __("Dashboard") . "</label>
	<input class='tab-checked' type='radio' id='tab5' name='tabs' />
	<label class='tab' for='tab5'><span class='dashicons dashicons-heart'></span> " . __("Shortcode") . "</label>
	<input class='tab-checked' type='radio' id='tab6' name='tabs' />
	<label class='tab' for='tab6'><span class='dashicons dashicons-admin-tools'></span> SMTP & reCAPTCHA</label>
	<input class='tab-checked' type='radio' id='tab7' name='tabs' />
	<label class='tab' for='tab7'><span class='dashicons dashicons-admin-appearance'></span> " . __("Themes") . "</label>
	<input class='tab-checked' type='radio' id='tab8' name='tabs' />
	<label class='tab vnex-key' for='tab8'><span class='dashicons dashicons-admin-network'></span> " . __("Security", "vnex") . "</label>
	<input class='tab-checked' type='radio' id='tab9' name='tabs' />
	<label class='tab' for='tab9'><span class='dashicons dashicons-cart'></span> " . __("WooCommerce", "vnex") . "</label>
	<input class='tab-checked' type='radio' id='tab10' name='tabs' />
	<label class='tab vnex-premium' for='tab10'><span class='dashicons dashicons-awards'></span> " . __("Premium", "vnex") . "</label>
	<div class='tab-panels'>";

// Tab 01 (post/page)   
	echo "<div class='tab-panel panel1'>
	<div class='postbox'>
	<div class='inside'>
	<table style='margin-top:10px;' class='wp-list-table widefat striped'>
		<tr><td width='50%'>" . __("Disable Gutenberg", "vnex") . "<br /><small>" . __("Disables the new Gutenberg Editor", "vnex") . "</small></td><td>
		<select class='widefat' name='vnex_remove_gutenberg'>
			<option value=''>" . __("No") . "</option>
			<option value='1' ". selected( $vnexoption['vnex_remove_gutenberg'], 1 , false) .">" . __("All") . "</option>
			<option value='2' ". selected( $vnexoption['vnex_remove_gutenberg'], 2 , false) .">" . __("Post") . "</option>
			<option value='3' ". selected( $vnexoption['vnex_remove_gutenberg'], 3 , false) .">" . __("Page") . "</option>
		</select>
		</td></tr>
		  
		<tr><td>" . __("Customize MCE editor (Ex: Justify, Font Size)", "vnex") . "<br /><small>" . __("We removed WordPress’s default editor useless controls and added more useful controls.", "vnex") . "</small></td><td>
		<select class='widefat' name='vnex_mce'>
			<option value=''>" . __("No") . "</option>
			<option value='1' ". selected( $vnexoption['vnex_mce'], 1 , false) .">MCE Editor</option>
			<option value='2' ". selected( $vnexoption['vnex_mce'], 2 , false) .">MCE Editor (Flatsome)</option>
		</select>
		</td></tr>

		<tr><td>" . __("Publish Button", "vnex") . "<br /><small>" . __("Making it stick to the bottom of the page when scrolling down the page", "vnex") . "</small></td><td>
		<label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		  <input class='vnex-switch-input' type='checkbox' name='vnex_button_post' value='1' " . checked($vnexoption['vnex_button_post'], '1', false) . " />
			<span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			<span class='vnex-switch-handle'></span>
		</label>
		</td></tr>
		  
		<tr><td>" . __("Clone Post / Page", "vnex") . " <br /><small>" . __("Creates post clone as a draft and redirects then to the edit post screen", "vnex") . "</small></td><td>
		<label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		  <input class='vnex-switch-input' type='checkbox' name='vnex_clone_post' value='1' " . checked($vnexoption['vnex_clone_post'], '1', false) . " />
			<span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			<span class='vnex-switch-handle'></span>
		</label>
		</td></tr>
		  
		<tr><td>" . __("Clone Widgets", "vnex") . "<br /><small>" . __("Simple clone widget plugin add a Clone link of every widget", "vnex") . "</small></td><td>
		<label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		  <input class='vnex-switch-input' type='checkbox' name='vnex_clone_widgets' value='1' " . checked($vnexoption['vnex_clone_widgets'], '1', false) . " />
			<span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			<span class='vnex-switch-handle'></span>
		</label>
		</td></tr>
		  
		<tr><td>" . __("Do Not Copy", "vnex") . " <br /><small>" . __("Restrict user to copy content & disable mouse right click", "vnex") . "</small></td><td>
		<label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		  <input class='vnex-switch-input' type='checkbox' name='vnex_donotcopy' value='1' " . checked($vnexoption['vnex_donotcopy'], '1', false) . " />
			<span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			<span class='vnex-switch-handle'></span>
		</label>
		</td></tr>
		  
		<tr><td>" . __("Allow SVG", "vnex") . "</td><td><label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		  <input class='vnex-switch-input' type='checkbox' name='vnex_allow_svg' value='1' " . checked($vnexoption['vnex_allow_svg'], '1', false) . " /> 
			<span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			<span class='vnex-switch-handle'></span>
		</label>
		</td></tr>
		  
		<tr><td>" . __("Disable Emojis", "vnex") . "</td><td><label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		  <input class='vnex-switch-input' type='checkbox' name='vnex_disable_emojis' value='1' " . checked($vnexoption['vnex_disable_emojis'], '1', false) . " />
			<span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			<span class='vnex-switch-handle'></span>
		</label> 
		</td></tr>

		<tr><td>" . __("Remove JQuery migrate", "vnex") . "</td><td><label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		  <input class='vnex-switch-input' type='checkbox' name='vnex_disable_jm' value='1' " . checked($vnexoption['vnex_disable_jm'], '1', false) . " />
			<span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			<span class='vnex-switch-handle'></span>
		</label>
		</td></tr>

		<tr><td>" . __("Disable Self Pingbacks", "vnex") . "<br/><small>" . __("Disable Self Pingbacks (generated when linking to an article on your own blog)", "vnex") . "</small></td><td>
		<label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		  <input class='vnex-switch-input' type='checkbox' name='disable_self_pings' value='1' " . checked($vnexoption['disable_self_pings'], '1', false) . " />
			<span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			<span class='vnex-switch-handle'></span>
		</label>
		</td></tr>

		  
		<tr><td>" . __("Disable & Remove Menu Comments", "vnex") . "<br /><small>" . __("Disable support for comments and trackbacks in post types", "vnex") . "</small></td><td>
		<label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		  <input onchange='Checkradiobutton()' id='r1' class='vnex-switch-input' type='checkbox' name='vnex_disable_comments' value='1' " . checked($vnexoption['vnex_disable_comments'], '1', false) . " />
			<span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			<span class='vnex-switch-handle'></span>
		</label>
		</td></tr>

		<tr><td>|-- " . __("Open Link in New Tab", "vnex") . "</td><td><label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		  <input id='vnex_open_link_new_tab' class='vnex-switch-input' type='checkbox' name='open_link_innewtab' value='1' " . checked($vnexoption['open_link_innewtab'], '1', false) . " />
			<span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			<span class='vnex-switch-handle'></span>
		</label> 
		</td></tr>

		<tr><td>|-- " . __("Hide Existing Comments", "vnex") . "</td><td><label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		  <input id='vnex_hide_existing_comments' class='vnex-switch-input' type='checkbox' name='hide_existing_cmts' value='1' " . checked($vnexoption['hide_existing_cmts'], '1', false) . " />
			<span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			<span class='vnex-switch-handle'></span>
		</label> 
		</td></tr>

		<tr><td>|-- " . __("Filter comment texts to remove link", "vnex") . "</td><td><label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		  <input id='vnex_filter_comments_text' class='vnex-switch-input' type='checkbox' name='remove_comment_link' value='1' " . checked($vnexoption['remove_comment_link'], '1', false) . " />
			<span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			<span class='vnex-switch-handle'></span>
		</label> 
		</td></tr>

		<tr><td>|-- " . __("Disable Auto Linking turning URLs from comments into actual links", "vnex") . "</td><td><label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		  <input id='vnex_disable_turning_url' class='vnex-switch-input' type='checkbox' name='disable_turning_link' value='1' " . checked($vnexoption['disable_turning_link'], '1', false) . " />
			<span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			<span class='vnex-switch-handle'></span>
		</label> 
		</td></tr>

		<tr><td>|-- " . __("Remove  hyperlink of comment author", "vnex") . "</td><td><label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		  <input id='remove_author_txtlink_id' class='vnex-switch-input' type='checkbox' name='remove_author_txtlink' value='1' " . checked($vnexoption['remove_author_txtlink'], '1', false) . " />
			<span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			<span class='vnex-switch-handle'></span>
		</label> 
		</td></tr>

		<tr><td>|-- " . __("Remove Author URI or Link", "vnex") . "<br/><small>" . __("Remove URL / Website Field from WordPress Comment Form?", "vnex") . "</small></td><td><label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		  <input id='remove_author_uri_id' class='vnex-switch-input' type='checkbox' name='remove_author_uri' value='1' " . checked($vnexoption['remove_author_uri'], '1', false) . " />
			<span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			<span class='vnex-switch-handle'></span>
		</label> 
		</td></tr>

		<tr><td>|-- " . __("Mark Comments with Very Long URLs as Spam", "vnex") . "</td><td><label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		  <input id='url_spamcheck_id' class='vnex-switch-input' type='checkbox' name='vnex_comments_url_spamcheck' value='1' " . checked($vnexoption['vnex_comments_url_spamcheck'], '1', false) . " />
			<span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			<span class='vnex-switch-handle'></span>
		</label> 
		</td></tr>
		
		<tr><td>|-- " . __("Require Minimum Comment Length?", "vnex") . "<br/><small>" . __("Set your number", "vnex") . "</small></td><td><input id='otherPosition' placeholder='50' type='text' size='1' name='vnex_minimal_comment_length' value='" . $vnexoption['vnex_minimal_comment_length'] . "' /></td></tr>

		<tr><td>" . __("Time empty from the trash bin", "vnex") . "<br/><small>" . __("Set your number of days before WordPress permanently deletes posts, pages, attachments, and comments, from the trash bin", "vnex") . "</small></td><td><input id='otherPosition' placeholder='3' type='text' size='1' name='vnex_empty_trash_bin' value='" . $vnexoption['vnex_empty_trash_bin'] . "' /></td></tr>
		<tr><td>" . __("Post Autosave Interval", "vnex") . "<br/><small>" . __("Controls how often WordPress will auto save posts and pages while editing.", "vnex") . "</small></td><td>
		<input id='otherPosition' placeholder='60' type='text' size='1' name='vnex_post_autosave' value='" . $vnexoption['vnex_post_autosave'] . "' />
		</td></tr>
		  
		<tr><td>" . __("Limit Post Revisions", "vnex") . "<br/><small>" . __("Set how many revisions you want to keep", "vnex") . "</small></td><td>
			<select class='widefat' name='vnex_post_revisions'>
				<option value='1' ". selected( $vnexoption['vnex_post_revisions'], 1 , false) .">1</option>
				<option value='2' ". selected( $vnexoption['vnex_post_revisions'], 2 , false) .">2</option>
				<option value='5' ". selected( $vnexoption['vnex_post_revisions'], 5 , false) .">5</option>
				<option value='false' ". selected( $vnexoption['vnex_post_revisions'], 'false' , false) .">" . __("Disable") . "</option>
			</select>
		</td></tr>
    </table></div></div></div>";
		  
// Tab 02 (Image)	
	echo "<div class='tab-panel panel2'>
	<div class='postbox'>
	<div class='inside'>
	<table style='margin-top:10px;' class='wp-list-table widefat striped'>
		<tr><td width='50%'>" . __("Auto Save Images", "vnex") . " <br /><small>" . __("Downloading automatically image from a post to gallery", "vnex") . "</small></td><td>
			<label class='vnex-switch vnex-switch-text vnex-switch-danger'>
				<input onchange='vnex_auto_save_images_enable()' id='vnex_auto_save_id' class='vnex-switch-input' type='checkbox' name='vnex_auto_save_images' value='1' " . checked($vnexoption['vnex_auto_save_images'], '1', false) . " />
				<span class='vnex-switch-label' data-off='Off' data-on='On'></span>
				<span class='vnex-switch-handle'></span>
			</label>
		</td></tr>
		  
	    <tr><td>|-- " . __("Save Image") . "</td><td>
			<select class='widefat' id='vnex_auto_save_id_1' name='vnex_auto_save_images_status'>
				<option value='1' ". selected( $vnexoption['vnex_auto_save_images_status'], 1 , false) .">" . __("Only New Post", "vnex") . "</option>
				<option value='2' ". selected( $vnexoption['vnex_auto_save_images_status'], 2 , false) .">" . __("All") . "</option>
			</select>
		</td></tr>

        <tr><td>|-- " . __("Link to Media File") . "</td><td>
		    <label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		      <input id='vnex_auto_save_id_2' class='vnex-switch-input' type='checkbox' name='vnex_auto_save_images_media_file' value='1' " . checked($vnexoption['vnex_auto_save_images_media_file'], '1', false) . " />
			  <span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			  <span class='vnex-switch-handle'></span>
		    </label>
		</td></tr>

	    <tr><td>|-- " . __("Image Filename", "vnex") . "<br /><small>" . __("Custom Filename Structure", "vnex") . "</small></td><td>
			<select class='widefat' id='vnex_auto_save_id_3' name='vnex_auto_save_images_filename'>
				<option value=''>" . __("No") . "</option>
				<option value='1' ". selected( $vnexoption['vnex_auto_save_images_filename'], 1 , false) .">" . __("Slug (Ex: image.jpg)", "vnex") . "</option>
				<option value='2' ". selected( $vnexoption['vnex_auto_save_images_filename'], 2 , false) .">" . __("Slug and ID (Ex: image-id.jpg)", "vnex") . "</option>
			</select>
		</td></tr> 
		   
	    <tr><td>" . __("Autoset Featured Image", "vnex") . " <br /><small>" . __("Automatically Set the Featured Image", "vnex") . "</small></td><td>
		    <label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		      <input class='vnex-switch-input' type='checkbox' name='vnex_auto_set_featured_image' value='1' " . checked($vnexoption['vnex_auto_set_featured_image'], '1', false) . " />
			  <span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			  <span class='vnex-switch-handle'></span>
		    </label>
		</td></tr>
		  
		<tr><td>" . __("SEO Images", "vnex") . " <br /><small>" . __("Automatically set the image Title, Alt-Text, Caption & Description upload", "vnex") . "</small></td><td>
		    <label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		      <input class='vnex-switch-input' type='checkbox' name='vnex_set_image_meta' value='1' " . checked($vnexoption['vnex_set_image_meta'], '1', false) . " />
			  <span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			  <span class='vnex-switch-handle'></span>
		    </label> 
		</td></tr>
		  
		<tr><td>" . __("Enable Auto Resize Image", "vnex") . "<br /><small>" . __("Automatically resizes uploaded images (JPEG, GIF, and PNG) ", "vnex") . "</small></td><td>
		   <label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		      <input onchange='vnex_auto_resize_images_enable()' id='vnex_auto_resize_id' class='vnex-switch-input' type='checkbox' name='vnex_image_resize' value='1' " . checked($vnexoption['vnex_image_resize'], '1', false) . " />
			  <span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			  <span class='vnex-switch-handle'></span>
		   </label> 
		</td></tr>
		  
		<tr><td>|-- " . __("Force JPEG re-compression", "vnex") . "</td><td>
		   <label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		      <input id='vnex_auto_resize_id_1' class='vnex-switch-input' type='checkbox' name='vnex_image_re_compression' value='1' " . checked($vnexoption['vnex_image_re_compression'], '1', false) . " />
			  <span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			  <span class='vnex-switch-handle'></span>
		   </label> 
		</td></tr>
		
		<tr><td>|-- " . __("JPEG compression level", "vnex") . "<br /><small>" . __("Default: <code>90%</code>", "vnex") . "</small></td><td>
			<select class='widefat' id='vnex_auto_resize_id_2' name='vnex_image_quality'>
				<option value=''>" . __("No") . "</option>
				<option value='80' ". selected( $vnexoption['vnex_image_quality'], 80 , false) .">80</option>
				<option value='85' ". selected( $vnexoption['vnex_image_quality'], 85 , false) .">85</option>
				<option value='90' ". selected( $vnexoption['vnex_image_quality'], 90 , false) .">90</option>
				<option value='95' ". selected( $vnexoption['vnex_image_quality'], 95 , false) .">95</option>
				<option value='100' ". selected( $vnexoption['vnex_image_quality'], 100 , false) .">100</option>
			</select>
		</td></tr>
		  
		<tr><td>|-- " . __("Image Size in kilobytes", "vnex") . " <br /><small>" . __("Limit Image Size in WordPress Media Library. Ex: 2000 = 2MB", "vnex") . "</small></td><td>
		   <input placeholder='Ex: 2000' id='vnex_auto_resize_id_3' type='text' size='10' name='vnex_image_limit' value='" . $vnexoption['vnex_image_limit'] . "' /> 
		</td></tr>
		  
		<tr><td>|-- " . __("Max image dimensions", "vnex") . " <br /><small>" . __("Maximum width x height. Recommended values: <code>1000x1000</code>", "vnex") . "</small></td><td>
		  <input placeholder='1000' id='vnex_auto_resize_id_4' type='text' size='10' name='vnex_image_maximum_width' value='" . $vnexoption['vnex_image_maximum_width'] . "' /> 
		  <input placeholder='1000' id='vnex_auto_resize_id_5' type='text' size='10' name='vnex_image_maximum_height' value='" . $vnexoption['vnex_image_maximum_height'] . "' /> px
		</td></tr>
   </table></div></div></div>";
	
// Tab 03 (Setting)	
	echo "<div class='tab-panel panel3'>
	<div class='postbox'>
	<div class='inside'>
	<table style='margin-top:10px;' class='wp-list-table widefat striped'>
		  
		<tr><td width='50%'>" . __("Add .html to Page", "vnex") . " </td><td>
		   <label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		      <input class='vnex-switch-input' type='checkbox' name='vnex_page_html' value='1' " . checked($vnexoption['vnex_page_html'], '1', false) . " />
			  <span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			  <span class='vnex-switch-handle'></span>
		    </label>
		</td></tr>
		  
		<tr><td>" . __("Remove the '/category/' from your permalinks", "vnex") . "</td><td>
		   <label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		      <input class='vnex-switch-input' type='checkbox' name='vnex_remove_category' value='1' " . checked($vnexoption['vnex_remove_category'], '1', false) . " />
			  <span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			  <span class='vnex-switch-handle'></span>
		   </label>
		</td></tr>
		  
		<tr><td>" . __("Redirect 404 Error Page to Homepage", "vnex") . "</td><td>
		    <label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		      <input class='vnex-switch-input' type='checkbox' name='vnex_404_home' value='1' " . checked($vnexoption['vnex_404_home'], '1', false) . " />
			  <span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			  <span class='vnex-switch-handle'></span>
		   </label>
		</td></tr>
		  
		<tr><td>" . __("Add nofollow & _blank ?", "vnex") . "<br /><small>" . __("Add rel=\"nofollow\" and target=\"_blank\" for external links permanently", "vnex") . "</td><td>
			<select class='widefat' name='vnex_auto_links'>
				<option value=''>" . __("No") . "</option>
				<option value='1' ". selected( $vnexoption['vnex_auto_links'], 1 , false) .">" . __("Add _blank", "vnex") . "</option>
				<option value='2' ". selected( $vnexoption['vnex_auto_links'], 2 , false) .">" . __("Add nofollow & _blank", "vnex") . "</option>
			</select>
	    </td></tr>
		  
		<tr><td>" . __("Login Logo", "vnex") . "<br/><small>" . __("Ex: abc.com/logo.jpg . Recommended: <code>84x84</code>", "vnex") . "</small></td><td>
		   <input size='46' id='vnex_media_image' type='text' name='vnex_admin_logo' value='" . $vnexoption['vnex_admin_logo'] . "' />
		   <input id='vnex_media_button' type='button' value='" . __("Choose Image") . "' class='button' />
	    </td></tr>
		  
		<tr><td>" . __("Login Background or URL", "vnex") . "<br/><small>" . __("Random & Blur", "vnex") . ": <code>https://picsum.photos/1200/768/?blur&random</code><br>" . __("Random", "vnex") . ":<code>https://source.unsplash.com/1200x768/?seo</code></small></td><td>
		    <input size='46' id='vnex_media_image_bg' type='text' name='vnex_admin_background' value='" . $vnexoption['vnex_admin_background'] . "' />
		    <input id='vnex_media_button_bg' type='button' value='" . __("Choose Image") . "' class='button' />
		    <input id='vnex_admin_background_color' class='color-picker' type='text' name='vnex_admin_background_color' value='" . $vnexoption['vnex_admin_background_color'] . "' />	
	    </td></tr>

		<tr><td>" . __("Remove unnecessary links from wp_head?", "vnex") . "</td><td>
		    <label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		      <input class='vnex-switch-input' type='checkbox' name='vnex_remove_head_link' value='1' " . checked($vnexoption['vnex_remove_head_link'], '1', false) . " />
			  <span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			  <span class='vnex-switch-handle'></span>
		    </label>
		</td></tr>
		  
		  
		<tr><td>" . __("Change Admin footer?", "vnex") . "<br/><small>" . __("Set your name", "vnex") . "</small></td><td>
		  <input placeholder='Set your name admin footer' type='text' size='46' name='vnex_admin_footer' value='" . $vnexoption['vnex_admin_footer'] . "' />
		</td></tr>
		  
		<tr><td>" . __("Disable RSS Feeds and redirect to Homepage", "vnex") . "</td><td>
		   <label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		     <input class='vnex-switch-input' type='checkbox' name='vnex_disable_feed' value='1' " . checked($vnexoption['vnex_disable_feed'], '1', false) . " />
			 <span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			 <span class='vnex-switch-handle'></span>
		   </label>
		</td></tr>
		  		  
		<tr><td>" . __("Redirect single post", "vnex") . "<br /><small>" . __("Redirect To Post If Search Results Return One Post", "vnex") . "</small></td><td>
		   <label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		     <input class='vnex-switch-input' type='checkbox' name='search_results_return_one_post' value='1' " . checked($vnexoption['search_results_return_one_post'], '1', false) . " />
			 <span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			 <span class='vnex-switch-handle'></span>
		   </label>
		</td></tr>

		<tr><td>" . __("Clear whitespace in JS and CSS", "vnex") . "<br /><small>" . __("Clean up the whitespace in your js and css files, maximizing page load speed", "vnex") . "</small></td><td>
		    <label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		     <input class='vnex-switch-input' type='checkbox' name='vnex_clear_whitespace_in_js_and_css' value='1' " . checked($vnexoption['vnex_clear_whitespace_in_js_and_css'], '1', false) . " />
			 <span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			 <span class='vnex-switch-handle'></span>
		   </label>
		</td></tr>

		<tr><td>" . __("Stop The Heartbeat API", "vnex") . "<br /><small>" . __("Disable WordPress Heartbeat everywhere or in certain areas (used for auto saving and revision tracking).", "vnex") . "</small></td><td>
			<select class='widefat' name='disable_heartbeat'>
				<option value=''>" . __("Default (No)", "vnex") . "</option>
				<option value='1' ". selected( $vnexoption['disable_heartbeat'], 1 , false) .">" . __("Disable Everywhere", "vnex") . "</option>
				<option value='2' ". selected( $vnexoption['disable_heartbeat'], 2 , false) .">" . __("Only Allow When Editing Posts/Pages (recommend)", "vnex") . "</option>
			</select>
			" . __("Frequency", "vnex") . "
			<select class='widefat' name='heartbeat_frequency'>
				<option value='' ". selected( $vnexoption['heartbeat_frequency'], 15 , false) .">15 Seconds (default)</option>
				<option value='30' ". selected( $vnexoption['heartbeat_frequency'], 30 , false) .">30 Seconds</option>
				<option value='45' ". selected( $vnexoption['heartbeat_frequency'], 45 , false) .">45 Seconds</option>
				<option value='60' ". selected( $vnexoption['heartbeat_frequency'], 60 , false) .">60 Seconds (recommend)</option>
			</select>
	    </td></tr>

		<tr><td>" . __("Disable Embeds", "vnex") . "<br /><small>" . __("Removes WordPress Embed JavaScript file (wp-embed.min.js).", "vnex") . "</small></td><td>
		   <label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		     <input class='vnex-switch-input' type='checkbox' name='vnex_disable_embeds' value='1' " . checked($vnexoption['vnex_disable_embeds'], '1', false) . " />
			 <span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			 <span class='vnex-switch-handle'></span>
		   </label>
		</td></tr>

		<tr><td>" . __("Remove Query Strings", "vnex") . "<br /><small>" . __("Remove query strings from static resources (CSS, JS).", "vnex") . "</small></td><td>
		   <label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		     <input class='vnex-switch-input' type='checkbox' name='vnex_remove_query_strings' value='1' " . checked($vnexoption['vnex_remove_query_strings'], '1', false) . " />
			 <span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			 <span class='vnex-switch-handle'></span>
		   </label>
		</td></tr>

		<tr><td>" . __("Remove Shortlink", "vnex") . "<br /><small>" . __("Remove the Shortlink Tag", "vnex") . "</small></td><td>
		   <label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		      <input class='vnex-switch-input' type='checkbox' name='vnex_remove_shortlink' value='1' " . checked($vnexoption['vnex_remove_shortlink'], '1', false) . " />
			  <span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			  <span class='vnex-switch-handle'></span>
		   </label>
		</td></tr>

		<tr><td>" . __("Remove REST API link", "vnex") . "<br /><small>" . __("Removes REST API link tag from the front end and the REST API header link from page requests.", "vnex") . "</small></td><td>
		   <label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		     <input class='vnex-switch-input' type='checkbox' name='vnex_remove_rest_api_link' value='1' " . checked($vnexoption['vnex_remove_rest_api_link'], '1', false) . " />
			 <span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			 <span class='vnex-switch-handle'></span>
		   </label>
		</td></tr>

		<tr><td>" . __("Disable REST API", "vnex") . "<br /><small>" . __("Disables REST API requests and displays an error message if the requester doesn\'t have permission.", "vnex") . "</td><td>
			<select class='widefat' name='disable_rest_api'>
				<option value=''>" . __("Default (Enabled)", "vnex") . "</option>
				<option value='1' ". selected( $vnexoption['disable_rest_api'], 1 , false) .">" . __("Disable for Non-Admins", "vnex") . "</option>
				<option value='2' ". selected( $vnexoption['disable_rest_api'], 2 , false) .">" . __("Disable When Logged Out", "vnex") . "</option>
			</select>
	    </td></tr>

		<tr><td>" . __("Disable Dashicons", "vnex") . "<br /><small>" . __("Disables dashicons on the front end when not logged in.", "vnex") . "</small></td><td>
		   <label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		     <input class='vnex-switch-input' type='checkbox' name='vnex_disable_dashicon' value='1' " . checked($vnexoption['vnex_disable_dashicon'], '1', false) . " />
			 <span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			 <span class='vnex-switch-handle'></span>
		   </label>
		</td></tr>

		<tr><td>" . __("Disable Google Fonts", "vnex") . "<br /><small>" . __("Removes any instances of Google Fonts being loaded across your entire site.", "vnex") . "</small></td><td>
		   <label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		     <input class='vnex-switch-input' type='checkbox' name='disable_google_fonts' value='1' " . checked($vnexoption['disable_google_fonts'], '1', false) . " />
			 <span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			 <span class='vnex-switch-handle'></span>
		   </label>
		</td></tr>

	


   </table></div></div></div>";
	
// Tab 04 (Dashboard)	
   echo "<div class='tab-panel panel4'>
	<div class='postbox'>
	<div class='inside'>
	<table style='margin-top:10px;' class='wp-list-table widefat striped'>

		<tr><td width='40%'>" . __("Remove All Dashboard", "vnex") . "</td><td>
		   <label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		     <input class='vnex-switch-input' type='checkbox' name='vnex_remove_dashboard' value='1' " . checked($vnexoption['vnex_remove_dashboard'], '1', false) . " />
			 <span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			 <span class='vnex-switch-handle'></span>
		   </label>
		</td></tr>
		  
		<tr><td colspan='2'>" . __("Add Notice to Dashboard", "vnex") . "</td></tr>";
  echo "<tr><td colspan='2'>";
		 wp_editor( stripslashes($vnexoption['vnex_dashboard_notice']), 'vnex_dashboard_notice', $vnexargs );
  echo "</td></tr>
    </table></div></div></div>";
	
// Tab 05 (Shortcode)	
	echo "<div class='tab-panel panel5'><div class='postbox'>
	<div class='inside'>
	<table style='margin-top:10px;' class='wp-list-table widefat striped'>  
		<tr><td colspan='2'>" . __("Add <code>[signature]</code> or button <span class='dashicons dashicons-heart'></span> to post / page", "vnex") . " 
		</td></tr>"; 
   echo "<tr><td colspan='2'>";
	wp_editor( stripslashes($vnexoption['vnex_shortcode']), 'vnex_shortcode', $vnexargs );
   echo "</td></tr>
   </table></div></div></div>";

// Tab 06 (SMTP/reCAPTCHA)
	echo "<div class='tab-panel panel6'>
	<div class='postbox'><h3 class='hndle'>" . __("💡 Note: Test by", "vnex") . " <a href='" . admin_url( 'admin.php?page=wpcf7' ) . "'>" . __("Contact Form 7", "vnex") . "</a> " . __("after \"Save Options\"", "vnex") . "</h3>
	<div class='inside'>
	   <table style='margin-top:10px;' class='wp-list-table widefat striped'>
           <tr><td width='50%'>" . __("SMTP Setting", "vnex") . "</td><td>
		         <label><input type='radio' name='vnex_smtp' value='' />" . __("No") . "</label>
		         <label><input onchange='vnex_smtp_enable()' id='vnex_smtp_onoff' type='radio' name='vnex_smtp' value='1' " . checked($vnexoption['vnex_smtp'], '1', false) . " />" . __("SMTP Other", "vnex") . "</label>
			     <label><input onchange='vnex_smtp_enable()' id='vnex_smtp_onoff' type='radio' name='vnex_smtp' value='2' " . checked($vnexoption['vnex_smtp'], '2', false) . " />" . __("SMTP Gmail", "vnex") . "</label>
			     <label><input onchange='vnex_smtp_enable()' id='vnex_smtp_onoff' type='radio' name='vnex_smtp' value='3' " . checked($vnexoption['vnex_smtp'], '3', false) . " />" . __("SMTP Yandex", "vnex") . "</label>
		   </td></tr>
		  
		   <tr><td>" . __("SMTP Host") . "<br /><small>" . __("The SMTP server which will be used to send email. For example: smtp.gmail.com", "vnex") . "</small></td><td>
		      <input type='text' id='vnex_smtp_1' class='widefat' name='vnex_smtp_host' value='" . $vnexoption['vnex_smtp_host'] . "' />
		   </td></tr>
		  
		   <tr><td>" . __("SMTP Port") . "<br /><small>" . __("The port which will be used when sending an email (587/465/25). If you choose TLS it should be set to 587. For SSL use port 465 instead.", "vnex") . "</small></td><td>
		      <input type='text' id='vnex_smtp_2' class='widefat' name='vnex_smtp_port' value='" . $vnexoption['vnex_smtp_port'] . "' />
		   </td></tr>
			
		   <tr><td>" . __("Type of Encryption") . "<br /><small>" . __("The encryption which will be used when sending an email (recommended: TLS).", "vnex") . "</small></td><td>
		        <select class='widefat' id='vnex_smtp_3' name='vnex_smtp_ssl'>
				  <option value='none' ". selected( $vnexoption['vnex_smtp_ssl'], 'none' , false) .">" . __("None") . "</option>
				  <option value='tls' ". selected( $vnexoption['vnex_smtp_ssl'], 'tls' , false) .">" . __("TLS", "vnex") . "</option>
				  <option value='ssl' ". selected( $vnexoption['vnex_smtp_ssl'], 'ssl' , false) .">" . __("SSL", "vnex") . "</option>
			    </select>
		   </td></tr>
		  
		  <tr><td>" . __("SMTP Username") . "</td><td><input type='text' class='widefat' name='vnex_smtp_username' value='" . $vnexoption['vnex_smtp_username'] . "' /></td></tr>
		  
		  <tr><td>" . __("SMTP Password") . "</td><td><input type='password' class='widefat' name='vnex_smtp_password' value='" . base64_decode ($vnexoption['vnex_smtp_password']) . "' /></td></tr>
		  
		  <tr><td>" . __("From Name") . "</td><td><input type='text' class='widefat' name='vnex_smtp_from_name' value='" . $vnexoption['vnex_smtp_from_name'] . "' /></td></tr>
		  
		  <tr><td>" . __("From Email Address") . "</td><td><input type='text' class='widefat' name='vnex_smtp_from_email' value='" . $vnexoption['vnex_smtp_from_email'] . "' /></td></tr>
		  
		  <tr><td>" . __("Reply To Email") . "</td><td><input type='text' class='widefat' name='vnex_smtp_replyto' value='" . $vnexoption['vnex_smtp_replyto'] . "' /></td></tr>
		  
	   </table>
	</div></div>
		  
    <div class='postbox'><h3 class='hndle'>" . __("reCAPTCHA and Contact Form 7 Setting", "vnex") . "</h3>
	<div class='inside'>
	   <table style='margin-top:10px;' class='wp-list-table widefat striped'>
		   <tr><td width='50%'>".__("Please setup <a href=\"admin.php?page=wpcf7-integration&service=recaptcha&action=setup\">Contact Form 7’s reCAPTCHA integration module </a> first, get required keys (reCAPTCHA V3) from Google and save them bellow.", "vnex")."</td><td>
			    <select class='widefat' name='vnex_recaptcha'>
				  <option value=''>" . __("No") . "</option>
				  <option value='1' ". selected( $vnexoption['vnex_recaptcha'], 1 , false) .">" . __("Only Login Form", "vnex") . "</option>
				  <option value='2' ". selected( $vnexoption['vnex_recaptcha'], 2 , false) .">" . __("Exclude Login Form", "vnex") . "</option>
				  <option value='3' ". selected( $vnexoption['vnex_recaptcha'], 3 , false) .">" . __("All page", "vnex") . "</option>
			    </select>
			</td></tr>
		  
		   <tr><td>" . __("Hide reCAPTCHA badge and Contact Form 7 on all pages that do not use Contact Form 7", "vnex") . "</td><td>
		        <label class='vnex-switch vnex-switch-text vnex-switch-danger'>
			      <input class='vnex-switch-input' type='checkbox' name='vnex_recaptcha_badge' value='1' " . checked($vnexoption['vnex_recaptcha_badge'], '1', false) . " />
			      <span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			      <span class='vnex-switch-handle'></span>
			   </label>
		   </td></tr>	
	   </table>
	</div></div></div>";

// Tab 07 (Theme global Settings)		
	echo "<div class='tab-panel panel7'>
	<div class='postbox'><h3 class='hndle'>" . __("Global Settings", "vnex") . "</h3>
	<div class='inside'>
	<table style='margin-top:10px;' class='wp-list-table widefat striped'>
		<tr><td width='25%'>" . __("HEADER SCRIPTS", "vnex") . "<br /><small>" . __("Add custom scripts inside HEAD tag. You need to have a SCRIPT tag around scripts.", "vnex") . "</small></td><td>
		   <textarea name='vnex_add_header' class='widefat' rows='8'>" . stripslashes($vnexoption['vnex_add_header']) . "</textarea>
		</td></tr>
		
		<tr><td>" . __("FOOTER SCRIPTS", "vnex") . "<br /><small>" . __("Add custom scripts you might want to be loaded in the footer of your website. You need to have a SCRIPT tag around scripts.", "vnex") . "</small></td><td>
		   <textarea name='vnex_add_footer' class='widefat' rows='8'>" . stripslashes($vnexoption['vnex_add_footer']) . "</textarea>
		</td></tr>
    </table></div></div>
		  
    <div class='postbox'><h3 class='hndle'>" . __("Custom CSS", "vnex") . "</h3>
	<div class='inside'>
	   <table style='margin-top:10px;' class='wp-list-table widefat striped'>
		    <tr><td width='25%'>" . __("ALL SCREENS", "vnex") . "<br /><small>" . __("Add custom CSS here", "vnex") . "</small></td><td>
		      <textarea name='vnex_html_custom_css' class='widefat' rows='8'>" . stripslashes($vnexoption['vnex_html_custom_css']) . "</textarea>
		    </td></tr>
		
		    <tr><td>" . __("TABLETS AND DOWN (MAX-WIDTH)", "vnex") . "<br /><small>" . __("Default: 849px", "vnex") . "</small></td><td>
		      <input type='text' class='widefat' name='vnex_html_custom_css_tablet_maxwidth' value='" . $vnexoption['vnex_html_custom_css_tablet_maxwidth'] . "' />
		    </td></tr>
		  
		    <tr><td><small>" . __("Add custom CSS here for tablets and mobile", "vnex") . "</small></td><td>
		      <textarea name='vnex_html_custom_css_tablet' class='widefat' rows='8'>" . stripslashes($vnexoption['vnex_html_custom_css_tablet']) . "</textarea>
		    </td></tr>
		
		    <tr><td>" . __("MOBILE ONLY (MAX-WIDTH)", "vnex") . "<br /><small>" . __("Default: 549px", "vnex") . "</small></td><td>
		      <input type='text' class='widefat' name='vnex_html_custom_css_mobile_maxwidth' value='" . $vnexoption['vnex_html_custom_css_mobile_maxwidth'] . "' />
		    </td></tr>
		  
		    <tr><td><small>" . __("Add custom CSS here for mobile view", "vnex") . "</small></td><td>
		      <textarea name='vnex_html_custom_css_mobile' class='widefat' rows='8'>" . stripslashes($vnexoption['vnex_html_custom_css_mobile']) . "</textarea>
		    </td></tr>	
	   </table>
    </div></div></div>";

// Tab 08 (Security)
	echo "<div class='tab-panel panel8'>
	<div class='postbox'><h3 class='hndle'>💡 " . __("Be Careful!", "vnex") . "</h3>
	<div class='inside'>
	<table style='margin-top:10px;' class='wp-list-table widefat striped'>
		<tr><td width='50%'>" . __("Remove admin bar & donate WPVN Team", "vnex") . "<br><small><a href='https://www.paypal.me/copvn/10usd/' target='_blank'>" . __("Paypal or Momo: 0907671900", "vnex") . "</a></small></td><td>
		    <label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		        <input class='vnex-switch-input' type='checkbox' name='vnex_copyright' value='1' " . checked($vnexoption['vnex_copyright'], '1', false) . " />
			    <span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			    <span class='vnex-switch-handle'></span>
		    </label>
		</td></tr>

		<tr><td>" . __("Change Admin Login URL (wp-admin & wp-login.php)", "vnex") . "<br /><small>" . __("💡 Note: Click", "vnex") . " <a href='" . admin_url( 'options-permalink.php' ) . "'>" . __( 'Options Permalink' ) . "</a> " . __("after \"Save Options\"", "vnex") . "</small></td><td>
		   <label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		       <input class='vnex-switch-input' type='checkbox' name='vnex_admin_slug' value='1' " . checked($vnexoption['vnex_admin_slug'], '1', false) . " />
			   <span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			   <span class='vnex-switch-handle'></span>
		   </label> 
		</td></tr>

		<tr><td>" . __("Disable XMLRPC", "vnex") . "<br /><small>" . __("This could cause security issues and can be exploited by hackers", "vnex") . "</small></td><td>
		   <label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		      <input class='vnex-switch-input' type='checkbox' name='vnex_disable_xmlrpc' value='1' " . checked($vnexoption['vnex_disable_xmlrpc'], '1', false) . " />
			  <span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			  <span class='vnex-switch-handle'></span>
		   </label>
		</td></tr>
		
		<tr><td>" . __("Hide admin bar from front end for non admin?", "vnex") . "</td><td>
			<select class='widefat' name='vnex_hide_admin_bar'>
				<option value=''>" . __("No") . "</option>
				<option value='1' ". selected( $vnexoption['vnex_hide_admin_bar'], 1 , false) .">Disable All</option>
				<option value='2' ". selected( $vnexoption['vnex_hide_admin_bar'], 2 , false) .">Enable Admin</option>
			</select>
		</td></tr>
		  
		<tr><td>" . __("Remove Logo / Version / Help", "vnex") . "</td><td>
		    <label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		      <input class='vnex-switch-input' type='checkbox' name='vnex_remove_version' value='1' " . checked($vnexoption['vnex_remove_version'], '1', false) . " />
			  <span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			  <span class='vnex-switch-handle'></span>
		    </label> 
		</td></tr>
		  
		<tr><td>" . __("Remove Menu & Disable the theme/plugin editor in Admin", "vnex") . "<br /><small>" . __("Appearance, Plugins, Tools, Settings", "vnex") . "</small></td><td>
		    <label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		      <input class='vnex-switch-input' type='checkbox' name='vnex_remove_menu_tools' value='1' " . checked($vnexoption['vnex_remove_menu_tools'], '1', false) . " />
			  <span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			  <span class='vnex-switch-handle'></span>
		    </label> 
		</td></tr>
		  
		<tr><td>" . __("Disable core & translate auto updating", "vnex") . "</td><td>
		   <label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		      <input class='vnex-switch-input' type='checkbox' name='vnex_auto_update' value='1' " . checked($vnexoption['vnex_auto_update'], '1', false) . " />
			  <span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			  <span class='vnex-switch-handle'></span>
		   </label>
		</td></tr>
		
		<tr><td>" . __("Disable back end access for non admin users?", "vnex") . "<br /><small>" . __("They will be redirected to home page.", "vnex") . "</small></td><td>
		    <label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		       <input id='01' class='vnex-switch-input' type='checkbox' name='vnex_back_access' value='1' " . checked($vnexoption['vnex_back_access'], '1', false) . " />
			   <span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			   <span class='vnex-switch-handle'></span>
		    </label> 
		</td></tr>
		
		<tr><td>" . __("Who can access this plugin", "vnex") . "<br><small> " . __("Only the current user - Login:", "vnex") . " <code>". $current_user->user_login ."</code>, ID: <code>" .get_current_user_id()."</code> <small> </td><td>
		    <label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		      <input class='vnex-switch-input' type='checkbox' name='vnex_role' value='1' " . checked($vnexoption['vnex_role'], '1', false) . " />
			  <span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			  <span class='vnex-switch-handle'></span>
		    </label>
		    <input class='vnex-switch-input' type='hidden' name='vnex_role_id' value='" . get_current_user_id().  "' />
		</td></tr>

		<tr><td>" . __("Customize the error message?", "vnex") . "<br/><small>" . __("Customize the system error message...", "vnex") . "</small></td><td>
		    <label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		      <input onchange='vnex_customize_error_enable()' id='vnex_customize_error_id' class='vnex-switch-input' type='checkbox' name='vnex_admin_errors' value='1' " . checked($vnexoption['vnex_admin_errors'], '1', false) . " />
			  <span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			  <span class='vnex-switch-handle'></span>
		    </label> <input type='text' style='width: 90%; float: right;'  id='vnex_customize_error_id_1' placeholder='Set your message' name='vnex_admin_message' value='" . $vnexoption['vnex_admin_message'] . "' />
		</td></tr>

	

		<tr><td>" . __("Logout redirect to home", "vnex") . "<br /><small>" . __("Logout redirect pages without a form", "vnex") . "</small></td><td>
		    <label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		      <input class='vnex-switch-input' type='checkbox' name='logout_redirect_pages' value='1' " . checked($vnexoption['logout_redirect_pages'], '1', false) . " />
			  <span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			  <span class='vnex-switch-handle'></span>
		    </label>
		</td></tr>

		<tr><td>" . __("Secure logins SSL admin", "vnex") . "<br /><small>" . __("When you want to secure logins and the admin area so that both passwords and cookies are never sent in the clear.", "vnex") . "</small></td><td>
		    <label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		      <input class='vnex-switch-input' type='checkbox' name='vnex_secure_logins_admin' value='1' " . checked($vnexoption['vnex_secure_logins_admin'], '1', false) . " />
			  <span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			  <span class='vnex-switch-handle'></span>
		    </label> 
		</td></tr>

		<tr><td>" . __("Maintenance mode", "vnex") . "<br/><small>" . __("Enable system maintenance notifications for visitors", "vnex") . "</small></td><td>
		    <label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		      <input onchange='vnex_maintenance_enable()' id='vnex_maintenance_id' class='vnex-switch-input' type='checkbox' name='vnex_wp_maintenance_mode' value='1' " . checked($vnexoption['vnex_wp_maintenance_mode'], '1', false) . " />
			  <span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			  <span class='vnex-switch-handle'></span>
		    </label>
		</td></tr>

		<tr><td>" . __("Do not allow for email", "vnex") . "<br /><small>" . __("Do not allow members to email.", "vnex") . "</small></td><td>
		    <label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		      <input class='vnex-switch-input' type='checkbox' name='vnex_not_allow_for_email' value='1' " . checked($vnexoption['vnex_not_allow_for_email'], '1', false) . " />
			  <span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			  <span class='vnex-switch-handle'></span>
		    </label> 
		</td></tr>


		

    </table></div></div></div>";

// Tab 09 (Woocomeres)
	echo "<div class='tab-panel panel9'>
	<div class='postbox'><h3 class='hndle'>💡 " . __("Be Careful!", "vnex") . "</h3>
	<div class='inside'>
	<table style='margin-top:10px;' class='wp-list-table widefat striped'>
		<tr><td width='50%'>" . __("Disable WooCommerce Cart", "vnex") . "<br /><small>" . __("Disable WooCommerce Ajax Cart Fragments On Static Homepage or On All page", "vnex") . "</td><td>
			<select class='widefat' name='disable_woocommerce_cart_fragmentation'>
				<option value=''>" . __("No") . "</option>
				<option value='1' ". selected( $vnexoption['disable_woocommerce_cart_fragmentation'], 1 , false) .">" . __("Only Home", "vnex") . "</option>
				<option value='2' ". selected( $vnexoption['disable_woocommerce_cart_fragmentation'], 2 , false) .">" . __("On All page", "vnex") . "</option>
			</select>
	    </td></tr>

		<tr><td>" . __("Disabled Woocommerce Admin", "vnex") . "<br /><small>" . __("Disable the new WooCommerce Admin package in WooCommerce (Analytics)", "vnex") . "</small></td><td>
		    <label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		      <input class='vnex-switch-input' type='checkbox' name='vnex_wc_disabled' value='1' " . checked($vnexoption['vnex_wc_disabled'], '1', false) . " />
			  <span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			  <span class='vnex-switch-handle'></span>
		    </label> 
		</td></tr>

		<tr><td>" . __("Disabled Woocommerce Scripts", "vnex") . "<br /><small>" . __("Disables WooCommerce scripts and styles except on product, cart, and checkout pages.", "vnex") . "</small></td><td>
		    <label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		      <input class='vnex-switch-input' type='checkbox' name='disable_woocommerce_scripts' value='1' " . checked($vnexoption['disable_woocommerce_scripts'], '1', false) . " />
			  <span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			  <span class='vnex-switch-handle'></span>
		    </label> 
		</td></tr>

		<tr><td>" . __("Disabled Woocommerce Status Meta Box", "vnex") . "<br /><small>" . __("Disables WooCommerce status meta box from the WP Admin Dashboard.", "vnex") . "</small></td><td>
		    <label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		      <input class='vnex-switch-input' type='checkbox' name='disable_woocommerce_status' value='1' " . checked($vnexoption['disable_woocommerce_status'], '1', false) . " />
			  <span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			  <span class='vnex-switch-handle'></span>
		    </label> 
		</td></tr>

		<tr><td>" . __("Disabled Woocommerce Widgets", "vnex") . "<br /><small>" . __("Disables all WooCommerce widgets.", "vnex") . "</small></td><td>
		    <label class='vnex-switch vnex-switch-text vnex-switch-danger'>
		      <input class='vnex-switch-input' type='checkbox' name='disable_woocommerce_widgets' value='1' " . checked($vnexoption['disable_woocommerce_widgets'], '1', false) . " />
			  <span class='vnex-switch-label' data-off='Off' data-on='On'></span>
			  <span class='vnex-switch-handle'></span>
		    </label> 
		</td></tr>
    </table></div></div></div>";

// Tab 10 (Premium)
	echo "<div class='tab-panel panel10'>
	<div class='postbox'><h3 class='hndle'>" . __("VIP Member", "vnex") . " - " . __("Contact me:", "vnex") . " <a href='mailto:huynhsitien@gmail.com'>" . __("Email: huynhsitien@gmail.com", "vnex") . "</a></h3>
	<div class='inside'>
	<table style='margin-top:10px;' class='wp-list-table widefat striped'> 
		<tr><td width='50%'>" . __("Auto Save Images (Woocommerce)", "vnex") . "</td></tr>
		<tr><td>" . __("Quick Remove Menu Item", "vnex") . "<br /><small>" . __("Delete & Duplicate menu item quickly", "vnex") . "</small></td></tr>
		<tr><td>" . __("PrismJS – Syntax Highlighter", "vnex") . "<br /><small>" . __("Easily highlight your code on WordPress with WP PrismJS", "vnex") . "</small></td></tr>  
    </table></div></div></div>";
		  
	echo "<script type=\"text/javascript\">
                function vnex_auto_resize_images_enable () {
                    var vnex_ari = document.getElementById('vnex_auto_resize_id');
                    var vnex_ari_ok = vnex_ari.checked;
                    document.getElementById('vnex_auto_resize_id_1').disabled = ! vnex_ari_ok;
                    document.getElementById('vnex_auto_resize_id_2').disabled = ! vnex_ari_ok;
                    document.getElementById('vnex_auto_resize_id_3').disabled = ! vnex_ari_ok;
                    document.getElementById('vnex_auto_resize_id_4').disabled = ! vnex_ari_ok;
                    document.getElementById('vnex_auto_resize_id_5').disabled = ! vnex_ari_ok;
                }
                function vnex_auto_save_images_enable () {
                    var vnex_asi = document.getElementById('vnex_auto_save_id');
                    var vnex_asi_ok = vnex_asi.checked;
                    document.getElementById('vnex_auto_save_id_1').disabled = ! vnex_asi_ok;
                    document.getElementById('vnex_auto_save_id_2').disabled = ! vnex_asi_ok;
                    document.getElementById('vnex_auto_save_id_3').disabled = ! vnex_asi_ok;
                }
                function vnex_smtp_enable () {
                    var vnex_smtp_check = document.getElementById('vnex_smtp_onoff');
                    var vnex_smtp_ok = vnex_smtp_check.checked;
                    document.getElementById('vnex_smtp_1').disabled = ! vnex_smtp_ok;
                    document.getElementById('vnex_smtp_2').disabled = ! vnex_smtp_ok;
                    document.getElementById('vnex_smtp_3').disabled = ! vnex_smtp_ok;
                }
				function vnex_customize_error_enable () {
                    var vnex_sm_check = document.getElementById('vnex_customize_error_id');
                    var vnex_sm_ok = vnex_sm_check.checked;
                    document.getElementById('vnex_customize_error_id_1').disabled = ! vnex_sm_ok;
                }
				function vnex_maintenance_enable () {
                    var vnex_smn_check = document.getElementById('vnex_maintenance_id');
                    var vnex_smn_ok = vnex_smn_check.checked;
                    document.getElementById('vnex_maintenance_id_1').disabled = ! vnex_smn_ok;
                }
                vnex_auto_resize_images_enable();
                vnex_auto_save_images_enable();
                vnex_smtp_enable();
				vnex_customize_error_enable();
				vnex_maintenance_enable ();
/*
function vnex_comments_disable () {
    var allowCommentsCheckbox = document.getElementById('allow_comments_id');
    allowCommentsCheckbox.addEventListener('change', function(event) {
       if (event.target.checked) {
         document.getElementById('vnex_select').disabled = true;
       } else {
         document.getElementById('vnex_select').disabled = false;
       }
}, false);}
vnex_comments_disable();

document.addEventListener('DOMContentLoaded', function (event) {
    var _selector = document.querySelector('input[name=myCheckbox]');
    _selector.addEventListener('change', function (event) {
        if (_selector.checked) {
            document.getElementById('myDiv1').style.backgroundColor = 'red';
        } else {
            document.getElementById('myDiv1').style.backgroundColor = 'blue';
        }
    });
});

window.onload = function() {
            var check = document.getElementById('01');
            check.onchange = function() {
                if (this.checked == true)
                    document.getElementById('myDiv').disabled=true;
                else
                    document.getElementById('myDiv').disabled = false;
            };
        };
*/
 function Checkradiobutton(){
  if(document.getElementById('r1').checked || document.getElementById('r2').unchecked || document.getElementById('r3').checked)
   {
        document.getElementById('otherPosition').disabled=true;
        document.getElementById('url_spamcheck_id').disabled=true;
        document.getElementById('remove_author_uri_id').disabled=true;
        document.getElementById('remove_author_txtlink_id').disabled=true;
        document.getElementById('vnex_disable_turning_url').disabled=true;
        document.getElementById('vnex_hide_existing_comments').disabled=true;
        document.getElementById('vnex_open_link_new_tab').disabled=true;
        document.getElementById('vnex_filter_comments_text').disabled=true;
        
   }else{
        document.getElementById('otherPosition').disabled = false;
        document.getElementById('url_spamcheck_id').disabled=false;
        document.getElementById('remove_author_uri_id').disabled=false;
        document.getElementById('remove_author_txtlink_id').disabled=false;
        document.getElementById('vnex_disable_turning_url').disabled=false;
        document.getElementById('vnex_hide_existing_comments').disabled=false;
        document.getElementById('vnex_open_link_new_tab').disabled=false;
        document.getElementById('vnex_filter_comments_text').disabled=false;
        }
 }
 Checkradiobutton();

          </script>";
echo "</div></div>";

	wp_nonce_field( 'vnex-permanently-options' );
	echo "<div class='tablenav bottom'>
		<div class='alignleft bulkactions'>
			<input class='button button-primary button-large' type='submit' name='vnex_save_options' value='" . __("Save") . "' />
		</div>
		<div class='alignright'>
			<input class='button button-red button-large' type='submit' onclick='return confirm(" . __("\"Do you want to clear all? \"", "vnex") . ")' name='vnex_reset_options' value='" . __("Clear selection.") . "' />
		</div>
		<br class='clear'></div>
		
</div>
		<div id='postbox-container-1' class='postbox-container'>
			<h2> 🇻🇳 " . __("Awesome !!!", "vnex") . "</h2>
		<table class='wp-list-table widefat striped'>
			<tr><td>" . __("If you like the plugin, please buy me a beer 🍻 / coffee ☕️ to inspire me to develop further.", "vnex") . "</td></tr>
			
			<tr><td>
				<div class='vnex-stars'>
					<a href='https://wordpress.org/support/plugin/wp-extra/reviews/?filter=5#new-post' target='_blank'><span class='dashicons dashicons-star-filled'></span><span class='dashicons dashicons-star-filled'></span><span class='dashicons dashicons-star-filled'></span><span class='dashicons dashicons-star-filled'></span><span class='dashicons dashicons-star-filled'></span>
					</a>
				</div>
			</td></tr>
				
			<tr><td>
				<div class='vnex-review-details'>
					<img class='vnex-review-avatar' src='https://ps.w.org/wp-extra/assets/icon-128x128.png'>
					<a href='https://wordpress.org/support/plugin/wp-extra/reviews/?filter=5#new-post' target='_blank'><span class='vnex-review-author'>WP Extra<br>@ WPVN Team</span></a>
				</div>
			</td></tr>		
		</table>
        </div>
    </div>
    </div></form></div>";
	}
}

function vnex_save()
{
    if (isset($_POST['vnex_save_options'])) {
		check_admin_referer( 'vnex-permanently-options' );
        $vnex_saveops = array(
            'vnex_role' => !empty($_POST['vnex_role']) ? sanitize_text_field( $_POST['vnex_role'] ) : '',
            'vnex_role_id' => !empty($_POST['vnex_role_id']) ? sanitize_text_field( $_POST['vnex_role_id'] ) : '',
            'vnex_remove_category' => !empty($_POST['vnex_remove_category']) ? sanitize_text_field( $_POST['vnex_remove_category'] ) : '',
            'vnex_recaptcha' => !empty($_POST['vnex_recaptcha']) ? sanitize_text_field( $_POST['vnex_recaptcha'] ) : '',
            'vnex_recaptcha_badge' => !empty($_POST['vnex_recaptcha_badge']) ? sanitize_text_field( $_POST['vnex_recaptcha_badge'] ) : '',
            'vnex_auto_links' => !empty($_POST['vnex_auto_links']) ? sanitize_text_field( $_POST['vnex_auto_links'] ) : '',
            'vnex_image_limit' => !empty($_POST['vnex_image_limit']) ? sanitize_text_field( $_POST['vnex_image_limit'] ) : '',
            'vnex_image_resize' => !empty($_POST['vnex_image_resize']) ? sanitize_text_field( $_POST['vnex_image_resize'] ) : '',
            'vnex_image_re_compression' => !empty($_POST['vnex_image_re_compression']) ? sanitize_text_field( $_POST['vnex_image_re_compression'] ) : '',
            'vnex_image_quality' => !empty($_POST['vnex_image_quality']) ? sanitize_text_field( $_POST['vnex_image_quality'] ) : '',
            'vnex_image_maximum_height' => !empty($_POST['vnex_image_maximum_height']) ? sanitize_text_field( $_POST['vnex_image_maximum_height'] ) : '',
            'vnex_image_maximum_width' => !empty($_POST['vnex_image_maximum_width']) ? sanitize_text_field( $_POST['vnex_image_maximum_width'] ) : '',
            'vnex_add_header' => !empty($_POST['vnex_add_header']) ? wp_kses_stripslashes(wp_kses_decode_entities ($_POST['vnex_add_header'] )) : '',
            'vnex_add_footer' => !empty($_POST['vnex_add_footer']) ? wp_kses_stripslashes(wp_kses_decode_entities ($_POST['vnex_add_footer'])) : '',
            'vnex_html_custom_css' => !empty($_POST['vnex_html_custom_css']) ? wp_kses_stripslashes(wp_kses_decode_entities ($_POST['vnex_html_custom_css'])) : '',
            'vnex_html_custom_css_tablet_maxwidth' => !empty($_POST['vnex_html_custom_css_tablet_maxwidth']) ? sanitize_text_field( $_POST['vnex_html_custom_css_tablet_maxwidth'] ) : '',
            'vnex_html_custom_css_tablet' => !empty($_POST['vnex_html_custom_css_tablet']) ? wp_kses_stripslashes(wp_kses_decode_entities ($_POST['vnex_html_custom_css_tablet'])) : '',
            'vnex_html_custom_css_mobile_maxwidth' => !empty($_POST['vnex_html_custom_css_mobile_maxwidth']) ? sanitize_text_field( $_POST['vnex_html_custom_css_mobile_maxwidth'] ) : '',
            'vnex_html_custom_css_mobile' => !empty($_POST['vnex_html_custom_css_mobile']) ? wp_kses_stripslashes(wp_kses_decode_entities ($_POST['vnex_html_custom_css_mobile'])) : '',
            'vnex_remove_menu_tools' => !empty($_POST['vnex_remove_menu_tools']) ? sanitize_text_field( $_POST['vnex_remove_menu_tools'] ) : '',
            'vnex_disable_comments' => !empty($_POST['vnex_disable_comments']) ? sanitize_text_field( $_POST['vnex_disable_comments'] ) : '',
            'vnex_clone_post' => !empty($_POST['vnex_clone_post']) ? sanitize_text_field( $_POST['vnex_clone_post'] ) : '',
            'vnex_clone_widgets' => !empty($_POST['vnex_clone_widgets']) ? sanitize_text_field( $_POST['vnex_clone_widgets'] ) : '',
            'vnex_remove_menu_admin' => !empty($_POST['vnex_remove_menu_admin']) ? sanitize_text_field( $_POST['vnex_remove_menu_admin'] ) : '',			
            'vnex_404_home' => !empty($_POST['vnex_404_home']) ? sanitize_text_field( $_POST['vnex_404_home'] ) : '',
            'vnex_page_html' => !empty($_POST['vnex_page_html']) ? sanitize_text_field( $_POST['vnex_page_html'] ) : '',
            'vnex_auto_update' => !empty($_POST['vnex_auto_update']) ? sanitize_text_field( $_POST['vnex_auto_update'] ) : '',
			//SMTP 
            'vnex_smtp' => !empty($_POST['vnex_smtp']) ? sanitize_text_field( $_POST['vnex_smtp'] ) : '',
            'vnex_smtp_host' => !empty($_POST['vnex_smtp_host']) ? sanitize_text_field( $_POST['vnex_smtp_host'] ) : '',
            'vnex_smtp_port' => !empty($_POST['vnex_smtp_port']) ? sanitize_text_field( $_POST['vnex_smtp_port'] ) : '',
            'vnex_smtp_replyto' => !empty($_POST['vnex_smtp_replyto']) ? sanitize_text_field( $_POST['vnex_smtp_replyto'] ) : '',
            'vnex_smtp_username' => !empty($_POST['vnex_smtp_username']) ? sanitize_text_field( $_POST['vnex_smtp_username'] ) : '',
            'vnex_smtp_password' => !empty($_POST['vnex_smtp_password']) ? base64_encode(sanitize_text_field(wp_unslash( $_POST['vnex_smtp_password']))) : '',
            'vnex_smtp_ssl' => !empty($_POST['vnex_smtp_ssl']) ? sanitize_text_field( $_POST['vnex_smtp_ssl'] ) : '',
            'vnex_smtp_from_email' => !empty($_POST['vnex_smtp_from_email']) ? sanitize_text_field( $_POST['vnex_smtp_from_email'] ) : '',
            'vnex_smtp_from_name' => !empty($_POST['vnex_smtp_from_name']) ? sanitize_text_field( $_POST['vnex_smtp_from_name'] ) : '',
            'vnex_shortcode' => !empty($_POST['vnex_shortcode']) ? wp_kses_stripslashes(wp_kses_decode_entities ($_POST['vnex_shortcode'])) : '',
            'vnex_set_image_meta' => !empty($_POST['vnex_set_image_meta']) ? sanitize_text_field( $_POST['vnex_set_image_meta'] ) : '',
            'vnex_disable_xmlrpc' => !empty($_POST['vnex_disable_xmlrpc']) ? sanitize_text_field( $_POST['vnex_disable_xmlrpc'] ) : '',
            'vnex_copyright' => !empty($_POST['vnex_copyright']) ? sanitize_text_field( $_POST['vnex_copyright'] ) : '',
            'vnex_dashboard_notice' => !empty($_POST['vnex_dashboard_notice']) ? wp_kses_stripslashes(wp_kses_decode_entities ($_POST['vnex_dashboard_notice'])) : '',
            'vnex_remove_dashboard' => !empty($_POST['vnex_remove_dashboard']) ? sanitize_text_field( $_POST['vnex_remove_dashboard'] ) : '',
            'vnex_admin_slug' => !empty($_POST['vnex_admin_slug']) ? sanitize_text_field( $_POST['vnex_admin_slug'] ) : '',
            'vnex_disable_emojis' => !empty($_POST['vnex_disable_emojis']) ? sanitize_text_field( $_POST['vnex_disable_emojis'] ) : '',
            'vnex_mce' => !empty($_POST['vnex_mce']) ? sanitize_text_field( $_POST['vnex_mce'] ) : '',
            'vnex_admin_background' => !empty($_POST['vnex_admin_background']) ? sanitize_text_field( $_POST['vnex_admin_background'] ) : '',
            'vnex_admin_background_color' => !empty($_POST['vnex_admin_background_color']) ? sanitize_text_field( $_POST['vnex_admin_background_color'] ) : '',
            'vnex_admin_logo' => !empty($_POST['vnex_admin_logo']) ? sanitize_text_field( $_POST['vnex_admin_logo'] ) : '',
            'vnex_auto_set_featured_image' => !empty($_POST['vnex_auto_set_featured_image']) ? sanitize_text_field( $_POST['vnex_auto_set_featured_image'] ) : '',
            'vnex_auto_set_featured_image_url' => !empty($_POST['vnex_auto_set_featured_image_url']) ? sanitize_text_field( $_POST['vnex_auto_set_featured_image_url'] ) : '',
            'vnex_auto_save_images' => !empty($_POST['vnex_auto_save_images']) ? sanitize_text_field( $_POST['vnex_auto_save_images'] ) : '',
            'vnex_auto_save_images_woo' => !empty($_POST['vnex_auto_save_images_woo']) ? sanitize_text_field( $_POST['vnex_auto_save_images_woo'] ) : '',
            'vnex_auto_save_images_status' => !empty($_POST['vnex_auto_save_images_status']) ? sanitize_text_field( $_POST['vnex_auto_save_images_status'] ) : '',
            'vnex_auto_save_images_media_file' => !empty($_POST['vnex_auto_save_images_media_file']) ? sanitize_text_field( $_POST['vnex_auto_save_images_media_file'] ) : '',
            'vnex_auto_save_images_filename' => !empty($_POST['vnex_auto_save_images_filename']) ? sanitize_text_field( $_POST['vnex_auto_save_images_filename'] ) : '',
            'vnex_donotcopy' => !empty($_POST['vnex_donotcopy']) ? sanitize_text_field( $_POST['vnex_donotcopy'] ) : '',
            'vnex_allow_svg' => !empty($_POST['vnex_allow_svg']) ? sanitize_text_field( $_POST['vnex_allow_svg'] ) : '',
            'vnex_remove_gutenberg' => !empty($_POST['vnex_remove_gutenberg']) ? sanitize_text_field( $_POST['vnex_remove_gutenberg'] ) : '',
            'vnex_mce_prismjs' => !empty($_POST['vnex_mce_prismjs']) ? sanitize_text_field( $_POST['vnex_mce_prismjs'] ) : '',
            'vnex_button_post' => !empty($_POST['vnex_button_post']) ? sanitize_text_field( $_POST['vnex_button_post'] ) : '',
            'vnex_post_revisions' => !empty($_POST['vnex_post_revisions']) ? sanitize_text_field( $_POST['vnex_post_revisions'] ) : '',
            'vnex_admin_footer' => !empty($_POST['vnex_admin_footer']) ? sanitize_text_field( $_POST['vnex_admin_footer'] ) : '',
            'vnex_remove_head_link' => !empty($_POST['vnex_remove_head_link']) ? sanitize_text_field( $_POST['vnex_remove_head_link'] ) : '',
            'vnex_hide_admin_bar' => !empty($_POST['vnex_hide_admin_bar']) ? sanitize_text_field( $_POST['vnex_hide_admin_bar'] ) : '',
            'vnex_wc_disabled' => !empty($_POST['vnex_wc_disabled']) ? sanitize_text_field( $_POST['vnex_wc_disabled'] ) : '',
            'vnex_back_access' => !empty($_POST['vnex_back_access']) ? sanitize_text_field( $_POST['vnex_back_access'] ) : '',
            'vnex_disable_feed' => !empty($_POST['vnex_disable_feed']) ? sanitize_text_field( $_POST['vnex_disable_feed'] ) : '',
            'vnex_remove_version' => !empty($_POST['vnex_remove_version']) ? sanitize_text_field( $_POST['vnex_remove_version'] ) : '',
			'vnex_admin_message' => !empty($_POST['vnex_admin_message']) ? sanitize_text_field( $_POST['vnex_admin_message'] ) : '',
		    'vnex_admin_errors' => !empty($_POST['vnex_admin_errors']) ? sanitize_text_field( $_POST['vnex_admin_errors'] ) : '',
			'disable_woocommerce_cart_fragmentation' => !empty($_POST['disable_woocommerce_cart_fragmentation']) ? sanitize_text_field( $_POST['disable_woocommerce_cart_fragmentation'] ) : '',
			'vnex_minimal_comment_length' => !empty($_POST['vnex_minimal_comment_length']) ? sanitize_text_field( $_POST['vnex_minimal_comment_length'] ) : '',
			'vnex_comments_url_spamcheck' => !empty($_POST['vnex_comments_url_spamcheck']) ? sanitize_text_field( $_POST['vnex_comments_url_spamcheck'] ) : '',
			'remove_author_uri' => !empty($_POST['remove_author_uri']) ? sanitize_text_field( $_POST['remove_author_uri'] ) : '',
			'remove_author_txtlink' => !empty($_POST['remove_author_txtlink']) ? sanitize_text_field( $_POST['remove_author_txtlink'] ) : '',
			'disable_turning_link' => !empty($_POST['disable_turning_link']) ? sanitize_text_field( $_POST['disable_turning_link'] ) : '',
			'remove_comment_link' => !empty($_POST['remove_comment_link']) ? sanitize_text_field( $_POST['remove_comment_link'] ) : '',
			'hide_existing_cmts' => !empty($_POST['hide_existing_cmts']) ? sanitize_text_field( $_POST['hide_existing_cmts'] ) : '',
			'open_link_innewtab' => !empty($_POST['open_link_innewtab']) ? sanitize_text_field( $_POST['open_link_innewtab'] ) : '',
			'search_results_return_one_post' => !empty($_POST['search_results_return_one_post']) ? sanitize_text_field( $_POST['search_results_return_one_post'] ) : '',
			'logout_redirect_pages' => !empty($_POST['logout_redirect_pages']) ? sanitize_text_field( $_POST['logout_redirect_pages'] ) : '',
			'vnex_disable_jm' => !empty($_POST['vnex_disable_jm']) ? sanitize_text_field( $_POST['vnex_disable_jm'] ) : '',
			'vnex_empty_trash_bin' => !empty($_POST['vnex_empty_trash_bin']) ? sanitize_text_field( $_POST['vnex_empty_trash_bin'] ) : '',
			'vnex_post_autosave' => !empty($_POST['vnex_post_autosave']) ? sanitize_text_field( $_POST['vnex_post_autosave'] ) : '',
			'vnex_secure_logins_admin' => !empty($_POST['vnex_secure_logins_admin']) ? sanitize_text_field( $_POST['vnex_secure_logins_admin'] ) : '',
			'disable_self_pings' => !empty($_POST['disable_self_pings']) ? sanitize_text_field( $_POST['disable_self_pings'] ) : '',
			'vnex_clear_whitespace_in_js_and_css' => !empty($_POST['vnex_clear_whitespace_in_js_and_css']) ? sanitize_text_field( $_POST['vnex_clear_whitespace_in_js_and_css'] ) : '',
			'disable_heartbeat' => !empty($_POST['disable_heartbeat']) ? sanitize_text_field( $_POST['disable_heartbeat'] ) : '',
			'vnex_disable_embeds' => !empty($_POST['vnex_disable_embeds']) ? sanitize_text_field( $_POST['vnex_disable_embeds'] ) : '',
			'vnex_remove_query_strings' => !empty($_POST['vnex_remove_query_strings']) ? sanitize_text_field( $_POST['vnex_remove_query_strings'] ) : '',
			'vnex_remove_shortlink' => !empty($_POST['vnex_remove_shortlink']) ? sanitize_text_field( $_POST['vnex_remove_shortlink'] ) : '',
			'vnex_remove_rest_api_link' => !empty($_POST['vnex_remove_rest_api_link']) ? sanitize_text_field( $_POST['vnex_remove_rest_api_link'] ) : '',
			'vnex_disable_dashicon' => !empty($_POST['vnex_disable_dashicon']) ? sanitize_text_field( $_POST['vnex_disable_dashicon'] ) : '',
			'disable_woocommerce_scripts' => !empty($_POST['disable_woocommerce_scripts']) ? sanitize_text_field( $_POST['disable_woocommerce_scripts'] ) : '',
			'disable_woocommerce_status' => !empty($_POST['disable_woocommerce_status']) ? sanitize_text_field( $_POST['disable_woocommerce_status'] ) : '',
			'disable_woocommerce_widgets' => !empty($_POST['disable_woocommerce_widgets']) ? sanitize_text_field( $_POST['disable_woocommerce_widgets'] ) : '',
			'disable_rest_api' => !empty($_POST['disable_rest_api']) ? sanitize_text_field( $_POST['disable_rest_api'] ) : '',
			'heartbeat_frequency' => !empty($_POST['heartbeat_frequency']) ? sanitize_text_field( $_POST['heartbeat_frequency'] ) : '',
			'vnex_wp_maintenance_mode' => !empty($_POST['vnex_wp_maintenance_mode']) ? sanitize_text_field( $_POST['vnex_wp_maintenance_mode'] ) : '',
			'vnex_not_allow_for_email' => !empty($_POST['vnex_not_allow_for_email']) ? sanitize_text_field( $_POST['vnex_not_allow_for_email'] ) : '',
			'disable_google_fonts' => !empty($_POST['disable_google_fonts']) ? sanitize_text_field( $_POST['disable_google_fonts'] ) : '',
			
        );
        update_option('vnex_options', $vnex_saveops);
        return true;
    } 
	if (isset($_POST['vnex_reset_options'])) {
        $vnex_saveops = array(
            'vnex_role' => '0',
            'vnex_role_id' => '',
            'vnex_remove_category' => '',
            'vnex_recaptcha' => '',
			'vnex_recaptcha_badge' => '',
            'vnex_auto_links' => '',
            'vnex_image_limit' => '',
            'vnex_image_resize' => '',
            'vnex_image_re_compression' => '',
            'vnex_image_quality' => '90',
            'vnex_image_maximum_height' => '1000',
            'vnex_image_maximum_width' => '1000',
            'vnex_add_header' => '',
			'vnex_add_footer' => '',
			'vnex_html_custom_css' => '',
			'vnex_html_custom_css_tablet_maxwidth' => '',
			'vnex_html_custom_css_tablet' => '',
			'vnex_html_custom_css_mobile_maxwidth' => '',
			'vnex_html_custom_css_mobile' => '',
			'vnex_remove_menu_tools' => '0',
			'vnex_disable_comments' => '0',
			'vnex_clone_post' => '',
			'vnex_clone_widgets' => '',
			'vnex_remove_menu_admin' => '',
			'vnex_404_home' => '0',
			'vnex_page_html' => '0',
			'vnex_auto_update' => '0',
			'vnex_smtp' => '',
			'vnex_smtp_host' => '',
			'vnex_smtp_port' => '',
			'vnex_smtp_replyto' => '',
			'vnex_smtp_username' => '',
			'vnex_smtp_password' => '',
			'vnex_smtp_ssl' => '',
			'vnex_smtp_from_name' => '',
			'vnex_smtp_from_email' => '',
			'vnex_shortcode' => '',
			'vnex_set_image_meta' => '0',
			'vnex_disable_xmlrpc' => '0',
			'vnex_copyright' => '0',
			'vnex_remove_dashboard' => '0',
			'vnex_dashboard_notice' => '',
			'vnex_admin_slug' => '0',
			'vnex_disable_emojis' => '0',
			'vnex_mce' => '',
			'vnex_admin_background' => '',
			'vnex_admin_background_color' => '',
			'vnex_admin_logo' => '',
			'vnex_auto_set_featured_image' => '0',
			'vnex_auto_save_images' => '',
			'vnex_auto_save_images_woo' => '',
			'vnex_auto_save_images_status' => '1',
			'vnex_auto_save_images_media_file' => '',
			'vnex_auto_save_images_filename' => '',
			'vnex_donotcopy' => '0',
			'vnex_allow_svg' => '0',
			'vnex_mce_prismjs' => '',
			'vnex_button_post' => '0',
			'vnex_remove_gutenberg' => '0',
			'vnex_post_revisions' => '10',
			'vnex_admin_footer' => '',
			'vnex_remove_head_link' => '0',
			'vnex_hide_admin_bar' => '',
			'vnex_wc_disabled' => '0',
			'vnex_back_access' => '0',
			'vnex_disable_feed' => '0',
			'vnex_remove_version' => '0',
		    'vnex_admin_message' => '0',
			'vnex_admin_errors' => '',
			'vnex_minimal_comment_length' => '',
			'vnex_comments_url_spamcheck' => '0',
			'remove_author_uri' => '0',
			'remove_author_txtlink' => '0',
			'disable_turning_link' => '0',
			'remove_comment_link' => '',
			'hide_existing_cmts' => '',
			'open_link_innewtab' => '',
			'search_results_return_one_post' => '',
			'logout_redirect_pages' => '',
			'vnex_disable_jm' => '',
			'vnex_empty_trash_bin' => '3',
			'vnex_post_autosave' => '5800',
			'vnex_secure_logins_admin' => '0',
			'disable_self_pings' => '0',
			'vnex_clear_whitespace_in_js_and_css' => '0',
			'disable_heartbeat' => '',
			'vnex_disable_embeds' => '0',
			'vnex_remove_query_strings' => '0',
			'vnex_remove_shortlink' => '0',
			'vnex_remove_rest_api_link' => '0',
			'vnex_disable_dashicon' => '0',
			'disable_woocommerce_scripts' => '0',
            'disable_woocommerce_cart_fragmentation' => '0',
            'disable_woocommerce_status' => '0',
            'disable_woocommerce_widgets' => '0',
			'disable_woocommerce_reviews' => '0',
		    'disable_rest_api' => '',
			'heartbeat_frequency' => '',
			'vnex_wp_maintenance_mode' => '0',
			'vnex_not_allow_for_email' => '0',
			'disable_google_fonts' => '0',
			
        );
        delete_option('vnex_options', $vnex_saveops);
        return true;
    }
    return false;
}
function vnex_all_options()
	{
		$vnexoptions = array(
            'vnex_role' => '0',
            'vnex_role_id' => '',
            'vnex_remove_category' => '',
			'vnex_recaptcha' => '',
			'vnex_recaptcha_badge' => '',
			'vnex_auto_links' => '',
			'vnex_image_limit' => '',
            'vnex_image_resize' => '',
            'vnex_image_re_compression' => '',
            'vnex_image_quality' => '90',
			'vnex_image_maximum_height' => '1000',
			'vnex_image_maximum_width' => '1000',
			'vnex_add_header' => '',
			'vnex_add_footer' => '',
			'vnex_html_custom_css' => '',
			'vnex_html_custom_css_tablet_maxwidth' => '',
			'vnex_html_custom_css_tablet' => '',
			'vnex_html_custom_css_mobile_maxwidth' => '',
			'vnex_html_custom_css_mobile' => '',
			'vnex_remove_menu_tools' => '0',
			'vnex_disable_comments' => '0',
			'vnex_clone_post' => '',
			'vnex_clone_widgets' => '',
			'vnex_remove_menu_admin' => '',
			'vnex_404_home' => '0',
			'vnex_page_html' => '0',
			'vnex_auto_update' => '0',
			'vnex_smtp' => '',
			'vnex_smtp_host' => '',
			'vnex_smtp_port' => '',
			'vnex_smtp_replyto' => '',
			'vnex_smtp_username' => '',
			'vnex_smtp_password' => '',
			'vnex_smtp_ssl' => '',
			'vnex_smtp_from_name' => '',
			'vnex_smtp_from_email' => '',
			'vnex_shortcode' => '',
			'vnex_set_image_meta' => '0',
			'vnex_disable_xmlrpc' => '0',
			'vnex_copyright' => '0',
			'vnex_remove_dashboard' => '0',
			'vnex_dashboard_notice' => '',
			'vnex_admin_slug' => '0',
			'vnex_disable_emojis' => '0',
			'vnex_mce' => '',
			'vnex_admin_background' => '',
			'vnex_admin_background_color' => '',
			'vnex_admin_logo' => '',
			'vnex_auto_set_featured_image' => '0',
			'vnex_auto_save_images' => '',
			'vnex_auto_save_images_woo' => '',
			'vnex_auto_save_images_status' => '1',
			'vnex_auto_save_images_media_file' => '',
			'vnex_auto_save_images_filename' => '',
			'vnex_donotcopy' => '0',
			'vnex_allow_svg' => '0',
			'vnex_mce_prismjs' => '',
			'vnex_button_post' => '0',
			'vnex_remove_gutenberg' => '0',
			'vnex_post_revisions' => '10',
			'vnex_admin_footer' => '',
			'vnex_remove_head_link' => '0',
			'vnex_hide_admin_bar' => '',
			'vnex_wc_disabled' => '0',
			'vnex_back_access' => '0',
			'vnex_disable_feed' => '0',
			'vnex_remove_version' => '0',
		    'vnex_admin_errors' => '',
			'vnex_admin_message' => '',
			'vnex_minimal_comment_length' => '',
			'vnex_comments_url_spamcheck' => '0',
			'remove_author_uri' => '0',
			'remove_author_txtlink' => '0',
			'disable_turning_link' => '0',
			'remove_comment_link' => '',
			'hide_existing_cmts' => '',
			'open_link_innewtab' => '',
			'search_results_return_one_post' => '',
			'logout_redirect_pages' => '',
			'vnex_disable_jm' => '',
			'vnex_empty_trash_bin' => '3',
			'vnex_post_autosave' => '5800',
			'vnex_secure_logins_admin' => '0',
			'disable_self_pings' => '0',
			'vnex_clear_whitespace_in_js_and_css' => '0',
			'disable_heartbeat' => '',
			'vnex_disable_embeds' => '0',
			'vnex_remove_query_strings' => '0',
			'vnex_remove_shortlink' => '0',
			'vnex_remove_rest_api_link' => '0',
			'vnex_disable_dashicon' => '0',
			'disable_woocommerce_scripts' => '0',
            'disable_woocommerce_cart_fragmentation' => '0',
            'disable_woocommerce_status' => '0',
            'disable_woocommerce_widgets' => '0',
			'disable_woocommerce_reviews' => '0',
		    'disable_rest_api' => '',
			'heartbeat_frequency' => '',
			'vnex_wp_maintenance_mode' => '0',
			'vnex_not_allow_for_email' => '0',
			'disable_google_fonts' => '0',
			
		);
		$vnexops = get_option('vnex_options');
		if (!empty($vnexops)) {
			foreach ($vnexops as $key => $option)
				$vnexoptions[$key] = $option;
		}
	update_option('vnex_options', $vnexoptions);
	return $vnexoptions;
}

?>