(function($) {
	if(!window.Vnexwg) window.Vnexwg = {};
	Vnexwg.CloneWidgets = {
		init: function() {
			$('#widgets-right').on('click', 'a.clone-widget', Vnexwg.CloneWidgets.Clone);
			Vnexwg.CloneWidgets.Bind();
		},
		Bind: function() {
			$('#widgets-right').off('DOMSubtreeModified', Vnexwg.CloneWidgets.Bind);
			$('#widgets-right .widget:not(.vnex-clone-widgets)').each(function() {
				var $widget = $(this);
				$widget.addClass('vnex-clone-widgets')
					.find('.widget-top')
					.prepend('<div class="widget-title-action clone-widget-action"><a href="javascript:void(0);" class="clone-widget widget-action" title="Clone"></a></div>');
				$widget.addClass('vnex-clone-widgets');
			});
			$('#widgets-right').on('DOMSubtreeModified', Vnexwg.CloneWidgets.Bind);
		},
		Clone: function(ev) {
			var $original = $(this).parents('.widget');
			var $widget = $original.clone();
			var idbase = $widget.find('input[name="id_base"]').val();
			var number = $widget.find('input[name="widget_number"]').val();
			var mnumber = $widget.find('input[name="multi_number"]').val();
			var highest = 0;
			$('input.widget-id[value|="' + idbase + '"]').each(function() {
				var match = this.value.match(/-(\d+)$/);
				if(match && parseInt(match[1]) > highest)
					highest = parseInt(match[1]);
			});
			var newnum = highest + 1;	
			$widget.find('.widget-content').find('input,select,textarea').each(function() {
				if($(this).attr('name'))
					$(this).attr('name', $(this).attr('name').replace(number, newnum));
			});
			var highest = 0;
			$('.widget').each(function() {
				var match = this.id.match(/^widget-(\d+)/);

				if(match && parseInt(match[1]) > highest)
					highest = parseInt(match[1]);
			});
			var newid = highest + 1;
			var add = $('#widget-list .id_base[value="' + idbase + '"]').siblings('.add_new').val();	
			$widget[0].id = 'widget-' + newid + '_' + idbase + '-' + newnum;
			$widget.find('input.widget-id').val(idbase+'-'+newnum);
			$widget.find('input.widget_number').val(newnum);
			$widget.hide();
			$original.after($widget);
			$widget.fadeIn();
			$widget.find('.multi_number').val(newnum);
			wpWidgets.save($widget, 0, 0, 1);
			ev.stopPropagation();
			ev.preventDefault();
		}
	}
	$(Vnexwg.CloneWidgets.init);
})(jQuery);