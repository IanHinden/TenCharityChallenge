<?php

session_start();
if (isset($_POST['aboutme'])) {

        include 'dbh.inc.php';

        $aboutme = $_POST['aboutme'];
        $user = $_SESSION['u_id'];

        //Error handlers
        // Check for empty fields
        //Insert the user into the database
        $sql = "INSERT INTO profile (user_id, about_me) VALUES (?, ?);";
        $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)){
                        echo "SQL error";
                } else {
                        mysqli_stmt_bind_param($stmt,"ss", $user, $aboutme);
                        mysqli_stmt_execute($stmt);
                        exit();
                }

} else {
        header("Location: ../index.php");
        exit();
}
