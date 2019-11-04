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
		var req = new XMLHttpRequest();
		req.open("post", this.action);
		req.send(new FormData(this));
		var btn = document.getElementById(this.childNodes[2].nextSibling.id);
		btn.disabled = true;
		return false;
	});

	//Edit profile scripts
	document.getElementById("editaboutme").addEventListener("click", enableaboutme);
	
	function enableaboutme() {
		var aboutmefield = document.getElementById("aboutme");
		aboutmefield.removeAttribute('readonly');
		var birthdayfield = document.getElementById("birthday");
		birthdayfield.removeAttribute('readonly');
		var favoritecausefield = document.getElementById("favoritecause");
		favoritecausefield.removeAttribute('readonly');
	}

	$('.aboutme').submit(function() {
		var req = new XMLHttpRequest();
                req.open("post", this.action);
                req.send(new FormData(this));
		var aboutmefield = document.getElementById("aboutme");
		aboutmefield.readOnly = true;
		var birthdayfield = document.getElementById("birthday");
		birthdayfield.readOnly = true;
		var favoritecausefield = document.getElementById("favoritecause");
		favoritecausefield.readOnly = true;
                return false;
        });

	document.getElementById("profileimage").addEventListener("click", profileupload);

	function profileupload() {
  		var uploadButton = document.getElementById("fileToUpload");
		uploadButton.click();
	}

	$("#friendrequestsicon").click(function(){
		$("#friendrequestpopup").toggle();
	});

	$('.confirmfriend').submit(function() {
		var req = new XMLHttpRequest();
		req.open("post", this.action);
		req.send(new FormData(this));
		//var btn = document.getElementById(this.childNodes[2].nextSibling.id);
		//btn.disabled = true;
		return false;
	});

	$('.rejectfriend').submit(function() {
                console.log("It works!");
                var req = new XMLHttpRequest();
                req.open("post", this.action);
		req.send(new FormData(this));
                //var btn = document.getElementById(this.childNodes[2].nextSibling.id);
                //btn.disabled = true;
                return false;
        });

	$('.confirmevent').submit(function() {
		console.log("It works!");
		var req = new XMLHttpRequest();
		req.open("post", this.action);
		req.send(new FormData(this));
		//var btn = document.getElementById(this.childNodes[2].nextSibling.id);
		//btn.disabled = true;
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

	var e = document.getElementById('eventdistance').value;
	var eventTypeFilter = document.getElementById('cause').value;
	var fD = document.getElementById('fromDate').value;
	var fromDate = new Date(fD);
	console.log(fromDate);
	var tD = document.getElementById('toDate').value;
	var toDate = new Date(tD);
	console.log(toDate);

        var map = new google.maps.Map(document.getElementById('searchmap'), {
          center: new google.maps.LatLng(-33.863276, 151.207977),
          zoom: parseInt(e)
        });
        var infoWindow = new google.maps.InfoWindow;

        if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (p) {                                                                       var position = {                                                                                                              lat: p.coords.latitude,
                                lng: p.coords.longitude
                        };                                                                                                                    infoWindow.setPosition(position);
                        infoWindow.setContent('Your current location');                                                                       infoWindow.open(map);
                }, function() {
                        handleLocationError('Geolocation service failed', map.center());                                              })                                                                                                            } else {
                handleLocationError('No geolocation available', map.center());
        }



          // Change this depending on the name of your PHP or XML file
          downloadUrl('https://tencharitychallenge.com/eventxml.php', function(data) {
            var xml = data.responseXML;
            var markers = xml.documentElement.getElementsByTagName('event');
		console.log(markers);
            Array.prototype.forEach.call(markers, function(markerElem) {
              var id = markerElem.getAttribute('event_id');
	      var avenue = markerElem.getAttribute('event_avenue');
	      var cause = markerElem.getAttribute('cause');
              var eventDate = markerElem.getAttribute('event_date');
	      var eventDateObject = new Date(eventDate);
		console.log(eventDateObject);
              //var address = markerElem.getAttribute('address');
              //var type = markerElem.getAttribute('type');
              var point = new google.maps.LatLng(
                  parseFloat(markerElem.getAttribute('lat')),
                  parseFloat(markerElem.getAttribute('longit')));
              var infowincontent = document.createElement('div');
              var strong = document.createElement('strong');
              strong.textContent = id
              infowincontent.appendChild(strong);
              infowincontent.appendChild(document.createElement('br'));

              var text = document.createElement('text');
              text.textContent = avenue
              infowincontent.appendChild(text);
              //var icon = customLabel[type] || {};
              if((eventTypeFilter == 'All' || cause == eventTypeFilter) && ((fromDate < eventDateObject) && (eventDateObject < toDate))){
		var marker = new google.maps.Marker({
                	map: map,
                	position: point,
                	//label: icon.label
              	});

              marker.addListener('click', function() {
                infoWindow.setContent(infowincontent);
                infoWindow.open(map, marker);
              });
	      }
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

	function handleLocationError (content, position) {
		infoWindow.setPosition(position);
		infoWindow.setContent(content);
		infoWindow.open(map);
	}

      function doNothing() {}

function initialize() {
   try {
	createMap();
	}
	catch(error){
	//console.error(error);
	}
   initMap();
}
