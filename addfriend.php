<?php
	include_once 'header.php';
	include_once 'includes/dbh.inc.php';
			
				
	if (isset($_POST['Add Friend'])) {
		$mysql=mysqli_query($conn, "INSERT INTO relationships (user_one_id, user_two_id, status, action_user_id) VALUES ($current, $usernumber, '1', $current)");
	}	
	
?>