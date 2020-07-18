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

	document.getElementById("logoandtitle").addEventListener("click", function(){
  		document.location.href = 'https://www.tencharitychallenge.com/';
	});

	var checkbox1 = document.getElementById("agree");
	var checkbox2 = document.getElementById("tostext");
	var accountsignupbutton = document.getElementById("accountsignupbutton");

	var acceptableemail = false;
	var acceptablefirstname = false;
	var acceptablelastname = false;
	var acceptablepassword = false;

	if(checkbox1 && checkbox2){
		checkbox1.addEventListener( 'change', function() {
	    		if(this.checked && checkbox2.checked) {
				accountsignupbutton.disabled = false;
				accountsignupbutton.style.backgroundColor = "black";
	    		} else {
				accountsignupbutton.disabled = true;
				accountsignupbutton.style.backgroundColor = "grey";
	    		}
		});
	}

	if(checkbox1 && checkbox2){
		checkbox2.addEventListener( 'change', function() {
	                if(this.checked && checkbox1.checked) {
				accountsignupbutton.disabled = false;
				accountsignupbutton.style.backgroundColor = "black";
	                } else {
				accountsignupbutton.disabled = true;
				accountsignupbutton.style.backgroundColor = "grey";
	                }
	        });
	}
	
	$("#accountsignupbutton").mouseover(function(){
		if($("#accountsignupbutton").prop("disabled", false)){
			$("#accountsignupbutton").css("background-color", "#523");
        	}
	});

	$("#accountsignupbutton").mouseleave(function(){
		$("#accountsignupbutton").css("background-color", "#222");
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
                                        usernametaken.style.visibility = "visible";
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
			acceptableemail = false;
		} else {
			emailformat.style.visibility = "hidden";
			acceptableemail = true;
		}
	}

	function displayemailwarningsubmit() {
		var emailformat = document.getElementById("emailformat");
		var emailcontent = document.getElementById("email").value;
		if(!validateEmail(emailcontent)){
			emailformat.style.visibility = "visible";
                        acceptableemail = false;
                } else {
                        emailformat.style.visibility = "hidden";
			acceptableemail = true;
                }
	}

	if(document.getElementById("firstname") != null) {
                document.getElementById("firstname").addEventListener("blur", displayfirstnamewarning);
        }

	function displayfirstnamewarning(e) {
                var firstnameformat = document.getElementById("firstnamewarning");
                if(e.target.value == ""){
			firstnameformat.innerText = "First name can not be blank";
                        firstnameformat.style.visibility = "visible";
			acceptablefirstname = false;
                } else if (e.target.value.length > 25) {
			firstnameformat.innerText = "First name can not be more than 25 characters";
                        firstnameformat.style.visibility = "visible";
			acceptablefirstname = false;
		} else {
			firstnameformat.style.visibility = "hidden";
                        acceptablefirstname = true;
                }
        }

	function displayfirstnamewarningsubmit() {
                var firstnameformat = document.getElementById("firstnamewarning");
                var firstnamecontent = document.getElementById("firstname").value;
		if(firstnamecontent == ""){
			firstnameformat.innerText = "First name can not be blank";
			firstnameformat.style.visibility = "visible";
			acceptablefirstname = false;
		} else if (firstnamecontent.length > 25) {
			firstnameformat.innerText = "First name can not be more than 25 characters";
			firstnameformat.style.visibility = "visible";
			acceptablefirstname = false;
                } else {
			firstnameformat.style.visibility = "hidden";
			acceptablefirstname = true;
		}
        }

	if(document.getElementById("lastname") != null) {
                document.getElementById("lastname").addEventListener("blur", displaylastnamewarning);
        }

	function displaylastnamewarning(e) {
                var lastnameformat = document.getElementById("lastnamewarning");
                if(e.target.value == ""){
			lastnameformat.innerText = "Last name can not be blank";
                        lastnameformat.style.visibility = "visible";
                        acceptablelastname = false;
                } else if (e.target.value.length > 25) {
                        lastnameformat.innerText = "Last name can not be more than 25 characters";
                        lastnameformat.style.visibility = "visible";
                        acceptablelastname = false;
                } else {
                        lastnameformat.style.visibility = "hidden";
                        acceptablelastname = true;
                }
        }

	function displaylastnamewarningsubmit() {
		var lastnameformat = document.getElementById("lastnamewarning");
		var lastnamecontent = document.getElementById("lastname").value;
                if(lastnamecontent == ""){
                        lastnameformat.innerText = "Last name can not be blank";
                        lastnameformat.style.visibility = "visible";
			acceptablelastname = false;
                } else if (lastnamecontent.length > 25) {
			lastnameformat.innerText = "Last name can not be more than 25 characters";
			lastnameformat.style.visibility = "visible";
                        acceptablelastname = false;
		} else {
			lastnameformat.style.visibility = "hidden";
			acceptablelastname = true;
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
                var usernameformat = document.getElementById("usernamewarning");
                if(!validateUsernameSpecialChars(e.target.value)){
			usernameformat.style.visibility = "visible";
                        usernameformat.innerText = "Please choose a username with no special characters.";
                } else {
                        usernameformat.style.visibility = "hidden";
                }
        }

        function validateUsernameSpecialChars(username) {
                var re = /^[a-zA-Z0-9]*$/
		return re.test(username);
        }

	if(document.getElementById("password") !=null){
                document.getElementById("password").addEventListener("input", invalidpasswordwarning);
	}

	function invalidpasswordwarning(e) {
                var passwordformat = document.getElementById("passwordwarning");
		if(!validatePassword(e.target.value)){
			passwordformat.style.visibility = "visible";
			acceptablepassword = false;
		} else {
			passwordformat.style.visibility = "hidden";
			acceptablepassword = true;
                }
        }

	function invalidpasswordwarningsubmit() {
                var passwordformat = document.getElementById("passwordwarning");
		var passwordvalue = document.getElementById("password").value;
                if(!validatePassword(passwordvalue)){
			passwordformat.style.visibility = "visible";
                        acceptablepassword = false;
		} else {
                        passwordformat.style.visibility = "hidden";
                        acceptablepassword = true;
		}
	}

	function validatePassword(password) {
		var re = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$/
                return re.test(password);
	}

	if(document.getElementById("passwordconfirm") !=null){
                document.getElementById("passwordconfirm").addEventListener("input", passwordmatch);
        }

	function passwordmatch() {
                var passwordformat = document.getElementById("passwordmatchwarning");
		var passwordvalue = document.getElementById("password").value;
		var passwordmatchvalue = document.getElementById("passwordconfirm").value;
                if(passwordvalue != passwordmatchvalue){
                        passwordformat.style.visibility = "visible";
		} else {
			passwordformat.style.visibility = "hidden";
		}
	}

	$("#show-tos").mouseover(function(){
  		$("#show-tos").css("background-color", "#523");
	});

	$("#show-tos").mouseleave(function(){
                $("#show-tos").css("background-color", "#222");
        });
	
	$('#show-tos').click(function() {
		if( !$("#firstname").val() ) {
          		$("#firstnamewarning").css({"visibility":"visible"});
    		} else {
			$("#firstnamewarning").css({"visibility":"hidden"});
		}

		if( !$("#lastname").val() ) {
			$("#lastnamewarning").css({"visibility":"visible"});
		} else {
			$("#lastnamewarning").css({"visibility":"hidden"});
		}

		displayemailwarningsubmit();
		displayfirstnamewarningsubmit();
		displaylastnamewarningsubmit();
		invalidpasswordwarningsubmit();

		if( $("#firstname").val() && $("#lastname").val() && (acceptableemail == true) && (acceptablefirstname == true) && (acceptablelastname == true) && (acceptablepassword == true)){
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

	//Event navigation buttons
	if(document.getElementById("upcomingeventsbutton") != null){
		let upcoming = document.getElementById("upcomingeventsbutton");
		upcoming.addEventListener("mouseover", hovercolor, false);
		upcoming.addEventListener("mouseout", defaultcolor, false);
		upcoming.addEventListener("click", displayupcoming, false);

		let previous = document.getElementById("previouseventsbutton");
		previous.addEventListener("mouseover", prevhovercolor, false);
        	previous.addEventListener("mouseout", prevdefaultcolor, false);
		previous.addEventListener("click", displayprevious, false);

		let upcomingevents = document.getElementById("upcomingevents");
		let previousevents = document.getElementById("previousevents");

		function hovercolor(){
			upcoming.style.backgroundColor = "#665882";
		}

		function defaultcolor(){
			upcoming.style.backgroundColor = "white";
		}

		function displayupcoming() {
			upcomingevents.style.display = "block";
			previousevents.style.display = "none";
		}

		function prevhovercolor(){
                	previous.style.backgroundColor = "#665882";
        	}

		function prevdefaultcolor(){
                	previous.style.backgroundColor = "white";
		}

		function displayprevious() {
                	upcomingevents.style.display = "none";
                	previousevents.style.display = "block";
		}
	}

	$("#friendrequestsicon").click(function(){
		$("#friendrequestpopup").toggle();
		$("#eventrequestpopup").hide();
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

	$("#eventrequestsicon").click(function(){
		$("#eventrequestpopup").toggle();
		$("#friendrequestpopup").hide();
        });

	// Code to put event listeners on friend request buttons
	var friendacceptbuttons = document.getElementsByClassName("modifyfriend");

	var adjustFriends = function() {
		let buttonarea = document.getElementById("friendrequest" + this.id);
		buttonarea.style.display = "none";
		let friendrequestbadge = document.getElementById("alertcount");
		let friendrequestquantity = parseInt(friendrequestbadge.innerText);
		if (friendrequestquantity == 1) {
			friendrequestbadge.style.visibility = "hidden";
		} else {
			friendrequestbadge.innerText = (friendrequestquantity - 1).toString();
		}
	};

	for (var i = 0; i < friendacceptbuttons.length; i++) {
    		friendacceptbuttons[i].addEventListener('click', adjustFriends, false);
	}

	$('.requestitem').submit(function() {
                var req = new XMLHttpRequest();
                req.open("post", this.action);
		req.send(new FormData(this));
                return false;
	});

	$('.confirmevent').submit(function() {
		var req = new XMLHttpRequest();
		req.open("post", this.action);
		req.send(new FormData(this));
		//var btn = document.getElementById(this.childNodes[2].nextSibling.id);
		//btn.disabled = true;
		properEventButton(2);
		return false;
	});

	$('.cancelattendevent').submit(function() {
		var data = new FormData();
                var req = new XMLHttpRequest();
                req.open('post', this.action);
                req.send(new FormData(this));
		properEventButton(3);
		return false;
        });

	$('.confirmcompletedevent').submit(function() {                                                                                                                                      var data = new FormData();
                var req = new XMLHttpRequest();
                req.open('post', this.action);
                req.send(new FormData(this));
		return false;
        });

	$('.confirmcompletion').submit(function() {
		var req = new XMLHttpRequest();
		req.open('post', this.action);
		req.send(new FormData(this));
		properPostEventButton(2);
		return false;
	});

	$('.confirmabsence').submit(function() {
		var req = new XMLHttpRequest();
		req.open('post', this.action);
                req.send(new FormData(this));
		properPostEventButton(-1);
		return false;
        });

	$('.confirmcompletedeventindex').submit(function() {
                var req = new XMLHttpRequest();
                req.open('post', this.action);
                req.send(new FormData(this));
                return false;
	});

	$('.cancelattendeventindex').submit(function() {
                var req = new XMLHttpRequest();
                req.open('post', this.action);
                req.send(new FormData(this));
                return false;
	});

	$("#selectall").click(function(){
		$('.invitefriendcheckbox').not(':disabled').prop('checked', true);
	});

let indexconfirmbuttons = document.getElementsByClassName("confirmindex");

var removeconfirmbutton = function(){
        let confirmbutton = document.getElementById(this.id);
        let absentbutton = document.getElementById("absent" + this.id.slice(7));

        confirmbutton.style.display = "none";
        absentbutton.style.display = "block";
}

for (var i = 0; i < indexconfirmbuttons.length; i++) {
        indexconfirmbuttons[i].addEventListener('click', removeconfirmbutton, false);
}

let indexabsentbuttons = document.getElementsByClassName("absentindex");

var removeabsentbutton = function(){
	let absentbutton = document.getElementById(this.id);
        let confirmbutton = document.getElementById("confirm" + this.id.slice(6));

	confirmbutton.style.display = "block";
	absentbutton.style.display = "none";
}

for (var i = 0; i < indexabsentbuttons.length; i++) {
	indexabsentbuttons[i].addEventListener('click', removeabsentbutton, false);
}

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


function showFriendRequests() {
	let friendrequestbadge = document.getElementById("alertcount");
	friendrequestbadge.style.visibility = "visible";
}

function eventInviteNumber(number){
	let badge = document.getElementById("eventalertcount");
	badge.style.display = "inline-block";
	badge.innerHTML = number;
}

function dragOverHandler(e) {
	let zone = document.getElementById("drop_zone");
	zone.style.border = "2px dashed black";
  	// Prevent default behavior (Prevent file from being opened)
  	e.preventDefault();
}

function dropHandler(ev) {
  	var filesToUpload = document.getElementById("fileToUpload");

  	// Prevent default behavior (Prevent file from being opened)
  	ev.preventDefault();
  	ev.stopPropagation();

  	filesToUpload.files = ev.dataTransfer.files;
}

function dragLeaveHandler(e) {
	let zone = document.getElementById("drop_zone");
        zone.style.border = "none";
	// Prevent default behavior (Prevent file from being opened)
        e.preventDefault();
}

var checkBoxState = function(number){
	let invitecheckbox = document.getElementById("checkbox" + number);
	invitecheckbox.disabled = true;
}

function needsAction(quantity){
	let badge = document.getElementById("previouseventneedsaction");
	badge.innerHTML = quantity;
}


function properEventIndex(completed, eventid){
	let confirm = document.getElementById("confirm" + eventid);
	let absent = document.getElementById("absent" + eventid);

	if(completed = -1) {
		confirm.style.display = "block";
		absent.style.display = "none";
	}

	if(completed = 1) {
		confirm.style.display = "none";
		absent.style.display = "block";
	}
}

//Display proper button to interact with events in the future
function properEventButton(permission){
	if(document.getElementById("signupeventbutton") != null) {
		var signup = document.getElementById("signupeventbutton");
	}

	if(document.getElementById("canceleventbutton") != null) {
		var cancel = document.getElementById("canceleventbutton");
	}

	if(document.getElementById("leaveeventbutton") != null) {
		var leave = document.getElementById("leaveeventbutton");
	}

	if (permission === 0) {
		console.log("You can sign up for an account");
	} else if (permission === 1) {
		signup.style.display = "none";
		cancel.style.display = "block";
		leave.style.display = "block";
	} else if (permission === 2) {
		leave.style.display = "block";
		signup.style.display = "none";
	} else if (permission === 3) {
		signup.style.display = "block";
		leave.style.display = "none";
	}
}

//Display proper buttons to interact with events in the past
function properPostEventButton(permission){
	var completion = document.getElementById("confirmcompletionbutton");
	var absence = document.getElementById("confirmabsencebutton");

	if (permission == 0) {
		console.log("Sign up for an account!");
	} else if (permission == -1) {
		console.log("Confirm completion of the event");
		completion.style.display = "block";
		absence.style.display = "none";
	} else if (permission == 1) {
		console.log("You can choose both");
		completion.style.display = "block";
		absence.style.display = "block";
	} else if (permission == 2) {
		completion.style.display = "none";
		absence.style.display = "block";
	}
}



//Friend Request Scripts
function properButton(id, status, currentUserRequested){
	var addDiv = document.getElementById("add" + id);
	var requestSent = document.getElementById("sent" + id);
	var acceptreject = document.getElementById("acceptreject" + id);
	var removeFriend = document.getElementById("remove" + id);
	
	if(status == -1){
		addDiv.style.display = "inline";
		requestSent.style.display = "none";
		acceptreject.style.display = "none";
		removeFriend.style.display = "none";
	} else if (status == 0) {
		if (currentUserRequested == true) {
			addDiv.style.display = "none";
			requestSent.style.display = "inline";
			acceptreject.style.display = "none";
			removeFriend.style.display = "none";
		} else {
			acceptreject.style.display = "block";
			addDiv.style.display = "none";
			requestSent.style.display = "none";
			removeFriend.style.display = "none";
		}
	} else if (status == 1) {
		removeFriend.style.display = "inline";
		addDiv.style.display = "none";
		requestSent.style.display = "none";
		acceptreject.style.display = "none";
	} else if (status == 2 ) {
		if (currentUserRequested == true) {
			addDiv.style.display = "inline";
			requestSent.style.display = "none";
			acceptreject.style.display = "none";
			removeFriend.style.display = "none";
                } else {
                        acceptreject.style.display = "none";
                        addDiv.style.display = "none";
			requestSent.style.display = "inline";
			removeFriend.style.display = "none";
		}
	}

}


// Map scripts
var map, infoWindow;

function initViewEventMap() {

	if(document.getElementById("lat") != null) {
		var lat = parseFloat(document.getElementById("lat").value);
	}

	if(document.getElementById("longit") != null) {
		var longit = parseFloat(document.getElementById("longit").value);
        }

	var locationEvent = {lat: lat, lng: longit};
        var map = new google.maps.Map(document.getElementById('viewEventMap'), {
          zoom: 13,
          center: locationEvent,
          gestureHandling: 'cooperative'
        });
        var marker = new google.maps.Marker({
          position: locationEvent,
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
	var tD = document.getElementById('toDate').value;
	var toDate = new Date(tD);

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
			map.setCenter(position);
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
            Array.prototype.forEach.call(markers, function(markerElem) {
              var id = markerElem.getAttribute('event_id');
	      var avenue = markerElem.getAttribute('event_avenue');
	      var cause = markerElem.getAttribute('cause');
              var eventDate = markerElem.getAttribute('event_date');
	      var eventDateObject = new Date(eventDate);
              //var address = markerElem.getAttribute('address');
              //var type = markerElem.getAttribute('type');
              var point = new google.maps.LatLng(
                  parseFloat(markerElem.getAttribute('lat')),
                  parseFloat(markerElem.getAttribute('longit')));
              var infowincontent = document.createElement('div');
              var strong = document.createElement('strong');
              strong.textContent = eventDate
              infowincontent.appendChild(strong);
              infowincontent.appendChild(document.createElement('br'));

              var text = document.createElement('text');
              text.textContent = avenue;
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

		//Create content
		let content = document.createElement("div");
		content.classList.add("searchdetailscontent");

		let locationp = document.createElement("p");
		let location = document.createTextNode("Location: " + avenue);
		locationp.appendChild(location);
		content.appendChild(location);

		let infodiv = document.getElementById("searcheventdetails");
		infodiv.innerHTML = "";
		infodiv.appendChild(content);
		
		infodiv.addEventListener("click", function(){
			document.location.href = 'https://www.tencharitychallenge.com/event/' + id;
		});
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
	try {
		initViewEventMap();
	} catch(error){

	}
}

