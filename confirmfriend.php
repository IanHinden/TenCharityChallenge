<?php
	include_once 'header.php';
	include_once 'includes/dbh.inc.php';
	
	$current = $_SESSION['u_id'];
	$userid = $_POST['userid'];

	if ($current < $userid){
                $lower = $current;
                $higher = $userid;
        } else {
                $lower = $userid;
                $higher = $current;
        }
	
	$mysql=mysqli_query($conn, "UPDATE relationships SET status = 1, action_user_id = $current WHERE user_one_id = $lower AND user_two_id = $higher");
	
	
?>
