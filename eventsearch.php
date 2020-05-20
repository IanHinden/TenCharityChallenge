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
			<option value="Animals">Animals</option>
			<option value="Food Bank">Food Bank</option>
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
