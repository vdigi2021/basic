<?php
class vnex_auto_save_images {
	var $type;
	var $current_post_id;
	var $has_remote_image;
	var $format;
	function __construct() {
		$this->add_actions();
	}
	public function get_current_post_type() {
		$vnexoption = vnex_all_options();
		global $post, $typenow, $current_screen;
		if (isset($_GET['post']) && $_GET['post']) {
			$post_type = get_post_type($_GET['post']);
			return $post_type;
		} 
		if ($vnexoption['vnex_auto_save_images_woo']) {
			if (isset($_GET['product']) && $_GET['product']) {
				$post_type = get_post_type($_GET['product']);
				return $post_type;
			}
		}
		if ( $post && $post->post_type )
			return $post->post_type;
		elseif( $typenow )
			return $typenow;
		elseif( $current_screen && $current_screen->post_type )
			return $current_screen->post_type;
		elseif( isset( $_REQUEST['post_type'] ) )
			return sanitize_key( $_REQUEST['post_type'] );
		return null;
	}
	function add_actions() {
		add_filter( 'wp_insert_post_data', array($this, 'fetch_images_when_saving'), 10, 2);
	}
	function remove_actions() {
		remove_filter( 'wp_insert_post_data', array($this, 'fetch_images_when_saving') );
	}
	public function fetch_images_when_saving($data, $postarr) {
		set_time_limit(0);
		$vnexoption = vnex_all_options();
		if ($vnexoption['vnex_auto_save_images_status'] == 2) $allow = true;
		elseif ($vnexoption['vnex_auto_save_images_status'] == 1 && $data['post_status'] == 'publish') $allow = true;
		else $allow = false;
		if ($allow) {
			$this->has_remote_image = 0;
			$data['post_content'] = addslashes($this->content_save_pre(stripslashes($data['post_content']), $postarr['ID']));
		}
		return $data;
	}
	function fetch_images_after_save($post_id) {
		set_time_limit(0);
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
			return;
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) 
			return;
		$this->current_post_id = $post_id;
		$this->has_remote_image = 0;
		$this->remove_actions();
		$post = get_post($post_id);
		$content = $this->content_save_pre($post->post_content, $post_id);
		remove_action( 'post_updated', 'wp_save_post_revision' );
		wp_update_post(array('ID' => $post_id, 'post_content' => addslashes($content)));
		add_action( 'post_updated', 'wp_save_post_revision', 10, 1 );
		$this->add_actions();
	}
	public function getimagesize($image_url) {
		$params = @getimagesize($image_url);
		$width = $params[0];
		$height = $params[1];
		$this->type = $params['mime'];
		if ($width==null) {
			$file = @file_get_contents( $image_url );
			if ($file) {
				$encoding = $this->fsockopen_image_header($image_url, 'Content-Encoding');
				if ($encoding == 'gzip' && function_exists('gzdecode')) $file = gzdecode($file);
				if (function_exists('getimagesizefromstring')) {
				$params = getimagesizefromstring($file);
					$width = $params[0];
					$height = $params[1];
					$this->type = $params['mime'];
				}
			}
		} else {
			$width = $params[0];
			$height = $params[1];
			$this->type = $params['mime'];
		}
		return array($width, $height, $this->type);
	}
	public function content_save_pre($content, $post_id=null, $action='save') {
		$post = get_post($post_id);
		//if ($post->post_type == 'revision') return;
		// dont save for revisions
		if ( isset( $post->post_type ) && $post->post_type == 'revision' ) {
			return;
		}
		$this->change_attachment_url_to_permalink($content);
		$remote_images = array();
		$preg = preg_match_all('/<img.*?src=\"((?!\").*?)\"/i', stripslashes($content), $matches);
		if ($preg) $remote_images = $matches[1];
		$preg = preg_match_all('/<img.*?src=\'((?!\').*?)\'/i', stripslashes($content), $matches);
		if ($preg) $remote_images = array_merge($remote_images, $matches[1]);
		if(!empty($remote_images)){
			foreach($remote_images as $image_url) {
				if (empty($image_url)) continue;
				$allow=true;
				// check pictrue size
				list($width, $height, $type) = $this->getimagesize($image_url);
				// check if remote image
				if ($allow) {
					$pos = strpos($image_url, get_bloginfo('url'));
					if($pos===false){
						$this->has_remote_image = 1;
						if ($action=="save" && $res=$this->save_images($image_url,$post_id)) {
							$content = $this->format($image_url, $res, $content);
						}
					}
				}
			}
		}
		return apply_filters( 'vnex-auto-save-images-content-save-pre', $content, $post_id );
	}
	public function change_attachment_url_to_permalink(&$content) {
		$pattern = '/<a\s[^>]*href=\"'.$this->encode_pattern(home_url('?attachment_id=')).'(.*?)\".*?>/i';
		if ( preg_match_all($pattern, $content, $matches) ) {
			foreach ($matches[1] as $attachment_id) {
				$attachment = get_post($attachment_id);
				$post = get_post($attachment->post_parent);
				if ($post->post_status != 'draft' && $post->post_status != 'pending' && $post->post_status != 'future') {
					$url = get_permalink($attachment_id);
					$content = preg_replace('/'.$this->encode_pattern(home_url('?attachment_id='.$attachment_id)).'/i', $url, $content);
				}
			}
		}
	}
	public function encode_pattern($str) {
		$str = str_replace('(', '\(', $str);
		$str = str_replace(')', '\)', $str);
		$str = str_replace('{', '\{', $str);
		$str = str_replace('}', '\}', $str);
		$str = str_replace('+', '\+', $str);
		$str = str_replace('.', '\.', $str);
		$str = str_replace('?', '\?', $str);
		$str = str_replace('*', '\*', $str);
		$str = str_replace('/', '\/', $str);
		$str = str_replace('^', '\^', $str);
		$str = str_replace('$', '\$', $str);
		$str = str_replace('|', '\|', $str);
		return $str;
	}
	public function format($image_url, $res, $content) {
		$vnexoption = vnex_all_options();
		$no_match = false;
		$attachment_id = $res['id'];
		$url_path = str_replace(basename($res['file']), '', $res['url']);
		$size = isset($res['sizes'][$this->format['size']]) ? $this->format['size'] : 'full';
		$src = $res['url'];
		$width = $res['width'];
		$height = $res['height'];
		$pattern_image_url = $this->encode_pattern($image_url);
		$preg = false;
		$pattern = '/<a[^<]+><img\s[^>]*'.$pattern_image_url.'.*?>?<[^>]+a>/i';
		$preg = preg_match($pattern, $content, $matches);
		if (!$preg) {
			$pattern = '/<img\s[^>]*'.$pattern_image_url.'.*?>/i';
			if ( preg_match($pattern, $content, $matches) ) {
				$args = $this->set_img_metadata($matches[0], $attachment_id);
			} else {
				$pattern = '/'.$pattern_image_url.'/i';
				$no_match = true;
			}
		}
		$alt = isset($args['alt']) ? ' alt="'.$args['alt'].'"' : '';
		$title = isset($args['title']) ? ' title="'.$args['title'].'"' : '';
		$img = '<img class="size-'.$size.' wp-image-'.$attachment_id.'" src="'.$src.'" width="'.$width.'" height="'.$height.'"'.$alt.$title.' />';
		if ($vnexoption['vnex_auto_save_images_media_file']) {
			$replace = '<a href="'.$res['url'].'">'.$img.'</a>';
		} else {
			$replace = $img;
		}
		if ($no_match) $replace = $res['url'];
		$content = preg_replace($pattern, $replace, $content);
		return $content;
	}
	public function set_img_metadata($img, $attachment_id) {
		$alt = $this->get_post_title() ? $this->get_post_title() : null;
		$title = $this->get_post_title() ? $this->get_post_title() : null;
		if ($alt) update_post_meta($attachment_id, '_wp_attachment_image_alt', $alt);
		if ($title) {
			$attachment = array(
				'ID' => $attachment_id,
				'post_title' => $title
			);
			wp_update_post($attachment);
		}
		return array(
			'alt' => $alt,
			'title' => $title
		);
	}
	public function get_post_title() {
		$post = get_post($this->current_post_id);
		return $post->post_title;
	}
	function fsockopen_image_header($image_url, $mode='Content-Type') {
		$url = parse_url($image_url);
		$fp = @fsockopen($url['host'], 80, $errno, $errstr, 30);
		if ($fp) {
			$out = "HEAD {$url['path']} HTTP/1.1\r\n";
			$out .= "Host: {$url['host']}\r\n";
			$out .= "Connection: Close\r\n\r\n";
			fwrite($fp, $out);
			while (!feof($fp)) {
				$header = fgets($fp);
				if (stripos($header, $mode) !== false) {
					$value = trim(substr($header, strpos($header, ':') + 1));
					return $value;
				}
			}
			fclose($fp);
		}
		return null;
	}
	function save_images($image_url, $post_id){
		$vnexoption = vnex_all_options();
		set_time_limit(0);
		$file=file_get_contents($image_url);
		if ( $file ) {
			$filename=basename($image_url);
			preg_match( '/(.*?)(\.\w+)$/', $filename, $match );
			$post = get_post($post_id);
			$posttitle = $post->post_title;
			$postname = sanitize_title($posttitle);
			if ($vnexoption['vnex_auto_save_images_filename'] == 1 ) {
				$slug_name = $postname;
				$img_name = $slug_name.$match[2];
			} elseif ($vnexoption['vnex_auto_save_images_filename'] == 2 ) {
				$slug_name = $postname.'-'.$post_id;
				$img_name = $slug_name.$match[2];
			} else {
				$img_name = $match[1].$match[2];
			}	
			$res=wp_upload_bits($img_name,'',$file);
			if (isset( $res['error'] ) && !empty($res['error'])) return false;
			$attachment_id = $this->insert_attachment($res['file'], $post_id);
			$res['id'] = $attachment_id;
			$meta_data = wp_get_attachment_metadata($attachment_id);
			$res = @array_merge($res, $meta_data);
			if( !has_post_thumbnail($post_id)) {
				$this->thumbnail_id = $res['id'];
				set_post_thumbnail( $post_id, $attachment_id );
			}
			return $res;
		}
		return false;
	}
	function insert_attachment($file, $id){
		$dirs = wp_upload_dir();
		$filetype = wp_check_filetype($file);
		$attachment=array(
			'guid' => $dirs['baseurl'].'/'._wp_relative_upload_path($file),
			'post_mime_type' => $filetype['type'],
			'post_title' => preg_replace('/\.[^.]+$/','',basename($file)),
			'post_content' => '',
			'post_status' => 'inherit'
		);
		$attach_id = wp_insert_attachment($attachment, $file, $id);
		if (!function_exists('wp_generate_attachment_metadata')) include_once (ABSPATH . DIRECTORY_SEPARATOR . 'wp-admin' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'image.php');
		$attach_data = wp_generate_attachment_metadata($attach_id, $file);
		wp_update_attachment_metadata($attach_id, $attach_data);
		return $attach_id;
	}
}
new vnex_auto_save_images;
?>