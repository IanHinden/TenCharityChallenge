<?php
	include_once 'header.php';
	include_once 'includes/dbh.inc.php';
	
	$current = $_POST['current'];
	$usernumber = $_POST['usernumber'];
	
	$mysql=mysqli_query($conn, "INSERT INTO relationships (user_one_id, user_two_id, status, action_user_id) VALUES ($current, $usernumber, '1', $current)");

	
?>