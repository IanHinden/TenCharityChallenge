<?php
	include_once 'header.php';
?>

<section class="main-container">
	<div class="main-wrapper">
		<h2>Signup</h2>
		<form class="signup-form" action="includes/signup.inc.php" method="POST">
			<input type="text" name="first" placeholder="First name">
			<input type="text" name="last" placeholder="Last name">
			<input type="text" name="email" placeholder="E-mail">
			<input type="text" name="uid" placeholder="User name">
			<input type="password" name="pwd" placeholder="Password">
		<h3>Sign up</h3>
			<!-- <button type="submit" name="submit">Sign up</button> -->
		</form>
	</div>
	<div class="confirm">
		<p>TOS: I will do my best</p>
		<p>Cancel</p>
		<form class="signup-form" action="includes/signup.inc.php" method="POST">
		<p>I agree to the Terms of Service</p>
		<input type="checkbox" name="agree" value="agree">
		<button type="submit" name="submit">Sign up</button>
		</form>
	</div>
</section>
<section>


<?php
	include_once 'footer.php';
?>

