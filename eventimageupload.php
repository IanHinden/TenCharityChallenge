<?php

	include_once 'header.php';
        include_once 'includes/dbh.inc.php';
	// This file demonstrates file upload to an S3 bucket. This is for using file upload via a
	// file compared to just having the link. If you are doing it via link, refer to this:
	// https://gist.github.com/keithweaver/08c1ab13b0cc47d0b8528f4bc318b49a
	//
	// You must setup your bucket to have the proper permissions. To learn how to do this
	// refer to:
	// https://github.com/keithweaver/python-aws-s3
	// https://www.youtube.com/watch?v=v33Kl-Kx30o
	
	// I will be using composer to install the needed AWS packages.
	// The PHP SDK:
	// https://github.com/aws/aws-sdk-php
	// https://packagist.org/packages/aws/aws-sdk-php 
	//
	// Run:$ composer require aws/aws-sdk-php
	require 'vendor/autoload.php';
	
	use Aws\S3\S3Client;
	use Aws\S3\Exception\S3Exception;
	// AWS Info

	$bucketName = $s3bucketname;
	$IAM_KEY = 'AKIAYNFZXG2V7RYKEBM6';
	$IAM_SECRET = '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';
	// Connect to AWS
	try {
		// You may need to change the region. It will say in the URL when the bucket is open
		// and on creation.
		$s3 = S3Client::factory(
			array(
				'credentials' => array(
					'key' => $IAM_KEY,
					'secret' => $IAM_SECRET
				),
				'version' => 'latest',
				'region'  => 'us-west-2'
			)
		);

		$buckets = $s3->listBuckets();
	} catch (Exception $e) {
		// We use a die, so if this fails. It stops here. Typically this is a REST call so this would
		// return a json object.
		die("Error: " . $e->getMessage());
	}
	
	// For this, I would generate a unqiue random string for the key name. But you can do whatever.
	//$result = uniqid();
	//$user = $_SESSION['u_id'];
	//$basename = basename($_FILES["fileToUpload"]['name']);
	//$keyName = 'profilepicture/' . $user . '/' . $result . basename($_FILES["fileToUpload"]['name']);
	//$pathInS3 = 'https://s3.us-west-1.amazonaws.com/' . $bucketName . '/' . $keyName;
	// Add it to S3
	$countfiles = count($_FILES['fileToUpload']['name']);
	echo "Here are the counts";
	echo $countfiles;
	print_r($_FILES);
	for($i=0; $i<$countfiles; $i++){
		$result = uniqid();
        	$user = $_SESSION['u_id'];
		$event = $_POST['eventId'];
		$basename = basename($_FILES['fileToUpload']['name'][$i]);
        	$keyName = 'event/' . $event . '/' . $result . basename($_FILES['fileToUpload']['name'][$i]);
        	$pathInS3 = 'https://s3.us-west-1.amazonaws.com/' . $bucketName . '/' . $keyName;

		try {
			// Uploaded:
			$file = $_FILES["fileToUpload"]['tmp_name'][$i];
			$s3->putObject(
				array(
					'Bucket'=>$bucketName,
					'Key' =>  $keyName,
					'SourceFile' => $file,
					'ContentType' => 'image/png',
					'ACL' => 'public-read',
					'StorageClass' => 'STANDARD'
				)
			);
			echo "<br><br><br><br><br>";
			$basename = "'".$basename."'";
			$result = "'".$result."'";

			//$imageClear=mysqli_query($conn, "UPDATE profilepicturelocation SET current=0 WHERE user_id = '$user'");
			$mysql=mysqli_query($conn, "INSERT INTO eventimages (event_id, user_id, uniq_id, image_name) VALUES ($event, $user, $result, $basename)");

		} catch (S3Exception $e) {
			die('Error:' . $e->getMessage());
		} catch (Exception $e) {
			die('Error:' . $e->getMessage());
		}
	}
	echo 'Done';
	// Now that you have it working, I recommend adding some checks on the files.
	// Example: Max size, allowed file types, etc.
?>
