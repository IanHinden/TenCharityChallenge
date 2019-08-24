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
			
			markers.push(marker = new google.maps.Marker({
					map: map,
					title: p.name,
					position: p.geometry.location
			}));
			if (places.length > 1) {
			google.maps.event.addListener(marker, 'click', function(e) {
				console.log(markers);
				console.log(this.getTitle());
				var latField = document.getElementById('lat');
				latField.value = this.getPosition().lat();
				var longField = document.getElementById('long');
				longField.value = this.getPosition().lng();
				console.log(this.getPosition().lat());
				console.log(this.getPosition().lng());
				})
			} else {
				var latField = document.getElementById('lat');
				latField.value = markers[0].getPosition().lat();
				var longField = document.getElementById('long');
				longField.value = markers[0].getPosition().lng();
			}

			if (p.geometry.viewport)
				bounds.union(p.geometry.viewport);
			else
				bounds.extend(p.geometry.location);
		});
		
		map.fitBounds(bounds);
	});	
}
	


function handleLocationError (content, position) {
	infoWindow.setPosition(position);
	infoWindow.setContent(content);
	infoWindow.open(map);
}

//Eventsearch Map
var customLabel = {
        restaurant: {
          label: 'R'
        },
        bar: {
          label: 'B'
        }
      };

        function initMap() {
        var map = new google.maps.Map(document.getElementById('searchmap'), {
          center: new google.maps.LatLng(-33.863276, 151.207977),
          zoom: 12
        });
        var infoWindow = new google.maps.InfoWindow;

          // Change this depending on the name of your PHP or XML file
          downloadUrl('https://tencharitychallenge.com/eventxml.php', function(data) {
            var xml = data.responseXML;
            var markers = xml.documentElement.getElementsByTagName('marker');
            Array.prototype.forEach.call(markers, function(markerElem) {
              var id = markerElem.getAttribute('id');
              var name = markerElem.getAttribute('name');
              var address = markerElem.getAttribute('address');
              var type = markerElem.getAttribute('type');
              var point = new google.maps.LatLng(
                  parseFloat(markerElem.getAttribute('lat')),
                  parseFloat(markerElem.getAttribute('lng')));

              var infowincontent = document.createElement('div');
              var strong = document.createElement('strong');
              strong.textContent = name
              infowincontent.appendChild(strong);
              infowincontent.appendChild(document.createElement('br'));

              var text = document.createElement('text');
              text.textContent = address
              infowincontent.appendChild(text);
              var icon = customLabel[type] || {};
              var marker = new google.maps.Marker({
                map: map,
                position: point,
                label: icon.label
              });
              marker.addListener('click', function() {
                infoWindow.setContent(infowincontent);
                infoWindow.open(map, marker);
              });
            });
          });
        }



      function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
          if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
          }
        };

        request.open('GET', url, true);
        request.send(null);
      }

      function doNothing() {}

function initialize() {
   try {
	createMap();
	}
	catch(error){
	console.error(error);
	}
   initMap();
}
