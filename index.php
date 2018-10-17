<?php
	include_once 'header.php';
	include_once 'includes/dbh.inc.php';
?>

	<?php
		if (isset($_SESSION['u_id'])){
			echo '<form action="includes/addevent.inc.php" method="POST">
			<input type="text" name="avenue" placeholder="Avenue">
			<input type="text" name="info" placeholder="Info">
			<input type="text" name="length" placeholder="Length">
			<button type="submit" name="submit">Create Event</button>
			</form>';
			
			$sql = "SELECT * FROM events WHERE event_user = '".$_SESSION['u_id']."';";
			$result = mysqli_query($conn, $sql);
			$resultCheck = mysqli_num_rows($result);
			
			if ($resultCheck > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
					echo '<p>' . $row['event_avenue'] . '</p><br>';
				}
			}
		} else {
			echo '<section class="main-container">
					<div class="main-container-text">
						<h2>Welcome to the Ten Charity Challenge </h2>
						<h3>Can you volunteer? Ten times in one year?</h3>
			</div>
			</section>';
		?>
	</div>
</section>';
		}
	?>
<div id="main-about">
	<section id="intro">
		<div class="desc">
			<h2>Can you volunteer? Ten times in one year?</h2>
			<h3>At the Ten Charity Challenge, we have just one question: can you successfully volunteer ten times in a year? To win, all you need to do serve at a soup kitchen once a month. Or pack lunches for homeless teens. Or drive pets to the vet for veterans...</h3>
		</div>
	</section>
	<section id="purposeid">
		<div class="purpose">	
			<div class="purpose-child-two">
				<h2>What is this site?</h2>
				<h3>The purpose of this website is to give you a space to keep track of your volunteer events. This site is not a necessary part of the challenge. In fact, everything site does can be replicated with a pencil and paper. But if you want a place to keep track, leave notes and photos, and share events to involve your friends, we're here for you.</h3>
			</div>
			<div class="purpose-child">
				<img src="images/download.jpg" alt="Purpose">
			</div>
		</div>
	</section>
	<div class="mobile-signup"><a href="signup.php">SIGN UP</a></div>
</div>

<?php
	include_once 'footer.php';
?>