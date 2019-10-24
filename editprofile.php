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

				echo '<br><br><br><br>';
                        	echo "User ID is: " . $id;

				echo '<form action="aboutme.php" method="post">
				About Me: <input type="text" name="aboutme" id="aboutme" readonly="readonly"><br>
				<p id="editaboutme">Edit</p>
				<input type="submit">
				</form>';
			} else {
				echo "No one is logged in";
			}
                ?>
        </body>
</html>

