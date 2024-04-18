<?php 

require 'vendor/src/PHPMailer.php';
require 'vendor/src/SMTP.php';
require 'vendor/src/Exception.php';
include_once 'base_url.php';
use phpmailer\phpmailer\PHPMailer;
use phpmailer\phpmailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendVerificationEmail($userEmail, $token,$fname,$lname, $base_url){

$mail = new PHPMailer(true);
 
// Enable verbose debug output (optional)
// $mail->SMTPDebug = SMTP::DEBUG_SERVER;
$mail->SMTPDebug = 0;  // Set to 0 to disable debugging

// Set the mailer to use SMTP
$mail->isSMTP();

// SMTP configuration
$mail->Host = 'mail.theboxlab.co.za'; // Your SMTP server
$mail->SMTPAuth = true;
$mail->Username = 'activation@theboxlab.co.za'; // Your SMTP username
$mail->Password = 'theBox@2021'; // Your SMTP password
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable SSL encryption
$mail->Port = 465; // SMTP port (usually 587)

// Set the sender and recipient
$mail->setFrom('activation@theboxlab.co.za', 'theBox'); // Sender email and name
$mail->addAddress($userEmail, $fname,$lname); // Recipient email and name

// Adding CC recipients
	// $mail->addCC('cc@example.com', 'CC Recipient');
	// $mail->addCC('cc2@example.com', 'CC Recipient 2');

// Adding BCC recipients
		// $mail->addBCC('bcc@example.com', 'BCC Recipient');
		// $mail->addBCC('bcc2@example.com', 'BCC Recipient 2');
// Set email subject and body
$mail->Subject = 'Activate administrator Account';
$mail->Body = '

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
	<meta charset="utf-8">
	<title></title>
	<style>
	.name{
	  color:blue;
	}
		*{
		  align-items:center;
		}
		html, body{
		  padding: 0px;
		  margin: 0px;
		  text-align: center;
		  align-items: center;
		}
		footer{
		  text-align: center;
		  align-items: center;
		}
	</style>
  </head>
  <body>
 
	<div class="wrapper">
	<img src="box.png" alt="">
	  <p class="name">
Hi   '.$fname.' '.$lname.'
	  </p>
  <p>

  </p>

<p>  <a href="'.$base_url.'index.php?activateToken=' .$token. '">
Activate your Account
</a>

</p>
<p>

If you are having trouble clicking the "Activate Account" button, copy and paste the URL below into your web browser:
<br>
'.$base_url.'index.php?activateToken=' .$token. '
</p> 
	</div>
  </body><hr>
  <footer>&copy; </footer>
</html>

';
$mail->AltBody = '..';

// Add attachments if needed
// $mail->addAttachment('/path/to/file.pdf'); // Path to the attachment file

// Send the email
if ($mail->send()) {
    // echo 'Email sent successfully!';
} else {
    // echo 'Error: ' . $mail->ErrorInfo;
}
}



////////////////////////////////2FA AUTH/////////////////////////////

function sendtwoLink($userEmail, $two_factor,$fname,$base_url){
    $mail = new PHPMailer(true);

    // Enable verbose debug output (optional)
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->SMTPDebug = 0;  // Set to 0 to disable debugging    
    // Set the mailer to use SMTP
    $mail->isSMTP();
    
    // SMTP configuration
    // SMTP configuration
    $mail->Host = 'mail.theboxlab.co.za'; // Your SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'noreply@theboxlab.co.za'; // Your SMTP username
    $mail->Password = 'theBox@2021'; // Your SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable SSL encryption
    $mail->Port = 465; // SMTPS port (usually 465)
    
    // Set the sender and recipient
    $mail->setFrom('noreply@theboxlab.co.za', 'theBox'); // Sender email and name
    $mail->addAddress($userEmail, $fname); // Recipient email and name
    
    // Set email subject and body
    $mail->Subject = 'Account Login Request';
    $mail->Body = '
 '.$two_factor.'
    ';
    // $mail->AltBody = 'This is the plain text message body';
    
    // Add attachments if needed
    // $mail->addAttachment('/path/to/file.pdf'); // Path to the attachment file
    
    // Send the email
    if ($mail->send()) {
        // echo 'Email sent successfully!';
    } else {
        // echo 'Error: ' . $mail->ErrorInfo;
    }
}

//////////////////.///////////////////END 2FA/////////



///////////////END RESET PASSWORD//////////////



///////////////////////SENDING EMAIL FOR UNRECOGNISED LOGIN//////////////////
function accountLink($email,$fname,$ub,$uv,$ul,$uo,$ud, $time_log)
{
	$mail = new PHPMailer(true);

	// Enable verbose debug output (optional)
	// $mail->SMTPDebug = SMTP::DEBUG_SERVER;
	$mail->SMTPDebug = 0;  // Set to 0 to disable debugging
	
	// Set the mailer to use SMTP
	$mail->isSMTP();
	
	// SMTP configuration
	$mail->Host = 'mail.theboxlab.co.za'; // Your SMTP server
	$mail->SMTPAuth = true;
	$mail->Username = 'support@theboxlab.co.za'; // Your SMTP username
	$mail->Password = 'theBox@2021'; // Your SMTP password
	$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable SSL encryption
	$mail->Port = 465; // SMTP port (usually 587)
	
	// Set the sender and recipient
	$mail->setFrom('support@theboxlab.co.za', 'theBox');  // Sender email and name
	$mail->addAddress($email, $fname); // Recipient email and name

	// Adding CC recipients
	// $mail->addCC($emails, $company,'Representative');
	// $mail->addCC('cc2@example.com', 'CC Recipient 2');

// Adding BCC recipients
		// $mail->addBCC('bcc@example.com', 'BCC Recipient');
		// $mail->addBCC('bcc2@example.com', 'BCC Recipient 2');

	// Set email subject and body
	$mail->Subject = 'Security Alert';
	$mail->Body ='
	<!DOCTYPE html>
  <html lang="en" dir="ltr">
    <head>
      <meta charset="utf-8">
      <title></title>
      <style>
      .name{
        color:blue;
      }
          *{
            align-items:center;
          }
          html, body{
            padding: 0px;
            margin: 0px;
            text-align: center;
            align-items: center;
          }
          footer{
            text-align: center;
            align-items: center;
          }
      </style>
    </head>
    <body>
   
      <div class="wrapper">
      <img src="box.png" alt="">
        <p class="name">
Hi   '.$fname.' 
        </p>
        A new sign-in on '.$uo.' <br>
  We noticed a new sign-in on a '.$uo.' device. <br>
   If this was you, you do not need to do anything. If not, we will help you secure your account.
<br>
Below are the details of a device that signed in to your Account. <br>
Browser name : '.$ub.' <br>
Version : '.$uv.' <br>
Layout : '.$ul.' <br>
OS : '.$uo.' <br>
Device name & Description : '.$ud.' <br>
Time logged in : '.$time_log.' <br>
 
    <br>
    Kind Regards <br>
    theBoxlab Security Team
    <br>
    <hr>
    You received this email to let you know about important changes to your Account.

      </div>
    </body><hr>
    <footer>&copy; </footer>
  </html>
	';

	$mail->AltBody = 'This is the plain text message body';
	
	// Add attachments if needed
	// $mail->addAttachment('/path/to/file.pdf'); // Path to the attachment file
	
	// Send the email
	if ($mail->send()) {
		// echo 'Email sent successfully!';
	} else {
		// echo 'Error: ' . $mail->ErrorInfo;
	}
	}
//////////////////////-===================-=-=END /////////////////-=================================/=-


///////////////////////////-=-=-==-=--=-==-=-OLD-=---=-=-==-=-////////////////


///////////////////////ADMIN ACTIVATION EMAIL/////////////////////////
function activateEmail($email,$browser,$version,$os,$description,$product,$manufacturer,$fname,$lname,$base_url){
	
	$mail = new PHPMailer(true);
	
	// Enable verbose debug output (optional)
	// $mail->SMTPDebug = SMTP::DEBUG_SERVER;
	$mail->SMTPDebug = 0;  // Set to 0 to disable debugging
	
	// Set the mailer to use SMTP
	$mail->isSMTP();
	
	// SMTP configuration
	$mail->Host = 'mail.theboxlab.co.za'; // Your SMTP server
	$mail->SMTPAuth = true;
	$mail->Username = 'noreply@theboxlab.co.za'; // Your SMTP username
	$mail->Password = 'theBox@2021'; // Your SMTP password
	$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable SSL encryption
	$mail->Port = 465; // SMTP port (usually 587)
	
	// Set the sender and recipient
	$mail->setFrom('noreply@theboxlab.co.za', 'theBox'); // Sender email and name
	$mail->addAddress($email, $fname,$lname); // Recipient email and name
	
	// Adding CC recipients
		// $mail->addCC('cc@example.com', 'CC Recipient');
		// $mail->addCC('cc2@example.com', 'CC Recipient 2');
	
	// Adding BCC recipients
			// $mail->addBCC('bcc@example.com', 'BCC Recipient');
			// $mail->addBCC('bcc2@example.com', 'BCC Recipient 2');
	// Set email subject and body
	$mail->Subject = 'Account Activation';
	$mail->Body = '
	<!DOCTYPE html>
	  <html lang="en" dir="ltr">
		<head>
		  <meta charset="utf-8">
		  <title></title>
		  <style>
		  .name{
			color:blue;
		  }
			  *{
				align-items:center;
			  }
			  html, body{
				padding: 0px;
				margin: 0px;
				text-align: center;
				align-items: center;
			  }
			  footer{
				text-align: center;
				align-items: center;
			  }
		  </style>
		</head>
		<body>
	   
		  <div class="wrapper">
		  <img src="box.png" alt="">
			<p class="name">
	Hi   '.$fname.'  '.$lname.'
			</p>
		   Your account was successfully activated using the following device <br>
		   </p>
	<br>
	   If this was you, you do not need to do anything. If not, we will help you secure your account.
	<br>
	Below are the details of th device that changed your Account password. <br>
	Browser name : '.$browser.' <br>
	Version : '.$version.' <br>
	OS : '.$os.' <br>
	Device name & Description : '.$description.' <br>
	 
		<br>

		<p class="name">
		You can now login using your admin account here
		
		<p>  <a href="'.$base_url.'">
		Login
		</a>
		
		</p>
		<p>
		
		If you are having trouble clicking the "Activate Account" button, copy and paste the URL below into your web browser:
		<br>
		'.$base_url.'
		</p> 
			
		Kind Regards <br>
		 Security Team
		<br>
		<hr>
		You received this email to let you know about important changes to your Account.
	
		  </div>
		</body><hr>
		<footer>&copy; </footer>
	  </html>
	';
	
	$mail->AltBody = '..';
	
	// Add attachments if needed
	// $mail->addAttachment('/path/to/file.pdf'); // Path to the attachment file
	
	// Send the email
	if ($mail->send()) {
		// echo 'Email sent successfully!';
	} else {
		// echo 'Error: ' . $mail->ErrorInfo;
	}}
	
	////////////////end////////
	
	

///////////////////////ADMIN ACTIVATION EMAIL/////////////////////////
function TokenExpireLink($email, $link_expiration_time, $token,$browser,$version,$os,$description,$product,$manufacturer,$time,$lname,$fname,$base_url){
	
	$mail = new PHPMailer(true);
	
	// Enable verbose debug output (optional)
	// $mail->SMTPDebug = SMTP::DEBUG_SERVER;
	$mail->SMTPDebug = 0;  // Set to 0 to disable debugging
	
	// Set the mailer to use SMTP
	$mail->isSMTP();
	
	// SMTP configuration
	$mail->Host = 'mail.theboxlab.co.za'; // Your SMTP server
	$mail->SMTPAuth = true;
	$mail->Username = 'noreply@theboxlab.co.za'; // Your SMTP username
	$mail->Password = 'theBox@2021'; // Your SMTP password
	$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable SSL encryption
	$mail->Port = 465; // SMTP port (usually 587)
	
	// Set the sender and recipient
	$mail->setFrom('noreply@theboxlab.co.za', 'theBox'); // Sender email and name
	$mail->addAddress($email, $fname, $lname); // Recipient email and name
	
	// Adding CC recipients
		// $mail->addCC('cc@example.com', 'CC Recipient');
		// $mail->addCC('cc2@example.com', 'CC Recipient 2');
	
	// Adding BCC recipients
			// $mail->addBCC('bcc@example.com', 'BCC Recipient');
			// $mail->addBCC('bcc2@example.com', 'BCC Recipient 2');
	// Set email subject and body
	$mail->Subject = 'Password Reset';
	$mail->Body = '
	<!DOCTYPE html>
	  <html lang="en" dir="ltr">
		<head>
		  <meta charset="utf-8">
		  <title></title>
		  <style>
		  .name{
			color:blue;
		  }
			  *{
				align-items:center;
			  }
			  html, body{
				padding: 0px;
				margin: 0px;
				text-align: center;
				align-items: center;
			  }
			  footer{
				text-align: center;
				align-items: center;
			  }
		  </style>
		</head>
		<body>
	   
		  <div class="wrapper">
		  <img src="box.png" alt="">
			<p class="name">
	Hi   '.$fname.'  '.$lname.'
			</p>
		   You requested a password reset link using the following device <br>
		   </p>
	<br>
	   If this was you, you do not need to do anything. If not, we will help you secure your account.
	<br>
	Below are the details of th device that changed your Account password. <br>
	Browser name : '.$browser.' <br>
	Version : '.$version.' <br>
	OS : '.$os.' <br>
	Device name & Description : '.$description.' <br>
	 
		<br>

		<p>  <a href="'.$base_url.'index.php?resetToken=' .$token. '">
	Reset Password
  </a>
	
	</p>
	<p>

	If you are having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:
	<br>
	'.$base_url.'index.php?resetToken=' .$token. '
	</p> 
		  </div>
		</body><hr>
		<footer>&copy; </footer>
	  </html>
	';
	
	$mail->AltBody = '..';
	
	// Add attachments if needed
	// $mail->addAttachment('/path/to/file.pdf'); // Path to the attachment file
	
	// Send the email
	if ($mail->send()) {
		// echo 'Email sent successfully!';
	} else {
		// echo 'Error: ' . $mail->ErrorInfo;
	}}
	
	////////////////end////////
	
	
