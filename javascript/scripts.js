$(document).ready(function(){

	console.log("Page finished loading");

	$('.menu-icon').click(function() {
      		$('.navlink').toggleClass('navlink-out');
	  	$('.nav-login').toggleClass('nav-login-out');
	  	$('.menu-line-1').toggleClass('menu-line-1-open');
	  	$('.menu-line-2').toggleClass('menu-line-2-open');
	  	$('.menu-line-3').toggleClass('menu-line-3-open');
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

	//Form validation for sign up

	var ajax = new XMLHttpRequest();
	ajax.open("GET", "../allusernames.php", true);
	ajax.send();

	ajax.onreadystatechange = function() {

		var data;

    		if (this.readyState == 4 && this.status == 200) {
			data = JSON.parse(this.responseText);
    		}

		if(document.getElementById("username") != null) {
			document.getElementById("username").addEventListener("input", checkusernameinuse);
		}

		function checkusernameinuse(e) {
			for (var i = 0; i < data.length; i++) {
    				if (data[i].user_uid === e.target.value) {
        				let usernametaken = document.getElementById("usernamewarning");
                                        usernametaken.innerText = "This username is already in use. Please select another.";
    				}
			}
		}
	};
	
	if(document.getElementById("email") != null) {
		document.getElementById("email").addEventListener("blur", displayemailwarning);
	}

	function displayemailwarning(e) {
		var emailformat = document.getElementById("emailformat");
		if(!validateEmail(e.target.value)){
			emailformat.style.visibility = "visible";
		} else {
			emailformat.style.visibility = "hidden";
		}
	}

	function validateEmail(email) {
 		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  		return re.test(email);
	}

        if(document.getElementById("username") !=null){
		document.getElementById("username").addEventListener("input", invalidcharacterwarning);
	}

        function invalidcharacterwarning(e) {
                var emailformat = document.getElementById("usernamewarning");
                if(!validateUsernameSpecialChars(e.target.value)){
                        emailformat.innerText = "Please choose a username with no special characters.";
                } else {
                        emailformat.innerText = " ";
                }
        }

        function validateUsernameSpecialChars(username) {
                var re = /^[a-zA-Z0-9]*$/
		return re.test(username);
        }

	
	$('#show-tos').click(function() {
		if( !$("#firstname").val() ) {
          		$("#firstnamewarning").css({"visibility":"visible"});
    		} else {
			$('.opaque').addClass('opaque-out');
                	$('.confirm').addClass('confirm-out');
		}
        });

	//Edit profile scripts
	if (document.getElementById("editaboutme") != null) {
		document.getElementById("editaboutme").addEventListener("click", enableaboutme);
	}
	
	function enableaboutme() {
		var aboutmefield = document.getElementById("aboutme");
		aboutmefield.removeAttribute('readonly');
		var birthdayfield = document.getElementById("birthday");
		birthdayfield.removeAttribute('readonly');
		var favoritecausefield = document.getElementById("favoritecause");
		favoritecausefield.removeAttribute('readonly');
	}

	$('.aboutmeform').submit(function() {
		var req = new XMLHttpRequest();
		req.onload = function(){ alert(req.responseText); }
                req.open("POST", "../includes/aboutme.inc.php", true);
		var form = document.getElementById("aboutmeform");
		var formData = new FormData(form);
                req.send(formData);
		var aboutmefield = document.getElementById("aboutme");
		aboutmefield.readOnly = true;
		var birthdayfield = document.getElementById("birthday");
		birthdayfield.readOnly = true;
		var favoritecausefield = document.getElementById("favoritecause");
		favoritecausefield.readOnly = true;
		return false;
        });

	if(document.getElementById("profileimage") != null) {
		document.getElementById("profileimage").addEventListener("click", profileupload);
	}

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

	$('.cancelattendevent').submit(function() {
		var data = new FormData();
                var req = new XMLHttpRequest();
                req.open('post', '../includes/cancelattendevent.inc.php');
                req.send();
		return false;
        });


//Event page functions

//Slide show
	var slideIndex;
	//showSlides(slideIndex);

	function showSlides(n) {
		var i;
		var slides = document.getElementsByClassName("eventimage");

        	if (n > slides.length) {slideIndex = 1}
		if (n < 1) {slideIndex = slides.length}
        	for (i = 0; i < slides.length; i++) {
                	slides[i].style.display = "none";
                	console.log(slides[i]);
        	}

        	slides[slideIndex - 1].style.display = "block";

		document.getElementById("eventPopup").style.display = "block";
	}

	if(document.getElementById("prev") != null) {
                document.getElementById("prev").addEventListener("click", function(){
			plusSlides(-1);
        	});
	}

	if(document.getElementById("next") != null) {
                document.getElementById("next").addEventListener("click", function(){
			plusSlides(1);
		});
        }

	if(document.getElementById("popupClose") != null) {
                document.getElementById("popupClose").addEventListener("click", function(){
                        document.getElementById("eventPopup").style.display = "none";
		});

		document.getElementById("popupClose").addEventListener("mouseover", function(){
			document.getElementById("popupClose").style.background = "grey";
		});

                document.getElementById("popupClose").addEventListener("mouseout", function(){
			document.getElementById("popupClose").style.background = "none";
		});
	}

	function plusSlides(n) {
		showSlides(slideIndex += n);
        }

	$(".eventimagethumbcontainers").on('click',function(){
		var position = parseInt($(this).attr('id'));
		position = position + 1;
		console.log(position);
		slideIndex = position;
		showSlides(position);
	});

});

function dragOverHandler(e) {
	console.log('File(s) in drop zone'); 

	let zone = document.getElementById("drop_zone");
	zone.style.border = "2px dashed black";
  	// Prevent default behavior (Prevent file from being opened)
  	e.preventDefault();
}

function dropHandler(ev) {
  console.log('File(s) dropped');
  var filesToUpload = document.getElementById("fileToUpload");

  // Prevent default behavior (Prevent file from being opened)
  ev.preventDefault();
  ev.stopPropagation();

  console.log(ev);
  filesToUpload.files = ev.dataTransfer.files;
}



//Display proper button to interact with events
function properEventButton(permission){
	console.log("The proper event button was run");
	var signup = document.getElementById("signupeventbutton");
	var cancel = document.getElementById("canceleventbutton");
	var leave = document.getElementById("leaveeventbutton"); 

	if (permission == 0) {
		console.log("You can sign up for an account");
	} else if (permission == 1) {
		leave.style.display = "block";
		cancel.style.display = "block";
	} else if (permission == 2) {
		leave.style.display = "block";
	} else if (permission == 3) {
		signup.style.display = "block";
	}
}

//Friend Request Scripts
function properButton(id, status, currentUserRequested){
	var addDiv = document.getElementById("add" + id);
	var requestSent = document.getElementById("sent" + id);
	var acceptreject = document.getElementById("acceptreject" + id);
	var removeFriend = document.getElementById("remove" + id);
	
	if(status == -1){
		addDiv.style.display = "block";
		requestSent.style.display = "none";
		acceptreject.style.display = "none";
		removeFriend.style.display = "none";
	} else if (status == 0) {
		if (currentUserRequested == true) {
			addDiv.style.display = "none";
			requestSent.style.display = "block";
			acceptreject.style.display = "none";
			removeFriend.style.display = "none";
		} else {
			acceptreject.style.display = "block";
			addDiv.style.display = "none";
			requestSent.style.display = "none";
			removeFriend.style.display = "none";
		}
	} else if (status == 1) {
		removeFriend.style.display = "block";
		addDiv.style.display = "none";
		requestSent.style.display = "none";
		acceptreject.style.display = "none";
	} else if (status == 2 ) {
		if (currentUserRequested == true) {
			addDiv.style.display = "block";
			requestSent.style.display = "none";
			acceptreject.style.display = "none";
			removeFriend.style.display = "none";
                } else {
                        acceptreject.style.display = "none";
                        addDiv.style.display = "none";
			requestSent.style.display = "block";
			removeFriend.style.display = "none";
		}
	}

}


// Map scripts
var map, infoWindow;

function initViewEventMap() {                                                                                                                                               var locationRio = {lat: -22.915, lng: -43.197};
        var locationRio = {lat: -22.915, lng: -43.197};
        var map = new google.maps.Map(document.getElementById('viewEventMap'), {
          zoom: 13,
          center: locationRio,
          gestureHandling: 'cooperative'
        });
        var marker = new google.maps.Marker({
          position: locationRio,
          map: map,
          title: 'Hello World!'
        });
}

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
	} catch(error){
	//console.error(error);
	}
	try {
		initMap();
	} catch(error){

	}
	initViewEventMap();
}

