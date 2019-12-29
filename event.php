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
                        			echo "This user is the creator";
						$permission = 1;
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
			
			if ($resultCheck > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
					echo $row['event_avenue'] . " " . $row['event_info'];
				
				//Event details
				echo "<div id='eventdetails'>";
				echo "</div>";

				//Div for the proper button to interact with the event
				echo "<div id='interactbutton'>";
				
				//Cancel event
                                echo '<form action="/cancelevent.php" class="cancelevent" method="post" id="canceleventbutton"/>
                                <input type="hidden" name="eventId" value="'. $eventId.'"/>
                                <input id="'.$eventId.'" type="submit" name="cancelevent" value="Cancel Event" /></form>';

				//Leave event
                                echo '<form action="/leaveevent.php" class="leaveevent" method="post" id="leaveeventbutton"/>
                                <input type="hidden" name="eventId" value="'. $eventId.'"/>
                                <input id="'.$eventId.'" type="submit" name="leaveevent" value="Leave Event" /></form>';

				//Signup button
				echo '<form action="/confirmevent.php" class="confirmevent" method="post" id="signupeventbutton"/>
				<input type="hidden" name="eventId" value="'. $eventId.'"/>
                                <input id="'.$eventId.'" type="submit" name="confirmevent" value="Add Event" /></form>';

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

				}
			} else {
				echo "There is no event with this ID";
			}
		?>
	</body>
</html>
