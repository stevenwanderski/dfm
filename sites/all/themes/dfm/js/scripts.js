(function ($) {

	$(function(){

		$('#pics a').fancybox();

		$('#videos a').fancybox({
			autoDimensions: false,
			width: 480,
			height: 390
		});

		$('#videos ul').bxSlider({
			infiniteLoop: false,
			hideControlOnEnd: true,
			displaySlideQty: 5,
			moveSlideQty: 5,
			nextText: 'next &rarr;',
			prevText: '&larr; prev'
		});

		$('#pics ul').bxSlider({
			infiniteLoop: false,
			hideControlOnEnd: true,
			displaySlideQty: 5,
			moveSlideQty: 5,
			nextText: 'next &rarr;',
			prevText: '&larr; prev'
		});

		$('.webform-client-form').validate();

	});

})(jQuery);