<?php
	include_once 'header.php';
	include_once 'includes/dbh.inc.php';
?>


<br><br><br><br>
<br><br><br><br><br><br>
<select id="eventdistance">
	<option value="1">1</option>
        <option value="5">5</option>
        <option value="10">10</option>
        <option value="20">20</option>
</select>
<select id="cause">
	<option value="All">All</option>
	<option value="Animals">Animals</option>
	<option value="Food Bank">Food Bank</option>
</select>
<input id="refreshMap" type="button" value="Search" onclick="initMap();" />


<?php

	echo '<div id="searchmap"></div>';

?>


<?php
	include_once 'footer.php';
?>
