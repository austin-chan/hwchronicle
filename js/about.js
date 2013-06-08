$(document).ready(function(){	//executed after the page has loaded

	checkURL();	//check if the URL has a reference to a page and load it

	if(window.location.hash == '') window.location.hash = 'about';

	$('#SingleTop .start a').click(function (e){	//traverse through all our navigation links..

			checkURL(this.hash);	//.. and assign them a new onclick event, using their own hash as a parameter (#page1 for example)

	});

	setInterval("checkURL()",250);	//check for a change in the URL every 250 ms to detect if the history buttons have been used

});

var lasturl="";	//here we store the current URL hash

function hideOverlay(){
	$('#loading').stop().fadeOut();
	$('#about-overlay').stop().fadeOut();
}
function showOverlay(){
	$('#loading').stop().fadeIn();
	$('#about-overlay').stop().fadeIn();
}

setTimeout('hideOverlay()', 300);

function checkURL(hash)
{
	if(!hash) hash=window.location.hash;	//if no parameter is provided, use the hash value from the current address

	if(hash != lasturl)	// if the hash value has changed
	{
		lasturl=hash;	//update the current hash
		loadPage(hash);	// and load the new page
	}
}

function loadPage(url)	//the function that loads pages via AJAX
{

	url=url.replace('#','');	//strip the #page part of the hash and leave only the page number

	showOverlay();

	var thisURL = 'http://' + window.location.hostname + window.location.pathname;
	
	if(window.location.hostname == 'localhost'){
		thisURL = 'http://' + window.location.hostname + ':8888' + window.location.pathname;
	}
	thisURL = thisURL.substring(0, thisURL.length - 6);
	$("#sandbox .section").animate({'margin-top': '100px', 'opacity' : 0}, 1000);
	
	$(".loader").removeClass('current');
	$(".loader."+url).addClass('current');

	$.ajax({	//create an ajax request to load_page.php
		type: "POST",
		url: (thisURL+url+'-section/'),
		data: '',	//with the page number as a parameter
		dataType: "html",	//expect html to be returned
		success: function(msg){

			if(parseInt(msg)!=0)	//if no errors
			{
				$('#sandbox').html(msg);	//load the returned html into pageContet
				$("#sandbox .section").animate({'margin-top': '10px', 'opacity' : 1}, 800, 'easeOutBack');
				hideOverlay();
			}
		}

	});

}