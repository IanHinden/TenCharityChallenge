<?php
	include_once 'header.php';
	include_once 'includes/dbh.inc.php';

if (isset($_SESSION['u_id'])){

	echo '<div id="searchpagecontent">
	<form id="searchform" action="" method="post">
	<input type="text" name="search">
	<input type="submit" name="submit" value="Search">
	</form>';


	$current = $_SESSION['u_id'];

	$name = $_POST['search'];
	$names = explode(" ", $name);

	if(strpos($name, ' ') !== false) {
		$result = mysqli_query($conn, "SELECT * FROM users WHERE user_id <> '$current' AND (user_first LIKE '%$names[0]%' OR user_last LIKE '%$names[1]')");
	} else {
		$result = mysqli_query($conn, "SELECT * FROM users WHERE user_id <> '$current' AND (user_first LIKE '%$name%' OR user_last LIKE '%$name%')");
	}
	if ($name !=""){
		while ($row = mysqli_fetch_array($result)){
				$usernumber = $row['user_id'];
				$userfirst = $row['user_first'];
				$userlast = $row['user_last'];

				//Profile Image
				echo '<div class="searchresult"><div class="searchprofilepic">';
				$sqlImg = "SELECT * FROM profilepicturelocation WHERE user_id = '".$row['user_id']."' AND current = 1;";
				$resultImg = mysqli_query($conn, $sqlImg);
				$rowresults = mysqli_num_rows($resultImg);
				if ($rowresults > 0) {
					while ($row = mysqli_fetch_assoc($resultImg)){
						echo "<a href='https://www.tencharitychallenge.com/user/".$usernumber."'><img class='searchprofileimage' src='https://tencharity.s3-us-west-2.amazonaws.com/profilepicture/" . $usernumber .  "/". $row['uniq_id']. $row['image_name'] . "'></a>";
					}
				} else {
					echo "<a href='https://www.tencharitychallenge.com/user/".$usernumber."'><img class='searchprofileimage' src='uploads/profiledefault.jpg'></a>";
				}
				echo '</div>';
				echo '<div>';
				echo '<a href="https://www.tencharitychallenge.com/user/'.$usernumber.'">'.$userfirst.' '.$userlast.'</a>';
				echo '</div>';

				echo '<form action="/addfriend.php" class="addfriend" id="add'. $usernumber.'" method="post" />
				<input type="hidden" name="usernumber" value="'. $usernumber.'"/>
				<input id="'.$usernumber.'" type="submit" name="addfriend" value="Add Friend" />
				</form>';

				echo '<input id="sent'. $usernumber.'" type="submit" value="Friend Request Submitted" disabled="true" />';
				
				echo '<div id="acceptreject'. $usernumber.'">' .

					'<form action="/confirmfriend.php" class="confirmfriend" method="post" />
					<input type="hidden" name="userid" value="'. $usernumber.'"/>
                                        <input id="'.$usernumber.'" type="submit" name="confirmfriend" value="Confirm Friend" />
                                        </form></li>' .

					'<form action="/rejectfriend.php" class="rejectfriend" method="post" />
                                        <input type="hidden" name="userid" value="'. $usernumber.'"/>
					<input id="'.$usernumber.'" type="submit" name="rejectfriend" value="Reject Friend" />
                                         </form></li></div>';

				echo '<input id="remove'. $usernumber.'" type="submit" value="Remove Friend" />';
				echo '</div>';

				if ($current < $usernumber){
                                        $lower = $current;
                                        $higher = $usernumber;
                                } else {
                                        $lower = $usernumber;
                                        $higher = $current;                                                                                                                                                 }

                                $sqlRelationship = "SELECT * FROM relationships WHERE user_one_id = '".$lower."' AND user_two_id = '".$higher."';";
				$resultRelationship = mysqli_query($conn, $sqlRelationship);
                                $rowresults = mysqli_num_rows($resultRelationship);
                                if ($rowresults > 0) {
                                        while ($row = mysqli_fetch_assoc($resultRelationship)){
                                                $currentUserRequested = true;

						if($row['action_user_id'] != $current){
							$currentUserRequested = false;
						}

                                                echo '<script type="text/javascript">',
                                                        'properButton('. $usernumber. ', '. $row['status'].', '. json_encode($currentUserRequested) .');',
                                                '</script>';
                                        }
                                } else {
					echo '<script type="text/javascript">',
                                        	'properButton('. $usernumber. ', -1, false);',
                                        '</script>';
				}

				echo "<br>";
			}
		}
    	mysqli_close($conn);
	echo '</div>';
} else {
	header("Location: http://www.tencharitychallenge.com/");
}
?>

<?php
	include_once 'footer.php';
?>
