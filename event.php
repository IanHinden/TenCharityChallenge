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
	</head>
	<body>
	
		<?php
			$eventId = $_GET['id'];
			
			echo "Event ID is: " . $eventId;
			
			$sql = "SELECT * FROM events WHERE event_id = '".$eventId."';";
			$result = mysqli_query($conn, $sql);
			$resultCheck = mysqli_num_rows($result);
			
			if ($resultCheck > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
					echo $row['event_avenue'] . " " . $row['event_info'];
				
				//Button to add event
				if (isset($_SESSION['u_id'])){
                                        echo '<form action="/confirmevent.php" class="confirmevent" method="post" />
                                        <input type="hidden" name="eventId" value="'. $eventId.'"/>
                                        <input id="'.$event.'" type="submit" name="confirmevent" value="Add Event" /></form>';
					echo 'You are logged in as '. $_SESSION['u_id']. '.';
				}

				}
			} else {
				echo "There is no event with this ID";
			}
		?>
	</body>
</html>
