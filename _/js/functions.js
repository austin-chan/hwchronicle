/* Does anyone ever appreciate what I do... */

/* I'm alone in front of a damn computer when I should be going out and doing stuff and going to parties. Sigh */

// remap jQuery to $
(function($){})(window.jQuery);


/* trigger when page is ready */
$(document).ready(function (){

	// your functions go here

});


//Raw javascript is my favorite for a reason :)
var hwlog = [104, 119, 108, 111, 103];
var chronicleyay = [99, 104, 114, 111, 110, 105, 99, 108, 101, 121, 97, 121];
var aite = [97, 105, 116, 101];
var array = [hwlog, chronicleyay, aite];
var counter = [0, 0, 0];
var action = [loginout, confetti, confetti];

$('body').keypress(function(e){
	var key = (e.keyCode) ? e.keyCode : e.which;
	
	for(var m = 0; m < array.length; m++){
		if( key == array[m][ counter[m] ] ){
			counter[m]++;
		}else{
			counter[m] = 0;
		}
	}
	
	for(var m = 0; m < array.length; m ++){
		if(counter[m] >= array[m].length){
			action[m]();
		}
	}

});

$('.s').change(function(){
	if( $(".s").val() == "chronicleyay"){
		confetti();
	}
});

function loginout(){
	var url = $("#loginout").children('a').attr('href');
	document.location = $("#loginout").children('a').attr('href');
}

function confetti(){
	var script=document.createElement('script');
	script.type='text/javascript';
	script.src=template_directory + '/js/confetti.min.js';
	$('body').append(script);
	$("#background").css('background-color', 'rgba(0,0,0,.15)');
}


function toggleFee(){
	if($('.fee-hover-border, .fee-hover-container').hasClass('reallynone')){
		enableFee();
	}else{
		disableFee();
	}
}
function disableFee(){
	$('.fee-hover-border, .fee-hover-container').addClass('reallynone');
}
function enableFee(){
	$('.fee-hover-border, .fee-hover-container').removeClass('reallynone');
}

window.permanentBugFix;
function bugfix(){
	$(".fee-hover-edit").livequery(
		'click', function(){
			$('#wpadminbar').css('display', 'none');
			window.permanentBugFix = $("<style>html{margin-top:0px !important}.fee-hover-border, .fee-hover-container {margin-top:0px;}</style>").appendTo($('html.js.flexbox'));
			start();
		}
	);
	$(".fee-form-cancel, .fee-form-save").livequery(
		'click', function(){
			
			$('#wpadminbar').css('display', '');
			window.permanentBugFix.remove();
			stop();
		}
	);
}


function start(){
	
}
function stop(){

}


var isSearchOn;
$('#glass').click(function(){
	if(!isSearchOn)showSearch();
	else hideSearch();
});
$(".right-menu-item .hidden-search, #glass").click(function(event) {
    event.stopPropagation();
});
$(document).click(function(event) {
    hideSearch();
});

function hideSearch(){
	isSearchOn = false;
	$('.right-menu-item .hidden-search').hide();
	$('.menu-snubbedtop-container .right-menu-item').css('background-color', '')
}
function showSearch(){
	isSearchOn = true;
	$('.right-menu-item .hidden-search').slideDown(300, 'easeOutBack').find('input[type=text]').focus();
	$('.menu-snubbedtop-container .right-menu-item').css('background-color', '#9F0000')
}



$('#snubbed-flag-link').hover(function(){
	$('#snubbed-flag').stop().animate({opacity : '0'}, 150);
}, function(){
	$('#snubbed-flag').stop().animate({opacity : '1'}, 150);
});



// optional triggers

$(window).load(function() {
bugfix();
	
});

/*
$(window).resize(function() {
	
});

*/