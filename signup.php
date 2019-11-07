<?php
	include_once 'header.php';
?>

<section class="main-container">
	<div class="main-wrapper">
		<h2>Signup</h2>
		<form class="signup-form" action="includes/signup.inc.php" method="POST" onsubmit="if(document.getElementById('agree').checked) { return true; } else { alert('Please indicate that you have read and agree to the Terms of Service and Privacy Policy'); return false; }">
			<input type="text" name="first" placeholder="First name"><br>
			<input type="text" name="last" placeholder="Last name"><br>
			<input type="text" id="email" name="email" placeholder="E-mail"><br>
			<p id="emailformat">Please enter a valid email address.<p>
			<input type="text" id="username" name="uid" placeholder="User name"><br>
			<p id="specialchars">Your username may not have any special characters.<p>
			<input type="password" name="pwd" placeholder="Password"><br>


		<div class="confirm">
			<div id="tos">
				<span class="tos-close">
					<span class="menu-line-tos menu-line-1-tos"></span>
					<span class="menu-line-tos menu-line-2-tos"></span>
				</span>
			</div>
			<p>Terms of Service</p>
			<p id="terms">I will do my best.</p>
			<input type="checkbox" name="checkbox" value="check" id="agree" />
			<p>I agree to the Terms of Service</p>
			<button type="submit" name="submit" value="submit" />Sign up</button>
			</form>
		</div>
		<div class="opaque"></div>
			<!-- <button type="submit" name="submit" value="submit">Sign up</button></form> -->
				<button id="show-tos" disabled="disabled">Submit</button>
	</div>

</section>


<?php
	include_once 'footer.php';
?>

