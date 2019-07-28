<?php
	include_once 'includes/dbh.inc.php';
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="description" content="Confirmation page">
		<meta name=viewport content="width=device-width, initial-scale=1">
		<title>Profile Page</title>
	</head>
	<body>
	
		<?php
			$selector = $_GET['selector'];
			$validator = $_GET['validator'];
			
			echo "Selector is: " . $selector;
			echo "Token is: " . $validator;

			if ($selector) {
				echo "There is a selector";
				$dbSelector = "SELECT * FROM confirmation WHERE selector = '$selector'";
				$result = mysqli_query($conn, $dbSelector);
				if (mysqli_num_rows($result) > 0) {
					while ($row = mysqli_fetch_assoc($result)){
					$userEmail = $row['email'];
					$userToken = bin2hex($row['token']);
					echo "Try " . $userEmail;
					echo "Try also " . $userToken;
					}
				}
			} else {
			  echo "Please check your e-mail to activate your account";
			}
			
		?>
	</body>
</html>
