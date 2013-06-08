<?php
	include('justincarr/class.tribute.php');
	function mypath(){
		bloginfo('template_directory');
	}
?>
<!DOCTYPE html>
<html>
<head>

	<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
	<title>Justin Carr - In Memoriam</title>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,300,600' rel='stylesheet' type='text/css'>
	<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/justincarr/img/candle.png">
	<link href="<?php bloginfo('template_directory'); ?>/justincarr/css/style.css" rel="stylesheet" >
	<link href="<?php bloginfo('template_directory'); ?>/justincarr/css/reveal.css" rel="stylesheet" >

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.0/jquery.min.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.easing.1.3.js"></script>	
	<script src="<?php echo get_template_directory_uri(); ?>/justincarr/js/jquery.leanModal.min.js"></script>	
	<script src="<?php echo get_template_directory_uri(); ?>/justincarr/js/jquery.reveal.js"></script>	
	<script src="<?php echo get_template_directory_uri(); ?>/justincarr/js/jquery.form.js"></script>	
	<script src="<?php echo get_template_directory_uri(); ?>/justincarr/js/placeholders.min.js"></script>	
	
</head>
<body>

<div id="bar">

</div>
<div id="toppart">
	<div class="inner">
		<div class="left">
			<img src="<?php bloginfo('template_directory'); ?>/justincarr/img/justin.jpg" />
		</div>
		<div class="right">
			<h3>Remembering Justin.</h3>
			<p>
				Share your memories and photos of Justin Carr '14 who died on Feb. 22, 2013.  The Chronicle will run an obituary celebrating Carr's life and time at Harvard-Westlake in its March issue.
			</p>
			<a class="readmore" href="http://www.hwchronicle.com/news/all-school-assembly-honors-carrs-memory/">Read more: "All-school assembly honors Carr's memory"</a>
		</div>
	
	</div>
</div>
<header>
	<div class="inner">
		<div class="left">
			Justin Carr
		</div>
		<img src="<?php bloginfo('template_directory'); ?>/justincarr/img/heart@2x.png" />
			<a href="#myoverlay" id="sharebutton" class="sharebutton">Share a memory</a>
		<div class="right clearfix">
			1996 - 2013
		</div>
	</div>
</header>
<div id="header-filler"></div>
<div id="content">
	<div id="stream">
		<?php
			$tribute = new Tribute();
			$tribute->echoposts();
		?>
		<footer>
			
		</footer>
	</div>
</div>

<div id="myoverlay">
	<div class="upper">Share a memory of Justin</div>
	<div class="lower">
		<input type="text" id="namefield" placeholder="Name" />
		<input type="text" id="emailfield" placeholder="Email" />
		<textarea placeholder="Share your memory..." id="messagefield"></textarea>
		<div id="uploadimagesection">
			<h3>Add an image</h3>
			<form id="imageform" method="post" enctype="multipart/form-data" action='<?php mypath(); ?>/justincarr/requestuploadimage.php'>
				<input type="file" name="photoimg" id="photoimg" />
				<img src="<?php mypath(); ?>/justincarr/img/loading.gif" id="loadingupload" />
				<img src="<?php mypath(); ?>/justincarr/img/check.png" id="checkupload" />
			</form>
		</div>
		<!-- <input type="checkbox" id="anonfield" /><p id="anonnote">Do not show my name</p> -->
		<p class="notice">Email will not be displayed publicly with your post</p>
		<input type="hidden" id="imagefield" />
		<a href="javascript:void(0)" class="addimage">Add an image</a>
		<a href="#" id="done" class="sharebutton" data-reveal-id="previewmodal">Preview and Submit</a>
	</div>
</div>
<div id="previewmodal">
		<div class="post">
			<div class="message clearfix">
				<div class="byline"></div>
			</div>
		</div>
		<a class="sharebutton" id="submit">Submit (afterwards, cannot be edited/deleted)</a>
</div>

<script>

$(function(){
	Placeholders.init();
	if($.browser.msie){
		$('.addimage').hide();
	}
});



var onTopPart = true;

$(window).scroll(function(){
	var scrollTop = $(window).scrollTop();
	if (scrollTop > 312){
		
		if(onTopPart){
			switchToButton(false);			
		}
	
		$('header').css('position', 'fixed');
		$('#header-filler').css('display', 'block');

		onTopPart = false;
	}else{
	
		if(!onTopPart){
			switchToButton(true);
		}
		$('header').css('position', 'relative');
		$('#header-filler').css('display', 'none');
		
		onTopPart = true;
	}
});


function switchToButton(toButton){
	if(toButton){
		$('header .inner').stop().animate({
			width : '720px'
		}, 600);
		$('header img').stop().animate({
			marginLeft : '10px'
		}, {
			duration : 600,
			queue : false
		}).fadeTo(400,0);
		$('header .sharebutton').stop().animate({
			marginLeft : '-32px'
		}, {
			duration : 600,
			queue : false
		}).fadeTo(1000, 1);
	}else{
		$('header .inner').stop().animate({
			width : '600px'
		}, 600);
		$('header img').stop().animate({
			marginLeft : '0px'
		}, {
			duration : 600,
			queue : false
		});//.fadeTo(1000, .7);
		$('header .sharebutton').stop().animate({
			marginLeft : '-82px'
		}, {
			duration : 600,
			queue : false
		}).fadeTo(400, 0);
	}
}

$("a#sharebutton").leanModal();

$("a#done").click(function(e){
	var name = $('#namefield').val();
	var email = $('#emailfield').val();
	var message = $('#messagefield').val();
	var anon = 0;
	var image = $('#imagefield').val();
	
	if(!name || !email || !message){
		alert("Please fill out all the fields.");
		return false;	
	}else if(!isEmail(email)){
		alert("Please use a real email address.");
		return false;
	}else if(isUploading){
		alert("Still uploading the image, please wait a second or two.");
		return false;
	}

	var modal = $("#previewmodal")
	modal.find('.message').html("");
	if(image){
		image = $('<img/>').attr('src', '<?php mypath(); ?>/justincarr/upload/'+image).addClass('imageattachment');
		modal.find('.message').prepend(image);
	}
	message = message.replace(/\n\r?/g, '<br />');
	modal.find('.message').append(message);
	if(!anon){
		var byline = $('<div>').addClass('byline').html("- "+name);
		modal.find('.message').append(byline);
	}
	
});

$("#submit").click(function(){
	var url = "<?php mypath(); ?>/justincarr/submitmessage.php";
	var name = $('#namefield').val();
	var email = $('#emailfield').val();
	var message = $('#messagefield').val();
	var anon = 0;
	var image = $('#imagefield').val();
	
	var data = {
		'name' : name,
		'email' : email,
		'message' : message,
		'anon' : anon,
		'image' : image
	};
	$.post(url, data, function(data){
		location.reload();
/* 		console.log(data); */
	});
	
});

function isEmail(email) {
  var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}

var imageisopen = false;
$('.addimage').click(function(){
	if(imageisopen){
		closeimagesection();
		$(this).html('Add an image');
	}else{
		openimagesection();
		$(this).html('No image');
	}
	imageisopen = !imageisopen;
});

function openimagesection(){
	$('#uploadimagesection').animate({
		height : '100px'
	});
	$("#myoverlay").animate({
		height : '600px',
		top : '50px'
	});
}
function closeimagesection(){
	$('#uploadimagesection').animate({
		height : '0px'
	});
	$("#myoverlay").animate({
		height : '500px',
		top : '100px'
	});
	$('#photoimg').replaceWith( $('#photoimg').val('').clone( true ) );
	$('#loadingupload').hide();
	$('#checkupload').hide();
	$('#imagefield').val('');
}


var isUploading = false;

$('#photoimg').live('change', function(){
	$('#imageform').ajaxForm({
			success: function(data){
				var string = data;
				$('#imagefield').val(data);
			},
			uploadProgress: function(e, position, total, percent){
				if(percent != 100){
					isUploading = true;
					$('#loadingupload').show();
					$('#checkupload').hide();
				}else{
					isUploading = false;
					$('#loadingupload').hide();
					$('#checkupload').show();
				}
			}
		}).submit();
});

</script>
</body>
</html>