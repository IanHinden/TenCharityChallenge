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
    'key' => 'AKIAYNFZXG2V7RYKEBM6',
    'secret' => 'Em5PiduQ4YW1K0LbmwBuye4jS+S9gZp+Xxayhkq1'
    ),
]);

// Replace sender@example.com with your "From" address.
// This address must be verified with Amazon SES.
$sender_email = 'donotreply@tencharitychallenge.com';

// Specify a configuration set. If you do not want to use a configuration
// set, comment the following variable, and the
// 'ConfigurationSetName' => $configuration_set argument below.
$configuration_set = 'ConfigSet';

	$first = $_POST['first'];
	$last = $_POST['last'];
	$email = $_POST['email'];
	$uid = $_POST['uid'];
	$pwd = $_POST['pwd'];


// Replace these sample addresses with the addresses of your recipients. If
// your account is still in the sandbox, these addresses must be verified.
$recipient_emails = [$email];

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
						
						/*
						$sqlUser = "SELECT * FROM users WHERE user_uid = '$uid'";
						$result = mysqli_query($conn, $sqlUser);
						if (mysqli_num_rows($result) > 0) {
							while ($row = mysqli_fetch_assoc($result)){
								$userIdNo = $row['user_id'];
								$sqlImg = "INSERT INTO profileimg (userid, status) VALUES ('$userIdNo', 1);";
								mysqli_query($conn, $sqlImg);
							}
						}
						*/

						//Create Signup token
                                                $selector = bin2hex(random_bytes(8));
                                                $token = random_bytes(32);

						//Insert selector and token into database
						$confirmSQL = "INSERT INTO confirmation (email, selector, token) VALUES ('$email', '$selector', '$token');";
						mysqli_query($conn, $confirmSQL);


                                                $url = sprintf('%sconfirm.php?%s', 'https://' . $baseurl . '/', http_build_query([
                                                        'selector' => $selector,
                                                        'validator' => bin2hex($token)
                                                ]));


						$subject = 'Welcome to the Ten Charity Challenge!';
						$plaintext_body = 'Please confirm your e-mail address to receive updates and reminders.' ;
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
    									To verify that you signed up for an account, please click the link below.<br/>
									<a href='.$url.'>
										VERIFY YOUR ACCOUNT
									<a><br/>
									If you did not sign up for an account, you can ignore this e-mail. 
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
															Find your friends to easily invite them to volunteer events and see where they are volunteering.
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
																Create volunteer events or join others to track your volunteer hours. 
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
												<a href="https://www.twitter.com/orphanshow">
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


						//Send welcome e-mail
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
						    echo("Email sent! Message ID: $messageId"."\n");
							} catch (AwsException $e) {
   								 // output error message if fails
							    echo $e->getMessage();
							    echo("The email was not sent. Error message: ".$e->getAwsErrorMessage()."\n");
							    echo "\n";
							}




						header("Location: ../index.php?signup=success");
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
