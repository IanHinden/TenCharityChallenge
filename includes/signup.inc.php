<?php

require '../vendor/autoload.php';

use Aws\Ses\SesClient;
use Aws\Exception\AwsException;

if (isset($_POST['submit'])) {
	
	include 'dbh.inc.php';
	
	$SesClient = new SesClient([
    //'profile' => 'default',
    'version' => '2010-12-01',
    'region'  => 'us-west-2',
    'credentials' => array(
    'key' => 'AKIAYNFZXG2V2CHGDZFW',
    'secret' => 'FwPiTkTKKiHEGENmSSVojwzpyZ9gPsamNEhqfHB1'
    ),
]);

// Replace sender@example.com with your "From" address.
// This address must be verified with Amazon SES.
$sender_email = 'donotreply@tencharitychallenge.com';

// Replace these sample addresses with the addresses of your recipients. If
// your account is still in the sandbox, these addresses must be verified.
$recipient_emails = ['ian.hinden@gmail.com'];

// Specify a configuration set. If you do not want to use a configuration
// set, comment the following variable, and the
// 'ConfigurationSetName' => $configuration_set argument below.
$configuration_set = 'ConfigSet';

$subject = 'Amazon SES test (AWS SDK for PHP)';
$plaintext_body = 'This email was sent with Amazon SES using the AWS SDK for PHP.' ;
$html_body =  '<h1>AWS Amazon Simple Email Service Test Email</h1>'.
              '<p>This email was sent with <a href="https://aws.amazon.com/ses/">'.
              'Amazon SES</a> using the <a href="https://aws.amazon.com/sdk-for-php/">'.
              'AWS SDK for PHP</a>.</p>';
$char_set = 'UTF-8';

	$first = $_POST['first'];
	$last = $_POST['last'];
	$email = $_POST['email'];
	$uid = $_POST['uid'];
	$pwd = $_POST['pwd'];
	
	//Error handlers
	// Check for empty fields
	if (empty($first)|| empty($last)|| empty($email)|| empty($uid) || empty($pwd)){
		header("Location: ../signup.php?signup=empty");
		exit();
	} else {
		//Check if input characters are valid
		if(!preg_match("/^[a-zA-Z]*$/", $first) || !preg_match("/^[a-zA-Z]*$/", $last)) {
			header("Location: ../signup.php?signup=invalid");
			exit();
		} else {
			//Check if email is valid
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				header("Location: ../signup.php?signup=email");
				exit();
			} else {
				$sql = "SELECT * FROM users WHERE user_uid = '$uid'";
				$result = mysqli_query($conn, $sql);
				$resultCheck = mysqli_num_rows($result);
				
				if ($resultCheck > 0) {
					header("Location: ../signup.php?signup=usertaken");
					exit();
				} else {
					//Hashing the password
					$hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
					//Insert the user into the database
					$sql = "INSERT INTO users (user_first, user_last, user_email, user_uid, user_pwd) VALUES (?, ?, ?, ?, ?);";
					$stmt = mysqli_stmt_init($conn);
					if (!mysqli_stmt_prepare($stmt, $sql)){
						echo "SQL error";
					} else {
						mysqli_stmt_bind_param($stmt,"sssss", $first, $last, $email, $uid, $hashedPwd);
						mysqli_stmt_execute($stmt);
						
						$sqlUser = "SELECT * FROM users WHERE user_uid = '$uid'";
						$result = mysqli_query($conn, $sqlUser);
						if (mysqli_num_rows($result) > 0) {
							while ($row = mysqli_fetch_assoc($result)){
								$userIdNo = $row['user_id'];
								$sqlImg = "INSERT INTO profileimg (userid, status) VALUES ('$userIdNo', 1);";
								mysqli_query($conn, $sqlImg);
							}
						}

try {
    $emailResult = $SesClient->sendEmail([
        'Destination' => [
            'ToAddresses' => $recipient_emails,
        ],
        'ReplyToAddresses' => [$sender_email],
        'Source' => $sender_email,
        'Message' => [
          'Body' => [
              'Html' => [
                  'Charset' => $char_set,
                  'Data' => $html_body,
              ],
              'Text' => [
                  'Charset' => $char_set,
                  'Data' => $plaintext_body,
              ],
          ],
          'Subject' => [
              'Charset' => $char_set,
              'Data' => $subject,
          ],
        ],
        // If you aren't using a configuration set, comment or delete the
        // following line
        //'ConfigurationSetName' => $configuration_set,
    ]);
    $messageId = $emailResult['MessageId'];
    echo("Email sent! Message ID: $messageId"."\n");
} catch (AwsException $e) {
    // output error message if fails
    echo $e->getMessage();
    echo("The email was not sent. Error message: ".$e->getAwsErrorMessage()."\n");
    echo "\n";
}




						header("Location: ../signup.php?signup=success");
						exit();
					}
				}
			}
		}
	}
	
} else {
	header("Location: ../signup.php");
	exit();
}
