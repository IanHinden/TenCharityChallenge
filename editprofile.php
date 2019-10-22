<?php
        include_once 'header.php';
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
			if (isset($_SESSION['u_id'])){
                        	$id = $_SESSION['u_id'];

                        	echo "User ID is: " . $id;
			} else {
				echo "No one is logged in";
			}
                ?>
        </body>
</html>

