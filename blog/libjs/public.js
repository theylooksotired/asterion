$(document).ready(function(){
	$('.banners').banner();
	fixFooter();
});

$(window).load(function() {
	fixFooter();
});

$(window).resize(function() {
	fixFooter();
});

$(window).scroll(function() {
});

//Fix footer position
function fixFooter() {
	$('.content').css('min-height', $(window).height() - $('.contentTop').outerHeight() - $('.footer').outerHeight());
}

(function($){
	$.fn.banner = function() {
		var self = this;
		var items = self.find('.banner');
		var bannerActive = 0;
		var autoAnimation = true;
		if (items.length > 1) {
			self.append(`<div class="controls">
							<div class="control controlLeft"/>
							<div class="control controlRight"/>
						</div>`);
			items.wrapAll('<div class="bannersIns"/>');
			items.css({'float': 'left', 'width': self.outerWidth()});
			self.find('.bannersIns').css({'width': items.outerWidth() * items.length});
			var controlLeft = self.find('.controlLeft').first();
			var controlRight = self.find('.controlRight').first();
			var moveBanner = function() {
				var newMargin = -1 * bannerActive * items.first().outerWidth();
				self.find('.bannersIns').stop().animate({'margin-left':newMargin});
			}
			controlLeft.click(function(){
				autoAnimation = false;
				bannerActive = (bannerActive-1 < 0) ? items.length-1 : bannerActive-1;
				moveBanner();
			});
			controlRight.click(function(){
				autoAnimation = false;
				bannerActive = (bannerActive+1 > items.length-1) ? 0 : bannerActive+1;
				moveBanner();
			});
			window.setInterval(function(){
				if (autoAnimation) {
					bannerActive = (bannerActive+1 > items.length-1) ? 0 : bannerActive+1;
					moveBanner();
				}
			}, 5000);
		}
	}; 
})(jQuery);