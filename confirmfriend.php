<?php
	include_once 'header.php';
	include_once 'includes/dbh.inc.php';
	
	$current = $_SESSION['u_id'];
	$userid = $_POST['userid'];
	
	$mysql=mysqli_query($conn, "UPDATE relationships SET status = 1, action_user_id = $current WHERE user_one_id = $current");
	
	
?>
