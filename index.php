<?php
	include_once 'header.php';
	include_once 'includes/dbh.inc.php';
?>

	<?php
		if (isset($_SESSION['u_id'])){
			echo '
			<div id="dashboard">
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
			echo ' </div></div>
                        <form action="profilephotoupload.php" method="POST" enctype="multipart/form-data">
                        <input type="file" name="fileToUpload" id="fileToUpload">
                        <button type="submit" value="Upload Image" name="submit">Submit</button></form></div>';
			echo '<div id="scores">
			<div id="volunteerscore" class="scorecard"><p>Volunteer Hours:<p>';
			
			$sql = "SELECT event_length FROM events WHERE event_user = '".$_SESSION['u_id']."';";
			$result = mysqli_query($conn, $sql);
			$resultCheck = mysqli_num_rows($result);
			$userTotalHours;
			
			if ($resultCheck > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
					$userTotalHours = $userTotalHours + $row['event_length'];
				}
			}
			
			echo $userTotalHours . '</p></p></div>
			<div id="inspirationscore" class="scorecard"><p>Inspiration Score:</p>'; /*<p>Insert Number Here</p>*/

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
			echo '</div>
			</div>
			<div id="navbar"><ol><li><a href="/search.php">Find Events</a></li><li>Find Friends</li>
			//Friend requests
			<li id="friendrequestsicon"><img src="https://community.cengage.com/Chilton2/utility/anonymous.gif">';
			
			$sql = "SELECT * FROM `relationships` WHERE (`user_one_id` = '".$_SESSION['u_id']."' OR `user_two_id` = '".$_SESSION['u_id']."') AND `status` = 0 AND `action_user_id` != '".$_SESSION['u_id']."'";
			$result = mysqli_query($conn, $sql);
			$totalFriendRequests = mysqli_num_rows($result);
			
			if ($totalFriendRequests > 0) {
				echo '<span class="alertcount">' . $totalFriendRequests . '</span>';
			}
			
			$sql = "SELECT user_first, user_last, user_id FROM users INNER JOIN relationships ON relationships.action_user_id = users.user_id WHERE (user_one_id = '".$_SESSION['u_id']."' OR user_two_id = '".$_SESSION['u_id']."') AND action_user_id !='".$_SESSION['u_id']."' AND status = 0";
			$result = mysqli_query($conn, $sql);
			$resultCheck = mysqli_num_rows($result);

			if ($resultCheck > 0) {
				echo '<div id="friendrequestpopup"><ul>';
				while ($row = mysqli_fetch_assoc($result)) {
					$userid = $row['user_id'];
					$firstname = $row['user_first'];
					$lastname = $row['user_last'];

					//Profile Image
					echo '<div class="requestprofilepic">';
					$sqlImg = "SELECT * FROM profilepicturelocation WHERE user_id = '".$row['user_id']."' AND current = 1;";
					$resultImg = mysqli_query($conn, $sqlImg);
					$rowresults = mysqli_num_rows($resultImg);
					if ($rowresults > 0) {
						while ($row = mysqli_fetch_assoc($resultImg)){
							echo "<img id='profileimage' src='https://gastatic.s3-us-west-1.amazonaws.com/profilepicture/" . $userid .  "/". $row['uniq_id']. $row['image_name'] . "'>";
						}
					} else {
						echo "<img id='profileimage' src='uploads/profiledefault.jpg'>";
					}
					echo '</div>';

					echo '<li><a href="https://tencharitychallenge.com/user/' . $userid . '">' . $firstname. ' ' . $lastname . '</a>' . 
					'<form action="/confirmfriend.php" class="confirmfriend" method="post" />
					<input type="hidden" name="userid" value="'. $userid.'"/>
					<input id="'.$userid.'" type="submit" name="confirmfriend" value="Confirm Friend" />
					</form></li>' .
					'<form action="/rejectfriend.php" class="rejectfriend" method="post" />
                                        <input type="hidden" name="userid" value="'. $userid.'"/>
                                        <input id="'.$userid.'" type="submit" name="rejectfriend" value="Reject Friend" />
                                  	 </form></li>';
				}
				echo '</ul></div>';
			}
			
			
			echo '
			</li>
			<li><img src="https://community.cengage.com/Chilton2/utility/anonymous.gif"><span class="alertcount">5</span></li>
			<li><img src="https://community.cengage.com/Chilton2/utility/anonymous.gif"><span class="alertcount">5</span></li>
			</ol></div>
			<form action="includes/addevent.inc.php" method="POST">
			<input id="search" type="text" name="avenue" placeholder="Search...">
			<input type="text" name="info" placeholder="Info">
			<input type="text" name="length" placeholder="Length">
			<input type="datetime-local" name="datetime-local">
			<select name="cause">
    				<option value="Animals">Animals</option>
    				<option value="Food Bank">Food Bank</option>
				<option value="Other">Other</option>
  			</select>
			<input type="hidden" id="lat" name="lat" step="any">
			<input type="hidden" id="long" name="long" step="any">
			<div id="map"></div>
			<button type="submit" name="submit">Create Event</button>
			</form>';
			
			$sql = "SELECT * FROM events JOIN eventrelationships ON events.event_id = eventrelationships.event_id WHERE completed >= 0 AND user_id = '".$_SESSION['u_id']."';";
			$result = mysqli_query($conn, $sql);
			$resultCheck = mysqli_num_rows($result);
			$todayDate = new DateTime();

			for ($set = array (); $row = mysqli_fetch_assoc($result); $set[] = $row);
			
			echo '<div id="upcomingevents">Upcoming Events';

			foreach ($set as $item){
				if(new DateTime($item['datetime_local']) > $todayDate){
					$eventinfo = $item['event_info'];
					$eventid = $item['event_id'];
					echo '<a href="https://tencharitychallenge.com/event/' . $eventid . '">' . $eventinfo. '</a>';
                                        echo '<form action="includes/cancelattendevent.inc.php" class="cancelattendevent" method="post" />
                                        <input type="hidden" name="eventid" value="'. $eventid.'"/>
                                        <input id="'.$eventid.'" type="submit" name="cancelattendevent" value="Cancel Attendance" />
                                        </form></li>';
					echo '<br>';
				}
			}
			echo '</div>';

			echo '<div id="previousevents">Previous Events';

			echo '<form action="report.php" method="post">
  				<input type="submit" value="Print Completed Event Report">
			</form>';

			foreach ($set as $item){
				if(new DateTime($item['datetime_local']) < $todayDate){
					$eventinfo = $item['event_info'];
					$eventid = $item['event_id'];
					$completed = $item['completed'];

					echo '<a href="https://tencharitychallenge.com/event/' . $eventid . '">' . $eventinfo. '</a>';
					if($completed == 0){
						echo '<form action="includes/confirmcompletedevent.inc.php" class="confirmcompletedevent" method="post" />
                                        	<input type="hidden" name="eventid" value="'. $eventid.'"/>
                                        	<input id="'.$eventid.'" type="submit" name="confirmcompletedevent" value="Confirm Completion" />
                                        	</form></li>';
					} else {
						echo 'You completed this!';
					}

					echo '<br>';
                                }
                        }
                        echo '</div>';

			
			echo '</div>';
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
						<p> Thanks to Ten Charity Challenge, ' . $totalHours . ' hours of charity have been performed. </p>
					</div>
			      </section>';

			echo '<section id="loginorsignup">
				<div id="loginorsignup-text">';

					?>
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
				<span class="tos-close">
					<span class="menu-line-tos menu-line-1-tos"></span>
					<span class="menu-line-tos menu-line-2-tos"></span>
				</span>
			</div>
			<p>Terms of Service</p>
			<p id="terms">I will do my best.</p>
			<input type="checkbox" name="checkbox" value="check" id="agree" />
			<p>I agree to the Terms of Service</p>
			<button type="submit" name="submit" value="submit" />Sign up</button>
			</form>
		</div>
		<div class="opaque"></div>
			<!-- <button type="submit" name="submit" value="submit">Sign up</button></form> -->
				<button id="show-tos" /*disabled="disabled"*/>Submit</button>
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
