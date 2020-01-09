<?php
session_start();
include_once 'includes/dbh.inc.php';

require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/tmp']);

$sql = "SELECT * FROM events INNER JOIN eventrelationships ON events.event_id = eventrelationships.event_id WHERE user_id = '".$_SESSION['u_id']."' AND completed = 1;";
$result = mysqli_query($conn, $sql);
$totalEvents = mysqli_num_rows($result);

if ($totalEvents > 0) {
	while ($row = mysqli_fetch_assoc($result)) {
        	$mpdf->WriteHTML('<h1>' . $row["event_info"] . '</h1>');
        }
}

$mpdf->Output('VolunteerReport.pdf', 'D');
