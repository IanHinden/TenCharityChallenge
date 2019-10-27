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

				//Retreive user details
				$sql = "SELECT * FROM profile WHERE current_profile = 1 AND user_id = '".$_SESSION['u_id']."';";
                        	$result = mysqli_query($conn, $sql);
				$resultCheck = mysqli_num_rows($result);

				echo '<br><br><br><br><br>';

				for ($set = array (); $row = mysqli_fetch_assoc($result); $set[] = $row);
                                foreach ($set as $item){
                                        $aboutMeText = $item['about_me'];
                                }
				echo $aboutMeText;
				echo '<form action="includes/aboutme.inc.php" method="post">
				About Me: <input type="text" value="'.$aboutMeText.'" name="aboutme" id="aboutme" readonly="readonly"><br>
				<p id="editaboutme">Edit</p>
				<input type="submit">
				</form>';
			} else {
				echo "No one is logged in";
			}
                ?>
        </body>
</html>

