(function($){
	function getID (el) {
		return el.attr('id').replace('menu-item-', '') * 1;
	}
	function getDepth (el) {
		return el.get(0).className.split('menu-item-depth-')[1].split(' ')[0];
	}
	$(document).ready(function(e) {
		var th = $(this).addClass('menu-active');
		th.find('.item-controls').append('<a class="item-clone-this" href="#">Clone</a>');
	});
	$(document).on('click', 'li.menu-item .item-clone-this', function(e) {
		e.preventDefault();
		var li = $(this).closest('li.menu-item'),
			depth = 'menu-item-depth-' + getDepth( li ),
			availables = $('#menu-to-edit li[id^=menu-item-]'),
			ids = [],
			nowId = getID( li ),
			newId, newEl, form_data;
		form_data = {
			action: 'add-menu-item',
			menu: $('#menu').val(),
			'menu-settings-column-nonce': $('#menu-settings-column-nonce').val(),
			'menu-item': {
				'-1': {
					'menu-item-db-id': 0,
					'menu-item-object-id': li.find('input.menu-item-data-object-id').val(),
					'menu-item-object': li.find('input.menu-item-data-object').val(),
					'menu-item-parent-id': li.find('input.menu-item-data-parent-id').val(),
					'menu-item-type': li.find('input.menu-item-data-type').val(),
					'menu-item-title': li.find('input.edit-menu-item-title').val(),
					'menu-item-url': li.find('input.edit-menu-item-url').val(),
					'menu-item-description': li.find('textarea.edit-menu-item-description').val(),
					'menu-item-attr-title': li.find('input.edit-menu-item-attr-title').val(),
					'menu-item-target': li.find('.field-link-target input[type=checkbox]').is(':checked') ? '_blank' : '',
					'menu-item-classes': li.find('input.edit-menu-item-classes').val(),
					'menu-item-xfn': li.find('input.edit-menu-item-xfn').val()
				}
			}
		};  
		$.post( ajaxurl, form_data, function(menuMarkup) {
			console.log( $(menuMarkup) );
			var newElement = $(menuMarkup);
			$('.hide-column-tog').not(':checked').each(function(){
				newElement.find('.field-' + $(this).val() ).addClass('hidden-field');
			});
			newElement.removeClass( 'menu-item-depth-0' );
			newElement.addClass( depth );
			newElement = newElement.wrap('<div>').parent().html();
			if( li.next().hasClass( depth ) || li.parent().children('li').last().get(0) === li.get(0) ) {
				li.after(newElement);
			} else if( getDepth( li.next() ) < getDepth( li ) ) {
				li.after(newElement);
			} else {
				if( getDepth( li ) != 0 ) {
					depth = 'menu-item-depth-' + ( getDepth( li ) - 1 );
				}
				li.nextUntil( '.' + depth ).last().after(newElement);
			}
		});
	});
    var vnex_rma = {
        init: function() {
            this.wp_menu_item = "#menu-to-edit .menu-item";
            this.wp_delete_btn = ".item-delete";
            this.wp_delete_class = "item-delete-this";
            this.wp_this_text = "Delete";
            this.customRemove();
        },
        customRemove:function(){
            var self = this;
            $(self.wp_menu_item).each(function(){
                var this_menu = $(this);
                var item_controls = this_menu.find('.item-controls').find('.item-type');
                $( "<a/>", {
                    "class": self.wp_delete_class,
                    text: self.wp_this_text,
                    click:function(){
                        this_menu.find('.menu-item-settings').find(self.wp_delete_btn).trigger('click');
                        return false;
                    }
                }).insertBefore(item_controls);
            });
        }
    }
    vnex_rma.init();
})(jQuery);