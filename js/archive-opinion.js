/*
function OpinionDualPart(){

		var max = 0;
		var columns = $(".columns").css('min-height', '');
		var letters = $(".letters").css('min-height', '');
		
		var height1 = columns.height();
		var height2 = letters.height() + 100;
		
		var max = Math.max(height1, height2);
		
		columns.css('min-height', max+'px');
		letters.css('min-height', (max-100)+'px');
}
setInterval(OpinionDualPart, 1000);
*/

//I can't initialize fancybox for the slides that aren't first.  The content isn't in the DOM, so I have to hack the hell out of events.

$("body").delegate('.showcase-arrow-next, .showcase-arrow-previous', 'click', function(){
	initFancy();
});
function initFancy(){
	$('.poll-item').fancybox({
		'transitionIn'	: 'elastic',
		'transitionOut'	: 'fade',
		'easingIn'      : 'easeOutBack',
	});
}

$(function(){
	initFancy();
});

$('.poll h4').each(function(){
	$(this).hover(function(){
		$(this).siblings('.annoyingbar').stop().animate({
			height : '20px',
			marginBottom : '-10px'
		}, 200, 'easeOutExpo');
		
		$(this).siblings('.annoyingbar').find('a').css('display', 'block').stop().animate({opacity : '1'});
	}, function(){
		$(this).siblings('.annoyingbar').stop().animate({
			height : '10px',
			marginBottom : '0px'
		}, 200, 'easeOutExpo');
		
		$(this).siblings('.annoyingbar').find('a').css('display', 'none').stop().animate({opacity : '0'}, 200);
	});
});



	$("#showcase ").awShowcase(
	{
		content_width:			330,
		content_height:			415,
		fit_to_parent:			false,
		auto:					false,
		interval:				3000,
		continuous:				false,
		loading:				true,
		tooltip_width:			200,
		tooltip_icon_width:		32,
		tooltip_icon_height:	32,
		tooltip_offsetx:		18,
		tooltip_offsety:		0,
		arrows:					true,
		buttons:				false,
		btn_numbers:			false,
		keybord_keys:			true,
		mousetrace:				false, /* Trace x and y coordinates for the mouse */
		pauseonover:			true,
		stoponclick:			false,
		transition:				'vslide', /* hslide/vslide/fade */
		transition_delay:		0,
		transition_speed:		500,
		show_caption:			'onload', /* onload/onhover/show */
		thumbnails:				false,
		thumbnails_position:	'outside-last', /* outside-last/outside-first/inside-last/inside-first */
		thumbnails_direction:	'vertical', /* vertical/horizontal */
		thumbnails_slidex:		1, /* 0 = auto / 1 = slide one thumbnail / 2 = slide two thumbnails / etc. */
		dynamic_height:			false, /* For dynamic height to work in webkit you need to set the width and height of images in the source. Usually works to only set the dimension of the first slide in the showcase. */
		speed_change:			true, /* Set to true to prevent users from swithing more then one slide at once. */
		viewline:				false, /* If set to true content_width, thumbnails, transition and dynamic_height will be disabled. As for dynamic height you need to set the width and height of images in the source. */
		custom_function:		null /* Define a custom function that runs on content change */
	});