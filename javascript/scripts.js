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
	
	
});

var map, infoWindow;

function createMap() {
	var options = {
		center: { lat: 43.654, lng: -79.383 },
		zoom: 10
	};
	map = new google.maps.Map(document.getElementById('map'), options);
	
	infoWindow = new google.maps.InfoWindow;
	
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function (p) {
			var position = {
				lat: p.coords.latitude,
				lng: p.coords.longitude
			};
			infoWindow.setPosition(position);
			infoWindow.setContent('Your current location');
			infoWindow.open(map);
		}, function() {
			handleLocationError('Geolocation service failed', map.center());
		})
	} else {
		handleLocationError('No geolocation available', map.center());
	}
	
	var input = document.getElementById("search");
	var searchBox = new google.maps.places.SearchBox(input);
	
	map.addListener('bounds_changed', function() {
		searchBox.setBounds(map.getBounds());
	});
	
	var markers = [];
	
	searchBox.addListener('places_changed', function() {
		var places = searchBox.getPlaces();
		
		if(places.length === 0)
			return;
		
		markers.forEach(function (m) {m.setMap(null); });
		markers = [];
	
		var bounds = new google.maps.LatLngBounds();
	
		places.forEach(function (p){
			if (!p.geometry)
				return;
			
			markers.push(new google.maps.Marker({
					map: map,
					title: p.name,
					position: p.geometry.location
			}));
			
			if (p.geometry.viewport)
				bounds.union(p.geometry.location);
			else
				bounds.extend(p.geometry.location);
		});
		
		map.fitBounds(bounds);
	});	
}
	
	
}

function handleLocationError (content, position) {
	infoWindow.setPosition(position);
	infoWindow.setContent(content);
	infoWindow.open(map);
}
