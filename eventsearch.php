<?php
	include_once 'header.php';
	include_once 'includes/dbh.inc.php';
?>


<div id="searcheventcontent">
	<div id="formandmap">
		<p id="searchEventLabel">Search Events</p>
		<select id="eventdistance">
			<option value="10">10</option>
	        	<option value="8">8</option>
	        	<option value="6">6</option>
	        	<option value="4">4</option>
		</select>
		<input type="date" id="fromDate" name="fromDate"></input>
		<input type="date" id="toDate" name="toDate"></input>
		<select id="cause">
			<option value="All">All</option>
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
		<input id="refreshMap" type="button" value="Search" onclick="initMap();" />

<?php

	echo '<div id="searchmap"></div>';

?>
	</div>
</div>
<div id="eventdetailssection">
	<div id="searcheventdetails">
	</div>
</div>

<?php
	include_once 'footer.php';
?>
