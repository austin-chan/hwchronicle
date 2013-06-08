var m = false;
var x = $('#ChronTop .card');
var y = $('.backface');
var isIE = (function(){

    var undef,
        v = 3,
        div = document.createElement('div'),
        all = div.getElementsByTagName('i');

    while (
        div.innerHTML = '<!--[if gt IE ' + (++v) + ']><i></i><![endif]-->',
        all[0]
    );

    return v > 4 ? v : undef;

}());

if(isIE && isIE < 10){
/* 	y.remove();	 */
	$("#ChronTop .backface").fadeOut(0);
}



// SWITCHER FOR THE FRONT FLIPPY THING
function flipAround(){
	if( isIE){
		//$("#ChronTop").flippy({content : y, direction : 'LEFT', color_target : 'gray'});
		$("#ChronTop .frontface").fadeOut(1200);
		$("#ChronTop .backface").fadeIn(1200);
	}else{
		$("#ChronTop .card").css('rotateY', '180deg');
	}
}
function flipBack(){
	if(isIE){
		//$("#ChronTop").flippy({content : x, direction : 'RIGHT', color_target : 'white'});
		$("#ChronTop .frontface").fadeIn(1200);
		$("#ChronTop .backface").fadeOut(1200);
	}else{
		$("#ChronTop .card").css('rotateY', '0deg');
	}
}
$("#big-header-switcher").click(function(){
	if(m){
		flipBack();
	}else{
		flipAround();
	}
	if(window.centerIsVideo){
		$("#video .lightview").css('visibility', 'hidden');
	}
	$("#ChronTopRight .fb-like-box").css('display', 'none');
	$('.launch-box').css('visibility', 'hidden');
	var showen = $("#big-header-switcher .switcher.showen");
	var hidden = $("#big-header-switcher .switcher.hidden");
	showen.stop().show().removeClass('showen').addClass('hidden');
	hidden.stop().hide().removeClass('hidden').addClass('showen');
	showen.fadeTo(500, 0, function(){
		showen.hide();
		hidden.fadeTo(500, 1, function(){
			hidden.show();
			if(!m){
				if(window.centerIsVideo){
					$("#video .lightview").css('visibility', 'visible');
				}
				$("#ChronTopRight .fb-like-box").css('display', 'block');
				$('.launch-box').css('visibility', 'visible');
			}
		});
	});
	
	m = !m;
});



//  YOU KNOW YOU KNOW I'LL NEVER ASK YOU TO CHANGE
$('#ChronBottomFeatures .annoyingbar.moveable, #ChronBottomOpinion .annoyingbar.moveable').each(function(){
	$(this).hover(function(){
		$(this).stop().animate({
			height : '20px',
			marginBottom : '-10px'
		}, 200, 'easeOutExpo');
		
		$(this).find('a').css('display', 'block').stop().animate({opacity : '1'});
	}, function(){
		$(this).stop().animate({
			height : '10px',
			marginBottom : '0px'
		}, 200, 'easeOutExpo');
		
		$(this).find('a').css('display', 'none').stop().animate({opacity : '0'}, 200);
	});
});
$('#ChronBottomFeatures h4, #ChronBottomOpinion h4').each(function(){
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
//MULTIMEDIA - [ VIDEO ] + [ PHOTO ]
$('#ChronBottomMultimedia').hover(function(){
	var h4 = $(this).find('h4');
	h4.find('span.first').animate({opacity:0},200);
	h4.find('span.second').animate({opacity:1}, 200);
},function(){
	var h4 = $(this).find('h4');
	h4.find('span.first').stop().animate({opacity:1}, 200);
	h4.find('span.second').stop().animate({opacity:0}, 200);
});




// SUPER BUG FIX - JAVASCRIPT RESIZE BOXES YO
function ChronTop(){
	var frontface = $("#ChronTop .frontface").outerHeight();
	$("#ChronTop").height(Math.max(460, frontface));
}
function ChronMiddlePart(){
	var news = $("#ChronBottomNews").css('min-height', '');
	var sports = $("#ChronBottomSports").css('min-height', '');
	var opinion = $("#ChronBottomOpinion").css('min-height', '');
	var height1 = news.height();
	var height2 = sports.height();
	var height3 = opinion.height() + 220;
	
	var max = Math.max(Math.max(height1, height2), height3);
	max = Math.max(max, 530);
	
	news.css('min-height', max+'px');
	sports.css('min-height', max+'px');
	opinion.css('min-height', (max - 220)+'px');
}
function ChronMiddleSecondPart(){
	var features = $("#ChronBottomFeatures").css('min-height', '');
	var extra = $("#ChronBottomExtra").css('min-height', '');
	var height1 = features.height();
	var height2 = extra.height();
	
	var max = Math.max(height1, height2);
	max = Math.max(max, 210);
	
	features.css('min-height', max+'px');
	extra.css('min-height', max+'px');
}
function ChronMiddleThirdPart(){
	var ae = $("#ChronBottomAE").css('min-height', '');
	var morenews = $("#ChronBottomMoreNews").css('min-height', '');
	var moresports = $("#ChronBottomMoreSports").css('min-height', '');
	var height1 = ae.height();
	var height2 = morenews.height();
	var height3 = moresports.height();
	
	var max = Math.max(Math.max(height1, height2), height3);
	max = Math.max(max, 250);
	
	ae.css('min-height', max+'px');
	morenews.css('min-height', max+'px');
	moresports.css('min-height', max+'px');
}
setInterval(ChronMiddlePart, 1000);
setInterval(ChronTop, 1000);
setInterval(ChronMiddleSecondPart, 1000);
setInterval(ChronMiddleThirdPart, 1000);
// END SUPER BUG FIX - THANK YOU RAID FOR YOUR AMAZING FORMULA

$("#showcase").awShowcase(
	{
		content_width:			470,
		content_height:			125,
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
