<?php
        include_once 'header.php';
        include_once 'includes/dbh.inc.php';
?>

<?php
	if (isset($_SESSION['u_id'])){
		echo '<div id="addeventcontent">
				<div id="formandmap">
					<p id="addEventLabel">Add Event</p>
					<div id="addeventform"><form action="includes/addevent.inc.php" method="POST">
						<input id="search" type="text" name="avenue" placeholder="Search...">
						<input type="text" name="info" placeholder="Info">
						<input type="text" name="length" placeholder="Length">
						<input type="datetime-local" name="datetime-local">
	        				<select name="cause">
	        					<option value="Animals">Animals</option>
	                				<option value="Food Bank">Food Bank</option>
							<option value="Other">Other</option>
						</select>
						<input type="hidden" id="lat" name="lat" step="any">
						<input type="hidden" id="long" name="long" step="any">
	        				<div id="map"></div>
	        				<button type="submit" name="submit">Create Event</button>
					</div></form>
				</div>
			</div>';
	} else {
		header("Location: ../index.php");
	}
?>

<?php
	include_once 'footer.php';
?>
