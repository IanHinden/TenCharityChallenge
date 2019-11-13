<?php
        include_once 'header.php';
	include_once 'includes/dbh.inc.php';
?>

<?php
$selector = $_GET['selector'];
$validator = $_GET['validator'];

echo '<br><br><br><br>';

if(isset($selector)) {
	echo "Selector is: " . $selector;
	echo "Token is: " . $validator;

        echo "There is a selector";
        /*$dbSelector = "SELECT * FROM confirmation WHERE selector = '$selector'";
        $result = mysqli_query($conn, $dbSelector);
       	if (mysqli_num_rows($result) > 0) {
        	while ($row = mysqli_fetch_assoc($result)){
                $userEmail = $row['email'];
               	$userSelector = $row['selector'];
                $userToken = bin2hex($row['token']);
                echo "Try " . $userEmail;
                echo "Try also " . $userToken;
        	}
        }
       	if ($validator == $userToken && $selector == $userSelector) {
        	echo "The validator is equal to the token";
                $confirmUser = "UPDATE users SET verified = 'true' WHERE user_email = '$userEmail'";
                mysqli_query($conn, $confirmUser);
        }*/

} else {

echo '<form class="password-reset-form" action="includes/passwordreset.inc.php" method="POST">
	<p>Please enter your e-mail address and submit. Then follow the instructions in the e-mail to reset your password.</p>
        <input type="text" name="email" placeholder="E-mail Address"><br>
	<button type="submit" value="submit" name="submit">Submit</button></form>';
}
?>
