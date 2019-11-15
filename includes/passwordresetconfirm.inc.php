<?php

if (isset($_POST['submit'])) {

        include 'dbh.inc.php';

        $password = $_POST['password'];
        $confirm = $_POST['passwordconfirm'];
	$email = $_POST['email'];
	echo $email;

        //Update the password
	$hashedPwd = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET user_pwd = ? WHERE user_email = ?;";
        $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)){
                        echo "SQL error";
                } else {
                        mysqli_stmt_bind_param($stmt,"ss", $hashedPwd, $email);
                        mysqli_stmt_execute($stmt);
                }

} else {
        header("Location: ../index.php");
        exit();
}
