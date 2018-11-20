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
});