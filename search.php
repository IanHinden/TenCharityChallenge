<?php
	include_once 'header.php';
	include_once 'includes/dbh.inc.php';
?>

<p>This is a search page</p>
<br><br><br><br><br>

<form action="" method="post">
<input type="text" name="search">
<input type="submit" name="submit" value="Search">
</form>

<?php

$current = $_SESSION['u_id'];
echo $current;

$name = $_POST['search'];
$result = mysqli_query($conn, "SELECT * FROM users
    WHERE user_first LIKE '%$name%' OR user_last LIKE '%$name%'");

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
						echo "<img class='searchprofileimage' src='https://gastatic.s3-us-west-1.amazonaws.com/profilepicture/" . $usernumber .  "/". $row['uniq_id']. $row['image_name'] . "'>";
						}
				} else {
					echo "<img class='searchprofileimage' src='uploads/profiledefault.jpg'>";
				}
				echo '</div>';

				/*
				echo '<div id="profilepic">';
					$sqlImg = "SELECT * FROM profileimg WHERE userid = '".$row['user_id']."';";
					$resultImg = mysqli_query($conn, $sqlImg);
					$id = $row['user_id'];
					while ($rowImg = mysqli_fetch_assoc($resultImg)) {
						if ($rowImg['status'] == 0) {
							echo "<img src='uploads/profile".$id.".jpg'>";
						} else {
							echo "<img src='uploads/profiledefault.jpg'>";
						}
				}*/

				
				if ($current < $usernumber){
					$lower = $current;
					$higher = $usernumber;
				} else {
					$lower = $usernumber;
					$higher = $current;
				}

				$sqlRelationship = "SELECT * FROM relationships WHERE user_one_id = '".$lower."' AND user_two_id = '".$higher."';";
                                $resultRelationship = mysqli_query($conn, $sqlRelationship);
                                $rowresults = mysqli_num_rows($resultRelationship);
                                if ($rowresults > 0) {
                                        while ($row = mysqli_fetch_assoc($resultRelationship)){
                                       		echo "There is a relationship here";
					}
                                }

				echo $row['user_first'] . " " . $row['user_last'];
				
				echo '<form action="/addfriend.php" class="addfriend" method="post" />
				<input type="hidden" name="usernumber" value="'. $usernumber.'"/>
				<input id="'.$usernumber.'" type="submit" name="addfriend" value="Add Friend" />
				</form>';
				
				echo "<br>";
		}
	}
    mysqli_close($conn);
?>

<?php
	include_once 'footer.php';
?>
