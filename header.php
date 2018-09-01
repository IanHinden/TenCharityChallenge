<?php
	session_start();
?>


<!DOCTYPE html>
<html>
<head>
	<title>The Ten Charity Challenge</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<header>
	<nav>
		<div class="main-wrapper">
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="about.php">About</a></li>
				<li><a href="selecting.php">Picking a Charity</a></li>
			</ul>
			<div class="nav-login">
				<form action="includes/login.inc.php" method="POST">
					<input type="text" name="uid" placeholder="Username/email">
					<input type="password" name="pwd" placeholder="Password">
					<button type="submit" name="submit">Login</button>
				</form>
				<a href="signup.php">Sign up</a>
			</div>
		</div>
	</nav>
</header>