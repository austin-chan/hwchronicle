(function() {
    var id = $("#big-header-search input").eq(0).get(0);
    if (id) {
      var name = id;
      var unclicked = function() {
          if (name.value == '') {
              name.style.background = '#FFFFFF url(http://localhost:8888/Totes/LASTONE/wp-content/themes/Reset/images/search2.png) left no-repeat';
          }
       };
       var clicked = function() {
          name.style.background = '#ffffff';
       };
    name.onfocus = clicked;
    name.onblur = unclicked;
    unclicked();
    }
  })();
 
$('.fancybox').fancybox();
 

// Flippy animation 


$("#big-header-switcher .switcher.hidden").hide(); //init



// Dev-tool --------------------------------------

/*
$("#dev-tool").click(function(){
	if($(this).find('p').eq(0).html()[0]=="N"){
		$(this).find('p').eq(0).html("Click here to turn on sandbox mode");
		document.body.contentEditable = false;	
	}else{
		$(this).find('p').eq(0).html("Now you can temporarily tryout text. Refresh when done!");
		document.body.contentEditable = true;	
	}
});
*/