<?php

// If necessary, modify the path in the require statement below to refer to the 
// location of your Composer autoload.php file.
require 'vendor/autoload.php';

use Aws\Ses\SesClient;
use Aws\Exception\AwsException;

// Create an SesClient. Change the value of the region parameter if you're 
// using an AWS Region other than US West (Oregon). Change the value of the
// profile parameter if you want to use a profile in your credentials file
// other than the default.
$SesClient = new SesClient([
    'profile' => 'default2',
    'version' => '2010-12-01',
    'region'  => 'us-west-2'
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
$html_body =  '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
 			<head>
  				<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  					<title>Demystifying Email Design</title>
  				<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
			</head>
		</html>

		<body style="margin: 0; padding: 0;">
 			<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
 				<tr>
  					<td align="center" bgcolor="#665882" style="padding: 40px 0 30px 0;">
						<img src="https://tencharity.s3-us-west-2.amazonaws.com/images/logos/10CC.png" alt="Creating Email Magic" width="300" height="230" style="display: block;" />
  					</td>
 				</tr>
 				<tr>
  					<td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
 						<table border="0" cellpadding="0" cellspacing="0" width="100%">
  							<tr>
   								<td>
    									Welcome to the Ten Charity Challenge!
   								</td>
  							</tr>
  							<tr>
   								<td style="padding: 20px 0 30px 0;">
    									To verify that you signed up for an account, please click the link below.
									If you did not sign up for an account, you can ignore this e-mail. 
   								</td>
  							</tr>
  							<tr>
   								<td>
    									<table border="1" cellpadding="0" cellspacing="0" width="100%">
										<tr>
											<td width="260" valign="top">
												<table border="1" cellpadding="0" cellspacing="0" width="100%">
													<tr>
														<td>
															<img src="https://crescentcove.org/cms-files/size-992x992/img-5500.k.jpg" alt="Friends volunteering" width="100%" height="140" style="display: block;" />
														</td>
													</tr>
													<tr>
														<td style="padding: 25px 0 0 0;">
															Find your friends to easily invite them to volunteer events and see where they are volunteering.
														</td>
													</tr>
												</table>
											</td>
											<td style="font-size: 0; line-height: 0;" width="20">
												&nbsp;
											</td>
											<td width="260" valign="top">
												 <table border="1" cellpadding="0" cellspacing="0" width="100%">
                                                                                                        <tr>
                                                                                                                <td>
                                                                                                                        <img src="https://www.treuleben.com/media/productdetail/700x700/801033/journal-notebook_1.jpg" alt="" width="100%" height="140" style="display: block;" />
														</td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                                <td style="padding: 25px 0 0 0;">
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
  					<td bgcolor="#665882">
   						Row 3
  					</td>
 				</tr>
			</table>
		</body>';
$char_set = 'UTF-8';

try {
    $result = $SesClient->sendEmail([
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
    $messageId = $result['MessageId'];
    echo("Email sent! Message ID: $messageId"."\n");
} catch (AwsException $e) {
    // output error message if fails
    echo $e->getMessage();
    echo("The email was not sent. Error message: ".$e->getAwsErrorMessage()."\n");
    echo "\n";
}
