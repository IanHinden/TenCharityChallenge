<?php

session_start();
if (isset($_POST['aboutme'])) {

        include 'dbh.inc.php';

        $aboutme = $_POST['aboutme'];
	$birthday = $_POST['birthday'];
	$favoritecause = $_POST['favoritecause'];
        $user = $_SESSION['u_id'];

        //Error handlers
        // Check for empty fields
        //Insert the user into the database
        $sql = "INSERT INTO profile (user_id, about_me, birthday, favorite_cause) VALUES (?, ?, ?, ?);";
        $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)){
                        echo "SQL error";
                } else {
			//Remove old profile as default
			$sqlRemoveDefault = "UPDATE profile SET current_profile=0 WHERE user_id='$user';";
			$result = mysqli_query($conn, $sqlRemoveDefault);

                        mysqli_stmt_bind_param($stmt,"ssss", $user, $aboutme, $birthday, $favoritecause);
                        mysqli_stmt_execute($stmt);
                        exit();
                }

} else {
        header("Location: ../index.php");
        exit();
}
