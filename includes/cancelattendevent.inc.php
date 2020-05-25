
<?php
        session_start();

        include_once 'header.php';
        include_once 'dbh.inc.php';

        $current = $_SESSION['u_id'];
        $eventid = $_POST['eventid'];

        $mysql=mysqli_query($conn, "UPDATE eventrelationships SET completed = -1 WHERE event_id = $eventid AND user_id = $current");
?>
