<?php
	session_start();
	include_once 'includes/dbh.inc.php'; 
?>


<!DOCTYPE html>
<html>
<head>
	<title>The Ten Charity Challenge</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="javascript/scripts.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Montserrat|Noto+Serif+JP" rel="stylesheet">
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAJNOBH7XHJ8_L2esp33U5BGxfAwXgH-aE&libraries=places">
</head>
<body>

<header>
	<nav>
		<div class="main-wrapper">
		      <span class="menu-icon">
				<span class="menu-line menu-line-1"></span>
				<span class="menu-line menu-line-2"></span>
				<span class="menu-line menu-line-3"></span>
			</span>
			<div class="navlink">
				<ul>
					<li><a href="index.php">Home</a></li>
					<li><a href="about.php">About</a></li>
					<li><a href="selecting.php">Picking a Charity</a></li>
				</ul>
			</div>
			<div class="nav-login">
				<?php
					if (isset($_SESSION['u_id'])){
						echo '<p id="headergreeting">Hello, ' . $_SESSION['u_first'] . '</p>';
						echo '<form action="includes/logout.inc.php" method="POST">
						<button type="submit" name="submit">Logout</button>
						</form>';
					} else {
						echo '<form action="includes/login.inc.php" method="POST">
						<input type="text" name="uid" placeholder="Username/email">
						<input type="password" name="pwd" placeholder="Password">
						<button type="submit" name="submit">Login</button>
						</form>
						<a href="signup.php">Sign up</a>';
					}
				?>
			</div>
		</div>
	</nav>
</header>
