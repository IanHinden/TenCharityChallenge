<?php
	include_once 'header.php';
	include_once 'includes/dbh.inc.php';
?>


<br><br><br><br>
<br><br><br><br><br><br>
<input id="refreshMap" type="button" value="Search" onclick="initMap();" />


<?php

	echo '<div id="searchmap"></div>';

?>


<?php
	include_once 'footer.php';
?>
