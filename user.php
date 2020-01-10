<?php
	include_once 'includes/dbh.inc.php';
	session_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="description" content="User page">
		<meta name=viewport content="width=device-width, initial-scale=1">
		<title>Profile Page</title>
	</head>
	<body>
	
		<?php
			$profileId = $_GET['id'];
			
			if(isset($_SESSION['u_id'])) {
                                $userId = $_SESSION['u_id'];

				//Determine which number is smaller
                        	if ($userId < $profileId){
                                	$lower = $userId;
                                	$higher = $profileId;
                        	} else {
                                	$lower = $profileId;
                                	$higher = $userId;
                        	}

				$sql = "SELECT * FROM relationships WHERE user_one_id = '".$lower."' AND user_two_id = '".$higher."';";
                        	$result = mysqli_query($conn, $sql);
                        	$resultCheck = mysqli_num_rows($result);

				if ($resultCheck > 0) {
                                	while ($row = mysqli_fetch_assoc($result)) {
                                        	if ($row['action_user_id'] == $userId ) {
                                                	echo "This logged in user requested a change";
                                        	} else {
                                                	echo "The user that owns this profile requested a change";
                                        	}
                                	}
                        	} else {
                                	echo "These users have no relationships";
                        	}

                        } else {
                                echo "There is no user";
                    	}
			
			$sql = "SELECT * FROM users WHERE user_id = '".$profileId."';";
			$result = mysqli_query($conn, $sql);
			$resultCheck = mysqli_num_rows($result);
			
			if ($resultCheck > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
					echo $row['user_first'] . " " . $row['user_last'];
				}
			} else {
				echo "There is no user with this ID";
			}
		?>
	</body>
</html>
