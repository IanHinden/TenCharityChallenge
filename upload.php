<?php

if (isset($_POST['photosubmit'])) {
	$file = $_FILES['profilephoto'];
	
	print_r($file);
	$fileName = $_FILES['profilephoto']['name']
}