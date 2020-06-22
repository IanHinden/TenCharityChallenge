<?php
	include_once 'header.php';
	include_once 'includes/dbh.inc.php';
?>

	<?php
		if (isset($_SESSION['u_id'])){
			echo '<div id="dashboard">
			<div id="dashboardcontent">
				<div id="profilepic">';
					$sqlImg = "SELECT * FROM profilepicturelocation WHERE user_id = '".$_SESSION['u_id']."' AND current = 1;";
					$resultImg = mysqli_query($conn, $sqlImg);
					$id = $_SESSION['u_id'];
					$rowresults = mysqli_num_rows($resultImg);
					if ($rowresults > 0) {
						while ($row = mysqli_fetch_assoc($resultImg)){
							//echo "<img id='profileimage' src='https://gastatic.s3-us-west-1.amazonaws.com/profilepicture/" . $id .  "/". $row['uniq_id']. $row['image_name'] . "'>";
							echo "<img id='profileimage' src='https://tencharity.s3-us-west-2.amazonaws.com/profilepicture/" . $id . "/". $row['uniq_id']. $row['image_name'] . "'>";
						}
					} else {
						echo "<img id='profileimage' src='uploads/profiledefault.jpg'>";
					}
			echo '
                        <form action="profilephotoupload.php" method="POST" enctype="multipart/form-data">
                        <input type="file" name="fileToUpload" id="fileToUpload">
                        <button type="submit" value="Upload Image" name="submit">Submit</button></form></div>';
			echo '<div id="scores">
			<div id="volunteerscorespace"><div id="volunteerscore" class="scorecard"><p>Volunteer Hours:<p>';
			
			$sql = "SELECT event_length, completed FROM events INNER JOIN eventrelationships ON events.event_id = eventrelationships.event_id WHERE event_user = '".$_SESSION['u_id']."' AND completed > 0;";
			$result = mysqli_query($conn, $sql);
			$resultCheck = mysqli_num_rows($result);
			$userTotalHours;
			
			if ($resultCheck > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
					$userTotalHours = $userTotalHours + $row['event_length'];
				}
			}
			
			echo $userTotalHours . '</p></p></div></div>
			<div id="inspirationscorespace"><div id="inspirationscore" class="scorecard"><p>Inspiration Score:</p>'; /*<p>Insert Number Here</p>*/

			$sql = "SELECT * FROM events INNER JOIN eventrelationships ON events.event_id = eventrelationships.event_id WHERE event_user = '".$_SESSION['u_id']."' AND user_id <> '".$_SESSION['u_id']."' AND completed = 1;";
			$result = mysqli_query($conn, $sql);
			$totalEvents = mysqli_num_rows($result);
			$inspirationScore = 0;
			
			if ($totalEvents > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
					$inspirationScore = $inspirationScore + $row['event_length'];
				}
			}

			echo '<span class="inspirationcount">' . $inspirationScore . '</span>';
			echo '</div></div>
			</div></div></div></div>
			<div id="navbar">
				<form class="navbutton" method="post" action="/search.php">
    					<input type="submit" value="SEARCH FRIENDS" />
				</form>
				<form class="navbutton" method="post" action="/eventsearch.php">
                                        <input type="submit" value="SEARCH EVENTS" />
                                </form>
				<form class="navbutton" method="post" action="/addevent.php">
                                        <input type="submit" value="CREATE EVENT" />
                                </form>';
			
			echo '</div>';
			
			$sql = "SELECT * FROM events JOIN eventrelationships ON events.event_id = eventrelationships.event_id WHERE completed >= 0 AND user_id = '".$_SESSION['u_id']."';";
			$result = mysqli_query($conn, $sql);
			$resultCheck = mysqli_num_rows($result);
			$todayDate = new DateTime();

			for ($set = array (); $row = mysqli_fetch_assoc($result); $set[] = $row);
			
			echo '<div id="eventsandfriends">
				<div id="upcomingpreviousevents">
					<div id="eventsnavbar">
						<div class="eventnavbutton" id="upcomingeventsbutton">
							<p>Upcoming Events</p>
						</div>
						<div class="previouseventsinteractions">
							<div id="previouseventneedsaction">0</div>
							<div class="eventnavbutton" id="previouseventsbutton">
								<p>Previous Events</p>
							</div>
						</div>
					</div>
					<div id="upcomingevents">';

			foreach ($set as $item){
				if(new DateTime($item['datetime_local']) > $todayDate){
					$eventinfo = $item['event_info'];
					$eventid = $item['event_id'];
					echo '<a href="https://www.tencharitychallenge.com/event/' . $eventid . '">' . $eventinfo. '</a>';
                                        echo '<form action="includes/cancelattendevent.inc.php" class="cancelattendevent" method="post" />
                                        <input type="hidden" name="eventid" value="'. $eventid.'"/>
                                        <input id="'.$eventid.'" type="submit" name="cancelattendevent" value="Cancel Attendance" />
                                        </form></li>';
					echo '<br>';
				}
			}
			echo '</div>';

			echo '<div id="previousevents">';

			echo '<form action="report.php" method="post">
  				<input type="submit" value="Print Completed Event Report">
			</form>';

			$needsaction = 0;

			foreach ($set as $item){
				if(new DateTime($item['datetime_local']) < $todayDate){
					$eventinfo = $item['event_info'];
					$eventid = $item['event_id'];
					$completed = $item['completed'];

					echo '<a href="https://www.tencharitychallenge.com/event/' . $eventid . '">' . $eventinfo. '</a>';
					echo '<form action="includes/confirmcompletedeventindex.inc.php" class="confirmcompletedeventindex" method="post" />
                                        <input type="hidden" name="eventid" value="'. $eventid.'"/>
                                        <input id="confirm'.$eventid.'" type="submit" class="confirmindex" name="confirmcompletedevent" value="Confirm Completion" />
                                        </form></li>
					<form action="includes/cancelattendeventindex.inc.php" class="cancelattendeventindex" method="post" />
                                        <input type="hidden" name="eventid" value="'. $eventid.'"/>
					<input id="absent'.$eventid.'" type="submit" class="absentindex" name="confirmabsentevent" value="Confirm Absence" />
					</form></li>';

					if ($completed == -1) {
						echo '<script type="text/javascript">',
                                		'properEventIndex(-1, '.$eventid.');',
                        			'</script>';
					} else if ($completed == 0) {
						++$needsaction;
					} else if ($completed == 1) {
						 echo '<script type="text/javascript">',
                                		'properEventIndex(1, '.$eventid.');',
                        			'</script>';
					}

					echo '<br>';
                                }
                        }

			echo '<script type="text/javascript">',
                        	'needsAction('.$needsaction.');',
                        '</script>';
			
			echo '</div></div>';
			echo '<div id="friendlist">';
			
			$sql = "SELECT user_first, user_last, user_id FROM users INNER JOIN relationships ON relationships.user_two_id = users.user_id WHERE (user_one_id = '".$_SESSION['u_id']."') AND status = 1";
			$result = mysqli_query($conn, $sql);
			$resultCheck = mysqli_num_rows($result);

			for ($set = array (); $row = mysqli_fetch_assoc($result); $set[] = $row);

			$sql = "SELECT user_first, user_last, user_id FROM users INNER JOIN relationships ON relationships.user_one_id = users.user_id WHERE (user_two_id = '".$_SESSION['u_id']."') AND status = 1";
			$result = mysqli_query($conn, $sql);
                        $resultCheck = mysqli_num_rows($result);

                        for ($set; $row = mysqli_fetch_assoc($result); $set[] = $row);

			foreach ($set as $item){
				echo '<div class="friend"><ul>';
				
					$userid = $item['user_id'];
					$firstname = $item['user_first'];
					$lastname = $item['user_last'];

					//Profile Image
					echo '<li><div class="friendlistprofilepicbox">';
					$sqlImg = "SELECT * FROM profilepicturelocation WHERE user_id = '".$userid."' AND current = 1;";
					$resultImg = mysqli_query($conn, $sqlImg);
					$rowresults = mysqli_num_rows($resultImg);
					if ($rowresults > 0) {
						while ($row = mysqli_fetch_assoc($resultImg)){
							echo "<img class='friendlistprofilepic' src='https://tencharity.s3-us-west-2.amazonaws.com/profilepicture/" . $userid .  "/". $row['uniq_id']. $row['image_name'] . "'>";
						}
					} else {
						echo "<img class='friendlistprofilepic' src='uploads/profiledefault.jpg'>";
					}
					echo '</div>';

					echo '<a class="friendlistname" href="https://www.tencharitychallenge.com/user/' . $userid . '">' . $firstname. ' ' . $lastname . '</a>' .
					'<form class="removefriend" action="/removefriend.php" method="post" />
					<input type="hidden" name="userid" value="'. $userid.'"/>
					<input id="'.$userid.'" type="submit" name="removefriend" value="Remove Friend" />
					</form>';
					
				echo '</li></div>';
			}

			echo '</div></div>';



		} else {

			$sql = "SELECT * FROM events WHERE event_id > 0";
                        $result = mysqli_query($conn, $sql);
			$resultCheck = mysqli_num_rows($result);
			$totalHours = 0;

			if ($resultCheck > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
                                        $totalHours = $totalHours + $row['event_length'];
                                }
                        }


			echo '<div id="loggedoutmain"><section class="main-container">
					<div class="main-container-text">
						<div>
							<h2>Find, Create, and Share Volunteer Events</h2>
						</div>
						<div>
							<h2>Track volunteer work you inspired</h2>
						</div>
						<div>
							<h2>Easy volunteer resume reports</h2>
						</div>
						<h3>Join the Ten Charity Challenge.</h3>
						<p> Thanks to Ten Charity Challenge, ' . $totalHours . ' hours of volunteer work have been performed. </p>
					</div>
			      </section>';

			echo '<section id="mobilelogin">
					<div id="mobilelogintext">
				        	<div id="mobilelogininstructions">
							<h1>Login</h1>
						</div>
						<form class="mobilelogininstructionsform" action="includes/login.inc.php" method="POST">
							<input type="text" name="uid" placeholder="Username/email"></input>
							<input type="password" name="pwd" placeholder="Password"></input>
							<button type="submit" name="submit">Login</button>
							<a href="https://tencharitychallenge.com/passwordreset.php">Forgot your password?</a>
						</form>
					</div>
				</section>';

			echo '<section id="loginorsignup">
				<div id="loginorsignup-text">';

					?>
					<div id="signupinstructions">
						<h1>Sign up</h1>
						<h2>Fill out the form below</h2>
					</div>
					<form class="signup-form" action="includes/signup.inc.php" method="POST" onsubmit="if(document.getElementById('agree').checked) { return true; } else { alert('Please indicate that you have read and agree to the Terms of Service and Privacy Policy'); return false; }">
					<input type="text" id="firstname" name="first" placeholder="First name"><br>
					<p id="firstnamewarning">First name can not be blank.</p>
					<input type="text" id="lastname" name="last" placeholder="Last name"><br>
					<p id="lastnamewarning">Last name can not be blank.</p>
					<input type="text" id="email" name="email" placeholder="E-mail"><br>
					<p id="emailformat">Please enter a valid email address.</p>
					<input type="text" id="username" name="uid" placeholder="User name"><br>
					<p id="usernamewarning">This username is already in use.</p>
					<input type="password" name="pwd" placeholder="Password"><br>


		<div class="confirm">
			<div id="tos">
				<p id="termsheadertext">Terms of Service</p>
				<span class="tos-close">
					<span class="menu-line-tos menu-line-1-tos"></span>
					<span class="menu-line-tos menu-line-2-tos"></span>
				</span>
			</div>
			<div id="tosinteract">
				<div>
					<input type="checkbox" name="checkbox" value="check" id="agree"/>
					<p class="tosagree">I agree to the <a href="https://tencharitychallenge.com/terms">Terms of Service</a></p>
				</div><br>
				<div>
					<input type="checkbox" name="tos" value="tos" id="tostext"/>
					<p class="tosagree">I will be the best person that I can be.</p>
				</div><br>
				<div>
					<button id="accountsignupbutton" type="submit" name="submit" value="submit" disabled="disabled"/>Sign up</button>
				</div>
			</div>
			</form>
		</div>
		<div class="opaque"></div>
			<!-- <button type="submit" name="submit" value="submit">Sign up</button></form> -->
				<button id="show-tos">Submit</button>
			<?php
			echo	'</div>
			</section></div>';

		}
		?>

	</div>
</section>

<?php
	include_once 'footer.php';
?>
