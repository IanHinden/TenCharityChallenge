<?php
	include_once 'header.php';
	include_once 'includes/dbh.inc.php';

if (isset($_SESSION['u_id'])){

	echo '<p>This is a search page</p>
	<br><br><br><br><br>

	<form action="" method="post">
	<input type="text" name="search">
	<input type="submit" name="submit" value="Search">
	</form>';


	$current = $_SESSION['u_id'];

	$name = $_POST['search'];
	$names = explode(" ", $name);

	if(strpos($name, ' ') !== false) {
		$result = mysqli_query($conn, "SELECT * FROM users WHERE user_first LIKE '%$names[0]%' OR user_last LIKE '%$names[1]'");
	} else {
		$result = mysqli_query($conn, "SELECT * FROM users WHERE user_first LIKE '%$name%' OR user_last LIKE '%$name%'");
	}
	if ($name !=""){
		while ($row = mysqli_fetch_array($result)){
				$usernumber = $row['user_id'];
				echo $usernumber;

				//Profile Image
				echo '<div class="searchprofilepic">';
				$sqlImg = "SELECT * FROM profilepicturelocation WHERE user_id = '".$row['user_id']."' AND current = 1;";
				$resultImg = mysqli_query($conn, $sqlImg);
				$rowresults = mysqli_num_rows($resultImg);
				if ($rowresults > 0) {
					while ($row = mysqli_fetch_assoc($resultImg)){
						echo "<img class='searchprofileimage' src='https://tencharity.s3-us-west-2.amazonaws.com/profilepicture/" . $usernumber .  "/". $row['uniq_id']. $row['image_name'] . "'>";
						}
				} else {
					echo "<img class='searchprofileimage' src='uploads/profiledefault.jpg'>";
				}
				echo '</div>';

				echo $row['user_first'] . " " . $row['user_last'];
				
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
} else {
	header("Location: http://www.tencharitychallenge.com/");
}
?>

<?php
	include_once 'footer.php';
?>
