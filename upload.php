<?php

if (isset($_POST['photosubmit'])) {
	$file = $_FILES['profilephoto'];
	
	print_r($file);
	$fileName = $_FILES['profilephoto']['name'];
	$fileTmpName = $_FILES['profilephoto']['tmp_name'];
	$fileSize = $_FILES['profilephoto']['size'];
	$fileError = $_FILES['profilephoto']['error'];
	$fileName = $_FILES['profilephoto']['type'];
	
	$fileExt = explode('.', $fileName);
	$fileActualExt = strtolower(end($fileExt));
	
	$allowed = array('jpg', 'jpeg', 'png', 'pdf');
	
	if (in_array($fileActialExt, $allowed)) {
		if ($fileError === 0) {
			if ($fileSize < 1000000) {
				$fileNameNew = uniqid('', true). "." . $fileActualExt;
				$fileDestination = 'uploads/'. $fileNameNew;
				move_uploaded_file($fileTmpName, $fileDestination);
				header("Location: index.php?uploadsuccess");
			} else {
				echo "The file you are uploading is too large";
			}
		} else {
			echo "There was an error uploading your file";
		}
	} else {
		echo "You cannot upload files of this type";
	}
}