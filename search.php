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
				
				echo $row['user_first'] . " " . $row['user_last'];
				
				echo '<form action="/addfriend.php" class="addfriend" method="post" />
				<input type="hidden" name="usernumber" value=" '. $usernumber.'"/>
				<input type="submit" name="addfriend" value="Add Friend" />
				</form>';
				
				echo "<br>";
		}
	}
    mysqli_close($conn);
?>

<?php
	include_once 'footer.php';
?>
