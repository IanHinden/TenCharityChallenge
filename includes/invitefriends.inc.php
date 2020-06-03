<?php

session_start();
include_once '../includes/dbh.inc.php';

if(isset($_POST['submit'])){

	$current = $_SESSION['u_id'];
        $eventnumber = $_POST['eventId'];

	if(!empty($_POST['friendlist'])){
		foreach($_POST['friendlist'] as $selected){
			
			$mysql=mysqli_query($conn, "INSERT INTO inviterelationships (user_id, invited_user_id, event_id, invite) VALUES ($current, $selected, $eventnumber, 1) ON DUPLICATE KEY UPDATE user_id = $current");

			echo $selected."</br>";
		}
	}
}

?>
