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
				$status = null;
				$currentUserRequested = null;

				if ($resultCheck > 0) {
                                	while ($row = mysqli_fetch_assoc($result)) {
						$status = $row['status'];
                                        	if ($row['action_user_id'] == $userId ) {
							$currentUserRequested = true;
							if ($row['status'] == 0) {
								$status = 0;
								echo "Logged in user sent friend request";
							} else if ($row['status'] == 1) {
								$status = 1;
								echo "Logged in user confirmed friend request";
							} else if ($row['status'] == 2) {
								$status = 2;
								echo "Logged in user rejected friend request";
							}
                                        	} else {
							$currentUserRequested = false;
                                                        if ($row['status'] == 0) {
								$status = 0;
                                                                echo "Profile user sent friend request";
                                                        } else if ($row['status'] == 1) {
								$status = 1;
                                                                echo "Profile user confirmed friend request";
                                                        } else if ($row['status'] == 2) {
								$status = 2;
                                                                echo "Profile user rejected friend request";
                                                        }
                                        	}
                                	}
                        	} else {
					$status = -1;
                                	echo "These users have no relationships";
                        	}

                        }

			if (isset($_SESSION['u_id'])) {
				echo '<div id="maincontent">';
				echo '<div id="dashboard">
					<div id="dashboardcontent">
						<div id="profilepic">';
							$sqlImg = "SELECT * FROM profilepicturelocation WHERE user_id = '".$profileId."' AND current = 1;";
							$resultImg = mysqli_query($conn, $sqlImg);
							$id = $_SESSION['u_id'];
							$rowresults = mysqli_num_rows($resultImg);
							if ($rowresults > 0) {
								while ($row = mysqli_fetch_assoc($resultImg)){
									//echo "<img id='profileimage' src='https://gastatic.s3-us-west-1.amazonaws.com/profilepicture/" . $id .  "/". $row['uniq_id']. $row['image_name'] . "'>";
									echo "<img id='profileimage' src='https://tencharity.s3-us-west-2.amazonaws.com/profilepicture/" . $profileId . "/". $row['uniq_id']. $row['image_name'] . "'>";
								}
							} else {
								echo "<img id='profileimage' src='../uploads/profiledefault.jpg'>";
							}
							echo '</div>';

						        $sql = "SELECT * FROM users WHERE user_id = '".$profileId."';";
							$result = mysqli_query($conn, $sql);
                        				$resultCheck = mysqli_num_rows($result);
							while ($row = mysqli_fetch_assoc($result)) {
								echo '<div id="fullname">';
								echo $row['user_first'] . " " . $row['user_last'];
								echo '</div>';
							}
							
							if($profileId != $userId){
								echo '<div id="requestbox">';
									echo '<form action="/addfriend.php" class="addfriend" id="add'. $usernumber.'" method="post" />
                                					<input type="hidden" name="usernumber" value="'. $profileId.'"/>
                                					<input id="add'.$profileId.'" type="submit" name="addfriend" value="Add Friend" />
                                					</form>';

                                					echo '<input id="sent'. $profileId.'" type="submit" value="Friend Request Submitted" disabled="true" />';

                                					echo '<div id="acceptreject'. $profileId.'">' .

                                        				'<form action="/confirmfriend.php" class="confirmfriend" method="post" />
                                        				<input type="hidden" name="userid" value="'. $profileId.'"/>
                                        				<input id="'.$profileId.'" type="submit" name="confirmfriend" value="Confirm Friend" />
                                        				</form></li>' .

                                        				'<form action="/rejectfriend.php" class="rejectfriend" method="post" />
                                        				<input type="hidden" name="userid" value="'. $profileId.'"/>
                                        				<input id="'.$profileId.'" type="submit" name="rejectfriend" value="Reject Friend" />
                                         				</form></li></div>';

                                					echo '<input id="remove'. $profileId.'" type="submit" value="Remove Friend" />';
								echo '</div>';
							

								echo '<script type="text/javascript">',
                                                        		'properButton('. $profileId. ', '. $status.', '. json_encode($currentUserRequested) .');',
                                                		'</script>';
							}

						echo '<div id="scores">
							<div id="volunteerscorespace"><div id="volunteerscore" class="scorecard"><p>Volunteer Hours:<p>';
			
							$sql = "SELECT event_length FROM events WHERE event_user = '".$profileId."';";
							$result = mysqli_query($conn, $sql);
							$resultCheck = mysqli_num_rows($result);
							$userTotalHours = 0;
			
							if ($resultCheck > 0) {
								while ($row = mysqli_fetch_assoc($result)) {
									$userTotalHours = $userTotalHours + $row['event_length'];
								}
							}
			
							echo $userTotalHours . '</p>
							</p>
							</div>
						</div>
						<div id="inspirationscorespace"><div id="inspirationscore" class="scorecard"><p>Inspiration Score:</p>'; /*<p>Insert Number Here</p>*/

						$sql = "SELECT * FROM events INNER JOIN eventrelationships ON events.event_id = eventrelationships.event_id WHERE event_user = '".$profileId."' AND user_id <> '".$profileId."' AND completed = 1;";
						$result = mysqli_query($conn, $sql);
						$totalEvents = mysqli_num_rows($result);
						$inspirationScore = 0;
			
						if ($totalEvents > 0) {
							while ($row = mysqli_fetch_assoc($result)) {
								$inspirationScore = $inspirationScore + $row['event_length'];
							}
						}

						echo '<span class="inspirationcount">' . $inspirationScore . '</span>';
						echo '</div>
					</div>
				</div>
			</div>
		</div>
	</div>';
				echo '</div>';
			} else {
-                               header("Location: http://www.tencharitychallenge.com/");
			}
		?>
	</body>

<?php
	include_once 'footer.php';
?>
