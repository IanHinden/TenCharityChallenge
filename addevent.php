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
							<option value="Arts">Arts</option>
							<option value="Assisted Living">Assisted Living</option>
							<option value="Chemical Dependency Services">Chemical Dependency Services</option>
							<option value="Community Development">Community Development</option>
							<option value="Criminal Rehabilitation">Criminal Rehabilitation</option>
							<option value="Crisis Lines">Crisis Lines</option>
							<option value="Services for the Developmentally Challenged">Services for the Developmentally Challenged</option>
	                				<option value="Domestic Abuse and Protective Services">Domestic Abuse and Protective Services</option>
							<option value="Environmental Issues">Environmental Issues</option>
							<option value="Family Counseling">Family Counseling</option>
							<option value="Food Bank">Food Bank</option>
							<option value="Health and Fitness">Health and Fitness</option>
							<option value="Health Care Services">Health Care Services</option>
							<option value="History">History</option>
							<option value="Hospice Services">Hospice Services</option>
							<option value="Juvenile Services">Juvenile Services</option>
							<option value="Literary Services">Literary Services</option>
							<option value="Mental Health Services">Mental Health Services</option>
							<option value="Multicultural Services">Multicultural Services</option>
							<option value="Senior Citizen Services">Senior Citizen Services</option>
							<option value="Vocational Assistance">Vocational Assistance</option>
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
