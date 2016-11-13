<?php 

include_once('inc/class.simple_mail.php');
include_once('inc/gump.class.php');

include_once('mail-config.php');




// Check Data
$isValid = GUMP::is_valid($_POST, array(
	'first-name' => 'required',
	'last-name' => 'required',
	'telephone' => 'required',
	'email' => 'required',
	'message' => 'required'
	));

if($isValid === true) {

	// Submit Mail
	$mailAdmin = new SimpleMail();
	$mailAdmin->setTo(YOUR_EMAIL_ADDRESS, YOUR_COMPANY_NAME)
	->setSubject('New contact request')
	->setFrom(htmlspecialchars($_POST['email']), htmlspecialchars($_POST['first-name'].' '.$_POST['last-name']))
	->addGenericHeader('X-Mailer', 'PHP/' . phpversion())
	->addGenericHeader('Content-Type', 'text/html; charset="utf-8"')
	->setMessage(createClientMessage($_POST))
	->setWrap(100);

	$mailAdmin->send();

	// Submit Client Mail
	$mailClient = new SimpleMail();
	$mailClient->setTo(htmlspecialchars($_POST['email']), htmlspecialchars($_POST['first-name'].' '.$_POST['last-name']))
	->setSubject('Your contact request at '.YOUR_COMPANY_NAME)
	->setFrom(YOUR_EMAIL_ADDRESS, YOUR_COMPANY_NAME)
	->addGenericHeader('X-Mailer', 'PHP/' . phpversion())
	->addGenericHeader('Content-Type', 'text/html; charset="utf-8"')
	->setMessage(createClientMessage($_POST))
	->setWrap(100);

	$mailClient->send();


	$result = array(
		'result' => 'success', 
		'msg' => array('Success! Your contact request has been sent.')
		);

	echo json_encode($result);

} else {
	$result = array(
		'result' => 'error', 
		'msg' => $isValid
		);

	echo json_encode($result);
}


function createAdminMessage($formData)
{
	$body  = 	"You have got a new contact request from your website : <br><br>";
	$body .=	"First Name:  ".htmlspecialchars($formData['first-name'])." <br><br>";
	$body .=	"Last Name:  ".htmlspecialchars($formData['last-name'])." <br><br>";
	$body .=	"Telephone:  ".htmlspecialchars($formData['telephone'])." <br><br>";
	$body .=	"Email:  ".htmlspecialchars($formData['email'])." <br><br>";
	$body .=	"Message: <br><br>";
	$body .=	htmlspecialchars($formData['message']);

	return $body;
}


function createClientMessage($formData)
{
	$body  = 	"Hello ".htmlspecialchars($formData['first-name'])." ".htmlspecialchars($formData['last-name'])."<br><br>";
	$body .=	"Your request has been successfully forwarded to us.<br>";
	$body .=	"We will deal with it immediately and contact you as soon as possible.<br><br>";
	$body .=	"For further questions we are happy to help! <br><br>";
	$body .=	"Best regards<br>".YOUR_COMPANY_NAME;


	return $body;
}



















// $mail = new SimpleMail();
// $mail->setTo('mail@themeinjection.com', 'Your Email')
// ->setSubject('Test Message')
// ->setFrom('no-reply@domain.com', 'Domain.com')
// ->addMailHeader('Reply-To', 'no-reply@domain.com', 'Domain.com')
// ->addMailHeader('Cc', 'bill@example.com', 'Bill Gates')
// ->addMailHeader('Bcc', 'steve@example.com', 'Steve Jobs')
// ->addGenericHeader('X-Mailer', 'PHP/' . phpversion())
// ->addGenericHeader('Content-Type', 'text/html; charset="utf-8"')
// ->setMessage('<strong>This is a test message.</strong>')
// ->setWrap(100);
//$send = $mail->send();
//echo ($send) ? 'Email sent successfully' : 'Could not send email';


//echo json_encode(array('data' => 'test data'));

/* AJAX check  */
// if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
// 	echo json_encode(array('data' => 'test data'));
// }
// else
// {
// 	echo 'no ajax';
// }