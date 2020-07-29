<?php

include_once '../header2.php';
include_once 'dbh.inc.php';


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
    'key' => 'AKIAYNFZXG2V7RYKEBM6',
    'secret' => 'Em5PiduQ4YW1K0LbmwBuye4jS+S9gZp+Xxayhkq1'
    ),
]);

// Replace sender@example.com with your "From" address.
// This address must be verified with Amazon SES.
$sender_email = 'donotreply@tencharitychallenge.com';

// Replace these sample addresses with the addresses of your recipients. If
// your account is still in the sandbox, these addresses must be verified.
//$recipient_emails = ['ian.hinden@gmail.com'];

// Specify a configuration set. If you do not want to use a configuration
// set, comment the following variable, and the
// 'ConfigurationSetName' => $configuration_set argument below.
$configuration_set = 'ConfigSet';

$email = $_POST['email'];
$recipient_emails = [$email];

//Create Signup token
$selector = bin2hex(random_bytes(8));
$token = random_bytes(32);

$expire = date("Y-m-d H:i:s", strtotime("+1 hours"));

//Remove other instances of password reset reuests
$deleteSQL = "DELETE FROM passwordreset WHERE email = '$email'";
$deletequery = mysqli_query($conn, $deleteSQL);

//Insert info into database
$passwordresetSQL = "INSERT INTO passwordreset (email, selector, token, expires) VALUES (?, ?, ?, ?);";
$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $passwordresetSQL)){
	echo "SQL error";
} else {
	mysqli_stmt_bind_param($stmt,"ssss", $email, $selector, $token, $expire);
	mysqli_stmt_execute($stmt);
}

$url = sprintf('%spasswordreset.php?%s', 'https://www.tencharitychallenge.com/', http_build_query([
	'selector' => $selector,
        'validator' => bin2hex($token)
]));

$subject = 'Instructions to Reset Password';
$plaintext_body = 'Here is the email you requested to reset your password. If you did not request this, please ignore this e-mail.' ;
$html_body =  '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
 			<head>
  				<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  					<title>Demystifying Email Design</title>
  				<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
			</head>
		</html>

		<body style="margin: 0; padding: 0;">
 			<table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse; border: 1px solid #cccccc;">
 				<tr>
  					<td align="center" bgcolor="#665882" style="padding: 40px 0 30px 0;">
						<img src="https://tencharity.s3-us-west-2.amazonaws.com/images/logos/10CC.png" alt="Creating Email Magic" width="300" height="230" style="display: block;" />
  					</td>
 				</tr>
 				<tr>
  					<td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
 						<table border="0" cellpadding="0" cellspacing="0" width="100%">
  							<tr>
   								<td style="color: #3E3076; font-family: Arial, sans-serif; font-size: 24px;">
    									Welcome to the Ten Charity Challenge!
   								</td>
  							</tr>
  							<tr>
   								<td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
    									To reset your password, please click the link below:<br/>
									<a href='.$url.'>
										RESET YOUR PASSWORD
									<a><br/>
									If you did not request to reset your password, please ignore this e-mail. 
   								</td>
  							</tr>
  							<tr>
   								<td>
									<table border="0" cellpadding="0" cellspacing="0" width="100%">
										<tr>
											<td width="260" valign="top">
												<table border="0" cellpadding="0" cellspacing="0" width="100%">
													<tr>
														<td>
															<img src="https://crescentcove.org/cms-files/size-992x992/img-5500.k.jpg" alt="Friends volunteering" width="100%" height="140" style="display: block;" />
														</td>
													</tr>
													<tr>
														<td style="padding: 25px 0 0 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
															Your password must be longer than six characters and contain one numeric digit, an uppercase letter, and a lowercase letter.
														</td>
													</tr>
												</table>
											</td>
											<td style="font-size: 0; line-height: 0;" width="20">
												&nbsp;
											</td>
											<td width="260" valign="top">
												<table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td>
                                                            <img src="https://crescentcove.org/cms-files/size-992x992/img-5500.k.jpg" alt="" width="100%" height="140" style="display: block;" />
														</td>
													</tr>
                                                    <tr>
														<td style="padding: 25px 0 0 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
															Remember: No one from the Ten Charity Challenge will ever ask you for your password. 
														</td>
                                                    </tr>
                                                </table>
											</td>
										</tr>
									</table>
   								</td>
  							</tr>
 						</table>
					</td>
 				</tr>
 				<tr>
  					<td bgcolor="#DAD6EA" style="padding: 30px 30px 30px 30px;">
   						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td width="75%" style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;">
									&reg; Ten Charity Challenge 2020<br/>
									We will be the best that we can be
								</td>
								<td align="right">
									<table border="0" cellpadding="0" cellspacing="0">
										<tr>
											<td>
												<a href="https:www.twitter.com/orphanshow">
													<img src="https://toppng.com/uploads/preview/red-twitter-logo-11549680466ua0eyzyb5c.png" alt="Twitter" width="38" height="38" style="display: block;" border="0" />
												</a>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
  					</td>
 				</tr>
			</table>
		</body>';
$char_set = 'UTF-8';

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
	]);
	$messageId = $emailResult['MessageId'];
	echo '<div id="passwordresetcontent">';
	echo '<div id="instructions">You have been sent an e-mail with instructions to reset your password. Please follow the instructions to access your account.</div>';
	echo '</div>';
	} catch (AwsException $e) {
   	// output error message if fails
		echo $e->getMessage();
		echo("The email was not sent. Error message: ".$e->getAwsErrorMessage()."\n");
		echo "\n";
	}
} else {
	header("Location: ../signup.php");
	exit();
}
