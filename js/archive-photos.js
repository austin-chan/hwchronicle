	$("#photo-showcase").awShowcase(
	{
		content_width:			1000,
		content_height:			520,
		fit_to_parent:			false,
		auto:					true,
		interval:				4000,
		continuous:				true,
		loading:				true,
		tooltip_width:			200,
		tooltip_icon_width:		32,
		tooltip_icon_height:	32,
		tooltip_offsetx:		18,
		tooltip_offsety:		0,
		arrows:					false,
		buttons:				false,
		btn_numbers:			false,
		keybord_keys:			true,
		mousetrace:				false, /* Trace x and y coordinates for the mouse */
		pauseonover:			false,
		stoponclick:			false,
		transition:				'fade', /* hslide/vslide/fade */
		transition_delay:		00,
		transition_speed:		1500,
		show_caption:			'show', /* onload/onhover/show */
		thumbnails:				false,
		thumbnails_position:	'outside-last', /* outside-last/outside-first/inside-last/inside-first */
		thumbnails_direction:	'vertical', /* vertical/horizontal */
		thumbnails_slidex:		0, /* 0 = auto / 1 = slide one thumbnail / 2 = slide two thumbnails / etc. */
		dynamic_height:			false, /* For dynamic height to work in webkit you need to set the width and height of images in the source. Usually works to only set the dimension of the first slide in the showcase. */
		speed_change:			false, /* Set to true to prevent users from swithing more then one slide at once. */
		viewline:				false /* If set to true content_width, thumbnails, transition and dynamic_height will be disabled. As for dynamic height you need to set the width and height of images in the source. */
	});
	
	$(".image2").hover(function(){
		//$(this).children('a').eq(0).css({top : '-10px', opacity : '0', zIndex : '51'}).stop().animate({ top: '0px', opacity: '1'}, 800);
		$(this).children('a').eq(0).css({left : '-10px', opacity : '0', zIndex : '51'}).stop().animate({ left: '0px', opacity: '1'}, 400);
		//$(this).children('span').css({'opacity': '0', 'right': '-100px'}).animate({opacity: 1, right : -14}, 500, 'easeOutExpo');

	}, function(){
		//$(this).children('a').eq(0).stop().css({'top': '0px', 'left': '0px', 'opacity' : 0, zIndex : '50'});
		$(this).children('a').eq(0).stop().css({'top': '0px', 'opacity' : 0, zIndex : '50'});
		//$(this).children('span').stop().css({'opacity': '0', 'right': '-50px'});
	});