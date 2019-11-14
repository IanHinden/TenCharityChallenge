<?php
        include_once 'header.php';
	include_once 'includes/dbh.inc.php';
?>

<?php
$selector = $_GET['selector'];
$validator = $_GET['validator'];
$date = date('Y-m-d H:i:s');

echo '<br><br><br><br>';

if(isset($selector)) {

        $dbSelector = "SELECT * FROM passwordreset WHERE selector = '$selector' AND expires > '$date'";
        $result = mysqli_query($conn, $dbSelector);
       	if (mysqli_num_rows($result) > 0) {
        	while ($row = mysqli_fetch_assoc($result)){
                $userEmail = $row['email'];
               	$userSelector = $row['selector'];
                $userToken = bin2hex($row['token']);
        	}

		if ($validator == $userToken && $selector == $userSelector) {
                	echo "Made it here";
		}

        } else {
		echo "Your token has expired. Please request another.";
	}

} else {

echo '<form class="password-reset-form" action="includes/passwordreset.inc.php" method="POST">
	<p>Please enter your e-mail address and submit. Then follow the instructions in the e-mail to reset your password.</p>
        <input type="text" name="email" placeholder="E-mail Address"><br>
	<button type="submit" value="submit" name="submit">Submit</button></form>';
}
?>
