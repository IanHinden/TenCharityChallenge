<?php
        include_once 'header.php';
        include_once 'includes/dbh.inc.php';
?>
	<body>
	
		<?php

		echo '<div id="passwordresetcontent">
			<div id="confirmationtext">';
			$selector = $_GET['selector'];
			$validator = $_GET['validator'];
			
			if ($selector) {
				$dbSelector = "SELECT * FROM confirmation WHERE selector = '$selector'";
				$result = mysqli_query($conn, $dbSelector);
				if (mysqli_num_rows($result) > 0) {
					while ($row = mysqli_fetch_assoc($result)){
					$userEmail = $row['email'];
					$userSelector = $row['selector'];
					$userToken = bin2hex($row['token']);
					}
				}
				if ($validator == $userToken && $selector == $userSelector) {
					$confirmUser = "UPDATE users SET verified = 'true' WHERE user_email = '$userEmail'";
					mysqli_query($conn, $confirmUser);
					echo "Thank you for confirming your e-mail address.";
				}

			} else {
			  echo "Please check your e-mail to activate your account";
			}
		echo '</div>
			</div>';
		?>
	</body>

<?php
	include_once 'footer.php';
?>
