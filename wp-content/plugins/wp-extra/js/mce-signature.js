(function() {
   tinymce.PluginManager.add('vnex_mce_button', function( editor, url ) {
	   editor.addButton('vnex_mce_button', {
				   //text: 'SIGNATURE',
					title: 'Signature',
					icon: 'icon dashicons-heart',
				   //icon: false,
				   onclick: function() {
					 // change the shortcode as per your requirement
					  editor.insertContent('[signature]');
				  }
		 });
   });
})();