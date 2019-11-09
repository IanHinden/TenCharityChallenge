<?php
        include_once 'includes/dbh.inc.php';
?>

<?php

	$result = mysqli_query($conn, "SELECT user_uid FROM users");

	$data = array();
	while ($row = mysqli_fetch_object($result))
	
	{
    		array_push($data, $row);
	}

	echo json_encode($data);
	exit();
?>
