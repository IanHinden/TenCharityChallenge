<?php
	session_start();

        include_once 'header.php';
        include_once 'dbh.inc.php';

        $current = $_SESSION['u_id'];
	$eventid = $_POST['eventid'];

	$mysql=mysqli_query($conn, "INSERT INTO eventrelationships (completed, event_id, user_id, creator) VALUES (1, $eventid, $current, 0) ON DUPLICATE KEY UPDATE completed = 1");


?>
