<?php

session_start();
if (isset($_POST['submit'])) {
	
	include 'dbh.inc.php';
	
	$avenue = $_POST['avenue'];
	$info = $_POST['info'];
	$length = $_POST['length'];
	$datetime = $_POST['datetime-local'];
	$lat = $_POST['lat'];
	$long = $_POST['long'];
	$user = $_SESSION['u_id'];
	$cause = $_POST['cause'];
	//$startTime = $_POST['start_time'];
	
	//Error handlers
	// Check for empty fields
	//Insert the user into the database
	$sql = "INSERT INTO events (event_avenue, event_info, event_length, event_user, datetime_local, lat, longit, cause) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
	$stmt = mysqli_stmt_init($conn);
		if (!mysqli_stmt_prepare($stmt, $sql)){
			echo "SQL error";
		} else {
			mysqli_stmt_bind_param($stmt,"ssssssss", $avenue, $info, $length, $user, $datetime, $lat, $long, $cause);
			mysqli_stmt_execute($stmt);
			
			//Set relationsip with user to event as creator
			$eventid = mysqli_insert_id($conn);
			$sql = mysqli_query($conn, "INSERT INTO eventrelationships (event_id, user_id, creator) VALUES ($eventid, $user, 1)");
			header("Location: ../index.php?post=success");
			exit();
		}
	
} else {
	header("Location: ../index.php");
	exit();
}
