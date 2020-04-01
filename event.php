<?php
	include_once 'header2.php';
	include_once 'includes/dbh.inc.php';
?>

<!DOCTYPE html>
<html>
	<body>
	
		<?php
			$eventId = $_GET['id'];
			$now = new DateTime();

			//Determine user permissions

			$permission = 1;
			
			if(isset($_SESSION['u_id'])) {
        			$userId = $_SESSION['u_id'];
			} else {
				//There is no user
				$permission = 0;
			}
			//0 means not signed in, 1 means creator, 2 means involved, 3 means not signed up,

        		$sql = "SELECT * FROM eventrelationships WHERE event_id = '".$eventId."' AND user_id = '".$userId."';";
        		$result = mysqli_query($conn, $sql);
        		$resultCheck = mysqli_num_rows($result);

        		if ($resultCheck > 0) {
                		while ($row = mysqli_fetch_assoc($result)) {
					if ($row['creator'] == 1) {
						if ($row['completed'] != -1) {
                        				echo "This user is the creator";
							$permission = 1;
						} else {
							echo "This user is the creator, but they left this event";
							$permission = 3;
						}
					} else {
						if ($row['completed'] !=-1) {
							echo "This user is involved, but not the creator";
							$permission = 2;
						} else {
							echo "This user was signed up but left";
							$permission = 3;
						}
					}
                		}
        		} elseif ($permission != 0) {
                		echo "This user is not signed up for this event";
				$permission = 3;
        		}
			
			$sql = "SELECT events.event_avenue, events.event_user, events.event_info, events.lat, events.longit, events.datetime_local, events.event_length, users.user_first, users.user_last FROM events JOIN users ON events.event_user = users.user_id WHERE event_id = '".$eventId."';";
			$result = mysqli_query($conn, $sql);
			$resultCheck = mysqli_num_rows($result);
			
			for ($set = array (); $row = mysqli_fetch_assoc($result); $set[] = $row);
                        foreach ($set as $item){
                        	$eventAvenue = $item['event_avenue'];
                                $eventInfo = $item['event_info'];
				$lat = $item['lat'];
				$longit = $item['longit'];
				$datetime = $item['datetime_local'];
				$duration = $item['event_length'];
				$firstname = $item['user_first'];
				$lastname = $item['user_last'];
				$eventcreatorid = $item['event_user'];
                        }

			echo $firstname;
			echo $lastname;

			//Check if event is future
			$future = true;

			if(new DateTime($datetime) < $now){
				$future = false;
			}

			$datetime = strtotime($datetime);
			$datetime = date('Y-m-d\TH:i', $datetime);

			echo '<div id="pagecontent">';
                        echo '<form class="eventform" id="eventform">
			<div id="detailsandmap">
				<div id="eventdetails" class="eventdetailsboxes">
                        		<div class="eventvalues"><p>Event Avenue</p><textarea rows="2" value="'.$eventAvenue.'" name="eventAvenue" id="eventAvenue" readonly="readonly">'.$eventAvenue.'</textarea></div>
                        		<div id="datetimeduration">
						<div id="datetimebox" class="eventvalues"><p>Date and Time</p><input type="datetime-local" value="'.$datetime.'" name="datetime" id="datetime" readonly="readonly"></div>
						<div id="durationbox" class="eventvalues"><p>Duration</p><input type="text" value="'.$duration. " hours". '" name="duration" id="duration" readonly="readonly"></div>
					</div>
					<div class="eventvalues"><p>Event Info</p><input type="text" value="'.$eventInfo.'" name="eventInfo" id="eventInfo" readonly="readonly"></div>
					<input type="hidden" value="'.$lat.'" name="lat" id="lat" readonly="readonly">
					<input type="hidden" value="'.$longit.'" name="longit" id="longit" readonly="readonly">
                        	</div>
				<div id="viewEventMap" class="eventdetailsboxes"></div>
			</div>
			<div id="createdby">
				<p>Event host: <a href="https://www.tencharitychallenge.com/user/'.$eventcreatorid.'">'.$firstname.' '.$lastname.'</a></p>
			</div>';
			
			if($permission == 1){
				echo '<div>
					<p id="editEvent">Edit</p>
                        		<input type="submit">
				</div>';
			}
                        echo '</form>';

			if (count($set) > 0) {

				//Div for the proper button to interact with the event
				echo "<div id='interactbutton'>";
				
				//Cancel event
                                echo '<form action="../includes/cancelevent.php" class="cancelevent" method="post" id="canceleventbutton"/>
                                <input type="hidden" name="eventId" value="'.$eventId.'"/>
                                <input id="cancel'.$eventId.'" type="submit" name="cancelevent" value="Cancel Event" /></form>';

				//Leave event
				echo '<form action="/includes/cancelattendevent.inc.php" class="cancelattendevent" method="post" id="leaveeventbutton"/>
				<input type="hidden" name="eventid" value="'. $eventId.'"/>
				<input id="leave'.$eventId.'" type="submit" name="cancelattendevent" value="Cancel Attendance" /></form>';


                                /*echo '<form action="/leaveevent.php" class="leaveevent" method="post" id="leaveeventbutton"/>
                                <input type="hidden" name="eventId" value="'. $eventId.'"/>
                                <input id="'.$eventId.'" type="submit" name="leaveevent" value="Leave Event" /></form>';*/

				//Signup button
				echo '<form action="/confirmevent.php" class="confirmevent" method="post" id="signupeventbutton"/>
				<input type="hidden" name="eventId" value="'. $eventId.'"/>
                                <input id="signup'.$eventId.'" type="submit" name="confirmevent" value="Add Event" /></form>';

				echo "</div>";
				//Button to add event
				if ($permission == 0) {
					echo '<script type="text/javascript">',
                                                'properEventButton(0);',
                                        '</script>';
					echo '<div id="calltoaction">
						<p>Want to log your volunteer hours for this event? Sign up <a href="https://tencharitychallenge.com/signup.php">here!</a></p>
						</div>';
				} elseif ($permission == 1){
					echo "You made this";
					echo '<script type="text/javascript">',
                                                'properEventButton(1);',
                                             '</script>';
				} elseif ($permission == 2) {
					echo "You didn't make this, but you're involved.";
					echo '<script type="text/javascript">',
                                                'properEventButton(2);',
                                        '</script>';
				} elseif ($permission == 3){
                                        echo '<script type="text/javascript">',
                                                'properEventButton(3);',
                                        '</script>';
				}

				echo '<div id="eventPopup">';
				echo '<div id="popupClose">&times</div>';
				echo '<div id="eventImages">';

				$sql = "SELECT * FROM eventimages WHERE event_id = '".$eventId."';";
                        	$result = mysqli_query($conn, $sql);

                        	for ($eventImages = array (); $row = mysqli_fetch_assoc($result); $eventImages[] = $row);
                        	foreach ($eventImages as $item){
                                	$uniqId = $item['uniq_id'];
                                	$imageName = $item['image_name'];

					$imageURL = "<img src='https://tencharity.s3-us-west-2.amazonaws.com/event/" . $eventId. "/" . $uniqId . $imageName . "'>";
					//echo "<img class='eventimage' src='https://tencharity.s3-us-west-2.amazonaws.com/event/'".$eventId."'/'" .$uniqId . $image_name'">";
					echo "<div class='eventimage'>";
                        		echo $imageURL;
					echo "</div>";
				}

				echo '<a id="prev" class="prev">&#10094;</a>
                                      <a id="next" class="next">&#10095;</a>';
				echo '</div></div>';
				echo '</div>';

				if ($permission == 1 || $permission == 2) {
					echo '
		                        <form action="../eventimageupload.php" method="POST" enctype="multipart/form-data">
                        		<input type="file" name="fileToUpload[]" id="fileToUpload" multiple="multiple" readonly="false">
					<input type="hidden" name="eventId" value="'. $eventId.'"/>
                        		<button type="submit" value="Upload Image" name="submit">Submit</button></form></div>';

					echo '<div id="drop_zone" ondrop="dropHandler(event);" ondragover="dragOverHandler(event);" ondragleave="dragLeaveHandler(event);">
  						<p>Drag one or more files to this Drop Zone ...</p>';

						foreach ($eventImages as $key => $item){
                                        	$uniqId = $item['uniq_id'];
                                        	$imageName = $item['image_name'];
						
						$imageURL = "<img class='eventimagethumb' src='https://tencharity.s3-us-west-2.amazonaws.com/event/" . $eventId. "/" . $uniqId . $imageName . "'>";
						echo "<div id='$key' class='eventimagethumbcontainers'>";
                                        	echo $imageURL;
                                        	echo "</div>";
	                                	}


						echo '</div>';

				echo '</div></div></div></div>';
				}
			} else {
				echo "There is no event with this ID";
			}
		?>

<?php
	include_once 'footer.php';
?>
	</body>
</html>
