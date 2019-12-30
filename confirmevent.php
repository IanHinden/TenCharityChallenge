<?php
	include_once 'header.php';
	include_once 'includes/dbh.inc.php';
	
	$current = $_SESSION['u_id'];
	$eventnumber = $_POST['eventId'];
	
	$mysql=mysqli_query($conn, "INSERT INTO eventrelationships (event_id, user_id) VALUES ($eventnumber, $current) ON DUPLICATE KEY UPDATE completed = 0");

?>
