(function($){
	$.fn.modal = function(options){
		var selector = $(this).selector;
		
		var modal = {
			init:function(){
				this.fixcss();
			},
			fixcss:function(){
				var top = ($(window).height() / 2) - ($(selector).height() /2);
				var left = ($(window).width() / 2) - (options.width /2);

				$(selector).css({
					position:"fixed",
					top:top/3,
					left:left,
					width:options.width
				});
			}
		};

		modal.init();

		$(window).resize(function(){
			modal.fixcss();
		});
	}
})(jQuery);