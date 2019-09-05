<?php
	include_once 'header.php';
	include_once 'includes/dbh.inc.php';
	
	$current = $_SESSION['u_id'];
	$usernumber = $_POST['usernumber'];

	if ($current < $usernumber){
		$lower = $current;
		$higher = $usernumber;
	} else {
		$lower = $usernumber;
		$higher = $current;
	}
	
	$mysql=mysqli_query($conn, "INSERT INTO relationships (user_one_id, user_two_id, status, action_user_id) VALUES ($lower, $higher, '0', $current)");
	
	
?>
