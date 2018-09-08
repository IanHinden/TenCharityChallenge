<?php

session_start();
if (isset($_POST['submit'])) {
	
	include 'dbh.inc.php';
	
	$avenue = $_POST['avenue'];
	$info = $_POST['info'];
	$length = $_POST['length'];
	$user = $_SESSION['u_id'];
	
	//Error handlers
	// Check for empty fields
	//Insert the user into the database
	$sql = "INSERT INTO events (event_avenue, event_info, event_length, event_user) VALUES (?, ?, ?, ?);";
	$stmt = mysqli_stmt_init($conn);
		if (!mysqli_stmt_prepare($stmt, $sql)){
			echo "SQL error";
		} else {
			mysqli_stmt_bind_param($stmt,"ssss", $avenue, $info, $length, $user);
			mysqli_stmt_execute($stmt);
			header("Location: ../index.php?post=success");
			exit();
		}
	
} else {
	header("Location: ../index.php");
	exit();
}