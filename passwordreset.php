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
} else {

echo '<form class="password-reset-form" action="includes/passwordreset.inc.php" method="POST">
	<p>Please enter your e-mail address and submit. Then follow the instructions in the e-mail to reset your password.</p>
        <input type="text" name="email" placeholder="E-mail Address"><br>
	<button type="submit" value="submit" name="submit">Submit</button></form>';
}
?>
