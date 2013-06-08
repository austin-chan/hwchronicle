	$("#archive-showcase").awShowcase(
	{
		content_width:			750,
		content_height:			475,
		fit_to_parent:			false,
		auto:					true,
		interval:				10000,
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
		pauseonover:			true,
		stoponclick:			true,
		transition:				'vslide', /* hslide/vslide/fade */
		transition_delay:		00,
		transition_speed:		550,
		show_caption:			'show', /* onload/onhover/show */
		thumbnails:				true,
		thumbnails_position:	'outside-last', /* outside-last/outside-first/inside-last/inside-first */
		thumbnails_direction:	'vertical', /* vertical/horizontal */
		thumbnails_slidex:		0, /* 0 = auto / 1 = slide one thumbnail / 2 = slide two thumbnails / etc. */
		dynamic_height:			false, /* For dynamic height to work in webkit you need to set the width and height of images in the source. Usually works to only set the dimension of the first slide in the showcase. */
		speed_change:			false, /* Set to true to prevent users from swithing more then one slide at once. */
		viewline:				false /* If set to true content_width, thumbnails, transition and dynamic_height will be disabled. As for dynamic height you need to set the width and height of images in the source. */
	});
	
	$("#indepth #indepth-showcase").awShowcase(
	{
		content_width:			410,
		content_height:			102,
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
		buttons:				true,
		btn_numbers:			true,
		keybord_keys:			false,
		mousetrace:				false, /* Trace x and y coordinates for the mouse */
		pauseonover:			true,
		stoponclick:			false,
		transition:				'hslide', /* hslide/vslide/fade */
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
	
	function ArchiveTriPart(){
		$(".norway-tri").each(function(){
			var max = 0;
			$(this).find('.archive-tri').css('min-height', '').each(function(){
				max = Math.max(max, $(this).height());
			});
			
			$(this).find('.archive-tri').css('min-height', max+'px');
		});
	}
	setInterval(ArchiveTriPart, 1000);
	function ArchiveTriDual(){
		$(".norway-dual").each(function(){
			var max = 0;
			$(this).find('.archive-dual').css('min-height', '').each(function(){
				max = Math.max(max, $(this).height());
			});
			
			$(this).find('.archive-dual').css('min-height', max+'px');
		});
	}
	setInterval(ArchiveTriDual, 1000);
	function ArchiveTriQuad(){
		$(".norway-quad").each(function(){
			var max = 0;
			$(this).find('.archive-quad').css('min-height', '').each(function(){
				max = Math.max(max, $(this).height());
			});
			
			$(this).find('.archive-quad').css('min-height', max+'px');
		});
	}
	setInterval(ArchiveTriQuad, 1000);
