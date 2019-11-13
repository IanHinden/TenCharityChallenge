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

$email = $_POST['email'];

//Create Signup token
$selector = bin2hex(random_bytes(8));
$token = random_bytes(32);

$expire = date("Y-m-d H:i:s", strtotime("+1 hours"));

$url = sprintf('%spasswordreset.php?%s', 'https://www.tencharitychallenge.com/', http_build_query([
	'selector' => $selector,
        'validator' => bin2hex($token)
]));

$subject = 'Instructions to Reset Password';
$plaintext_body = 'Here is the email you requested to reset your password. If you did not request this, please ignore this e-mail.' ;
$html_body =  '<h1>Click the link below to resert your password</h1>'.
              '<p>Here is the link:'.$url.'. Checkit out!'.
              'Amazon SES</a> using the <a href="https://aws.amazon.com/sdk-for-php/">'.
              'AWS SDK for PHP</a>.</p>';
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
	echo("Email sent! Message ID: $messageId"."\n");
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
