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
			
		?>
	</body>
</html>
