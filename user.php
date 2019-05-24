<?php
	include_once 'includes/dbh.inc.php';
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
			$userId = $_GET['id'];
			
			echo "User ID is: " . $userId;
			
			$sql = "SELECT * FROM users WHERE user_id = '".$userId."';";
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