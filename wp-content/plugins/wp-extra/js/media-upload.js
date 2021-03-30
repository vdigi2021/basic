// Media upload
jQuery(document).ready(function($) {
	var vnex_media_upload;
	$( '#vnex_media_button' ).click(function(e) {
		e.preventDefault();
		if (vnex_media_upload) {
			vnex_media_upload.open();
			return;
		}
		vnex_media_upload = wp.media.frames.file_frame = wp.media({
			title: 'Choose Image',
			button: {
				text: 'Choose Image'
			},
			multiple: false
		});
		vnex_media_upload.on( 'select', function() {
			attachment = vnex_media_upload.state().get( 'selection' ).first().toJSON();
			$( '#vnex_media_image' ).val(attachment.url);
		});
		vnex_media_upload.open();
	});
	var vnex_media_upload_bg;
	$( '#vnex_media_button_bg' ).click(function(e) {
		e.preventDefault();
		if (vnex_media_upload_bg) {
			vnex_media_upload_bg.open();
			return;
		}
		vnex_media_upload_bg = wp.media.frames.file_frame = wp.media({
			title: 'Choose Image',
			button: {
				text: 'Choose Image'
			},
			multiple: false
		});
		vnex_media_upload_bg.on( 'select', function() {
			attachment = vnex_media_upload_bg.state().get( 'selection' ).first().toJSON();
			$( '#vnex_media_image_bg' ).val(attachment.url);
		});
		vnex_media_upload_bg.open();
	});
});