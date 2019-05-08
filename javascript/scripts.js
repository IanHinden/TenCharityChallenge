$(document).ready(function(){

    $('.menu-icon').click(function() {
      $('.navlink').toggleClass('navlink-out');
	  $('.nav-login').toggleClass('nav-login-out');
	  $('.menu-line-1').toggleClass('menu-line-1-open');
	  $('.menu-line-2').toggleClass('menu-line-2-open');
	  $('.menu-line-3').toggleClass('menu-line-3-open');
    });
	
	$('#show-tos').click(function() {
		$('.opaque').addClass('opaque-out');
		$('.confirm').addClass('confirm-out');
	});
	
	$('.opaque').click(function(){
		$('.opaque').removeClass('opaque-out');
		$('.confirm').removeClass('confirm-out');
	});
	
	$('.tos-close').click(function(){
		$('.opaque').removeClass('opaque-out');
		$('.confirm').removeClass('confirm-out');
	});
	
	$('.addfriend').submit(function() {
		console.log("It works!");
		var req = new XMLHttpRequest();
		req.open("post", this.action);
		req.send(new FormData(this));
		var btn = document.getElementById(this.childNodes[2].nextSibling.id);
		btn.disabled = true;
		return false;
	});
	
	// Google Map Stuff
	//function createMap() {
	//	var options = {
	//		center: { lat: 43.654, lng: -79.383 },
	//		zoom: 10
	//	};
	//map = new google.maps.Map(document.getElementById('map'), options);
	//}
	
});

function createMap() {
	var options = {
		center: { lat: 43.654, lng: -79.383 },
		zoom: 10
	};
	map = new google.maps.Map(document.getElementById('map'), options);
	}
