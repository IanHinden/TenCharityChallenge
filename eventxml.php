<?php


	require('includes/dbh.inc.php');

	// Start XML file, create parent node

	$dom = new DOMDocument("1.0");
	$node = $dom->createElement("events");
	$parnode = $dom->appendChild($node);

	// Select all the rows in the markers table

	$query = "SELECT * FROM events WHERE 1";
	$result = mysqli_query($conn, $query);
	if (!$result) {
  		die('Invalid query: ' . mysql_error());
	}

	header("Content-type: text/xml");

	// Iterate through the rows, adding XML nodes for each

	while ($row = mysqli_fetch_assoc($result)){
 	// Add to XML document node
  	$node = $dom->createElement("event");
  	$newnode = $parnode->appendChild($node);
  	$newnode->setAttribute("event_id",$row['event_id']);
  	$newnode->setAttribute("event_avenue",$row['event_avenue']);
  	$newnode->setAttribute("event_info", $row['event_info']);
  	$newnode->setAttribute("lat", $row['lat']);
  	$newnode->setAttribute("longit", $row['longit']);
  	$newnode->setAttribute("event_user", $row['event_user']);
	$newnode->setAttribute("cause", $row['cause']);
	}

	echo $dom->saveXML();

?>
