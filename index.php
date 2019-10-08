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
							echo "<img id='profileimage' src='https://gastatic.s3-us-west-1.amazonaws.com/profilepicture/" . $id .  "/". $row['uniq_id']. $row['image_name'] . "'>";
						}
					} else {
						echo "<img id='profileimage' src='uploads/profiledefault.jpg'>";
					}
			echo ' </div></div>
                        <form action="testfileupload.php" method="POST" enctype="multipart/form-data">
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
			<div id="navbar"><ol><li>Find Events</li><li>Find Friends</li>
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
					echo '<li><a href="https://tencharitychallenge.com/user/' . $userid . '">' . $row['user_first']. ' ' . $row['user_last'] . '</a>' . 
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
			<input type="date" name="date">
			<input type="time" name="start_time">
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
			
			$sql = "SELECT * FROM events WHERE event_user = '".$_SESSION['u_id']."';";
			$result = mysqli_query($conn, $sql);
			$resultCheck = mysqli_num_rows($result);

			echo "Today is " . date("Y-m-d") . "<br>";
			$todayDate = date("Y-m-d");
			echo $todayDate;

			if ($resultCheck > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
					echo '<p>' . $row['event_info']. '</p><br>';
					echo 'This is the date: ' . date($row['event_date']) . '<br>';
					$eventDate = date($row['event_date']);
					echo $eventDate;
					if ($eventDate > $todayDate) {
						echo "This event is in the future";
					} else {
						echo "This event is in the past";
					}
					//echo '<script type="text/Javascript">console.log(' . $row['event_date'] .');</script>';
				}
			}
			
			echo '</div>';
		} else {
			echo '<section class="main-container">
					<div class="main-container-text">
						<h2>Welcome to the Ten Charity Challenge </h2>
						<h3>Can you volunteer? Ten times in one year?</h3>
			</div>
			</section>';
			
			$sql = "SELECT * FROM events WHERE event_id > 0";
			$result = mysqli_query($conn, $sql);
			$resultCheck = mysqli_num_rows($result);
			$totalHours = 0;
			
			if ($resultCheck > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
					$totalHours = $totalHours + $row['event_length'];
				}
			}
			
			echo '<p> Thanks to Ten Charity Challenge,' . $totalHours . 'hours of charity have been performed. </p>'; 
		}
		?>
	</div>
</section>


<div id="main-about">
	<section id="intro">
		<div class="desc">
			<h2>Can you volunteer? Ten times in one year?</h2>
			<h3>At the Ten Charity Challenge, we have just one question: can you successfully volunteer ten times in a year? To win, all you need to do serve at a soup kitchen once a month. Or pack lunches for homeless teens. Or drive pets to the vet for veterans...</h3>
		</div>
	</section>
	<section id="purposeid">
		<div class="purpose">	
			<div class="purpose-child">
				<img src="https://s3.amazonaws.com/www.thegarbage.org/images/headerimage1.jpg" alt="Purpose">
			</div>
			<div class="purpose-child-two">
				<h2>What is this site?</h2>
				<h3>The purpose of this website is to give you a space to keep track of your volunteer events. This site is not a necessary part of the challenge. In fact, everything site does can be replicated with a pencil and paper. But if you want a place to keep track, leave notes and photos, and share events to involve your friends, we're here for you.</h3>
			</div>
		</div>
	</section>
	<section>
		<div class="benefits">
			<h2>The Benefits of Volunteering</h2>
			<h3>Volunteering can help organizations in need while giving people in the community a better chance to get to know their neighbors. Volunteers learn more about issues their communities are facing. On top of that, it's a great group activity!</h3>
		</div>
	</section>
	<div class="mobile-signup"><a href="signup.php">SIGN UP</a></div>
</div>

<?php
	include_once 'footer.php';
?>
