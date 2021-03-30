<?php
if ($vnexoption['vnex_image_limit']) {
	add_filter('wp_handle_upload_prefilter','vnex_validate_image_limit');
	function vnex_validate_image_limit( $file ) {
		$vnexoption = vnex_all_options();
		if ($vnexoption['vnex_image_limit']){
			$image_size = $file['size'] / 1024;
			$limit = esc_textarea($vnexoption['vnex_image_limit']);
			$is_image = strpos($file['type'], 'image');
			if ( ( $image_size > $limit ) && ($is_image !== false) ) {
				$file['error'] = __( 'Your picture is too large. It has to be smaller than ', 'vnex' ) . ''. $limit .'KB';
				return $file;
			}
			else
				return $file;
		}
		
	}
}

add_action('wp_handle_upload', 'vnex_upload_resize');
function vnex_upload_resize ($image_data){
	vnex_resize_error_log("**-start--resize-image-upload");
	$vnexoption = vnex_all_options();
	$compression_level = $vnexoption['vnex_image_quality'];
	$max_width  = $vnexoption['vnex_image_maximum_width'];
	$max_height = $vnexoption['vnex_image_maximum_height'];
	if($vnexoption['vnex_image_re_compression']) {
	$fatal_error_reported = false;
	$valid_types = array('image/gif','image/png','image/jpeg','image/jpg');
	if(empty($image_data['file']) || empty($image_data['type'])) {
		vnex_resize_error_log("--non-data-in-file-( ".print_r($image_data, true)." )");	
		$fatal_error_reported = true;
	}
	else if(!in_array($image_data['type'], $valid_types)) {
		vnex_resize_error_log("--non-image-type-uploaded-( ".$image_data['type']." )");
		$fatal_error_reported = true;
	}
	vnex_resize_error_log("--filename-( ".$image_data['file']." )");
	$image_editor = wp_get_image_editor($image_data['file']);
	$image_type = $image_data['type'];
	if($fatal_error_reported || is_wp_error($image_editor)) {
		vnex_resize_error_log("--wp-error-reported");
	}
	else {
		$to_save = false;
		$resized = false;
		if($vnexoption['vnex_image_resize']) {
			vnex_resize_error_log("--resizing-enabled");
			$sizes = $image_editor->get_size();
			if((isset($sizes['width']) && $sizes['width'] > $max_width) || (isset($sizes['height']) && $sizes['height'] > $max_height)) {
				$image_editor->resize($max_width, $max_height, false);
				$resized = true;
				$to_save = true;
				$sizes = $image_editor->get_size();
				vnex_resize_error_log("--new-size--".$sizes['width']."x".$sizes['height']);
			}
			else {
				vnex_resize_error_log("--no-resizing-needed");
			}
		}
		else {
			vnex_resize_error_log("--no-resizing-requested");
		}
		if($vnexoption['vnex_image_re_compression'] && ($image_type=='image/jpg' || $image_type=='image/jpeg')) {
			$to_save = true;
			vnex_resize_error_log("--compression-level--q-".$compression_level);
		}
		elseif(!$resized) {
			vnex_resize_error_log("--no-forced-recompression");
		}
		if($to_save) {
			$image_editor->set_quality($compression_level);
			$saved_image = $image_editor->save($image_data['file']);
			vnex_resize_error_log("--image-saved");
		}
		else {
			vnex_resize_error_log("--no-changes-to-save");
		}
	}
	}
	else {
		vnex_resize_error_log("--no-action-required");
	}
	vnex_resize_error_log("**-end--resize-image-upload\n");
	return $image_data;
}
function vnex_resize_error_log($message) {
	global $DEBUG_LOGGER;
	if($DEBUG_LOGGER) {
		error_log(print_r($message, true));
	}
}

?>