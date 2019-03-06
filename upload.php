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
	$fileActualExtension = strtolower(end($fileExt));
}
