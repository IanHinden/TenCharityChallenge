<?php
	include_once 'includes/dbh.inc.php';
        session_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="description" content="User page">
		<meta name=viewport content="width=device-width, initial-scale=1">
		<title>Volunteer Event Page</title>
		<link rel="stylesheet" type="text/css" href="../style.css"></link>
        	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        	<script src="../javascript/scripts.js"></script>
        	<link href="https://fonts.googleapis.com/css?family=Montserrat|Noto+Serif+JP" rel="stylesheet"></link>
	</head>
	<body>
	
		<?php
			$eventId = $_GET['id'];
			$todayDate = date("Y-m-d");

			echo "Event ID is: " . $eventId;

			//Determine user permissions

			$permission = 1;
			
			if(isset($_SESSION['u_id'])) {
        			$userId = $_SESSION['u_id'];
			} else {
				$permission = 0;
				echo "There is no user";
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
						echo "This user is involved, but not the creator";
						$permission = 2;
					}
                		}
        		} elseif ($permission != 0) {
                		echo "This user is not signed up for this event";
				$permission = 3;
        		}
			
			$sql = "SELECT * FROM events WHERE event_id = '".$eventId."';";
			$result = mysqli_query($conn, $sql);
			$resultCheck = mysqli_num_rows($result);
			
			for ($set = array (); $row = mysqli_fetch_assoc($result); $set[] = $row);
                        foreach ($set as $item){
                        	$eventAvenue = $item['event_avenue'];
                                $eventInfo = $item['event_info'];
				$lat = $item['lat'];
				$longit = $item['longit'];
                        }
                        echo $eventAvenue;
                        echo '<form class="eventform" id="eventform">
                        Event Avenue: <input type="text" value="'.$eventAvenue.'" name="eventAvenue" id="eventAvenue" readonly="readonly"><br>
                        Event Info: <input type="text" value="'.$eventInfo.'" name="eventInfo" id="eventInfo" readonly="readonly"><br>
			<input type="hidden" value="'.$lat.'" name="lat" id="lat" readonly="readonly">
			<input type="hidden" value="'.$longit.'" name="longit" id="longit" readonly="readonly">
                        <div id="viewEventMap"></div>
			<p id="editEvent">Edit</p>
                        <input type="submit">
                        </form>';

			if (count($set) > 0) {
				
				
				//Event details
				echo "<div id='eventdetails'>";
				echo $set[0]['event_avenue'] . " " . $set[0]['event_info'];
				echo "</div>";

				//Div for the proper button to interact with the event
				echo "<div id='interactbutton'>";
				
				//Cancel event
                                echo '<form action="/cancelevent.php" class="cancelevent" method="post" id="canceleventbutton"/>
                                <input type="hidden" name="eventId" value="'.$eventId.'"/>
                                <input id="cancel'.$eventId.'" type="submit" name="cancelevent" value="Cancel Event" /></form>';

				//Leave event
				echo '<form action="../includes/cancelattendevent.inc.php" class="cancelattendevent" method="post" id="leaveeventbutton"/>
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
					echo "Feel free to log your hours by signing up for this site!";
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
				echo '</div>';

				if ($permission == 1 || $permission == 2) {
					echo '</div>
		                        <form action="../eventimageupload.php" method="POST" enctype="multipart/form-data">
                        		<input type="file" name="fileToUpload[]" id="fileToUpload" multiple="multiple" readonly="false">
					<input type="hidden" name="eventId" value="'. $eventId.'"/>
                        		<button type="submit" value="Upload Image" name="submit">Submit</button></form></div>';

					echo '<div id="drop_zone" ondrop="dropHandler(event);" ondragover="dragOverHandler(event);">
  						<p>Drag one or more files to this Drop Zone ...</p>
						</div>';

				echo '</div>';
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
