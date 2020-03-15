<?php
	include_once 'header2.php';
	include_once 'includes/dbh.inc.php';
?>

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
							if ($row['status'] == 0) {
								echo "Logged in user sent friend request";
							} else if ($row['status'] == 1) {
								echo "Logged in user confirmed friend request";
							} else if ($row['status'] == 2) {
								echo "Logged in user rejected friend request";
							}
                                        	} else {
                                                        if ($row['status'] == 0) {
                                                                echo "Profile user sent friend request";
                                                        } else if ($row['status'] == 1) {
                                                                echo "Profile user confirmed friend request";
                                                        } else if ($row['status'] == 2) {
                                                                echo "Profile user rejected friend request";
                                                        }
                                        	}
                                	}
				echo '<div id="maincontent">

					</div>';
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
				header("Location: http://www.tencharitychallenge.com/");
			}
		?>
	</body>

<?php
	include_once 'footer.php';
?>
