<?php
	
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';
require 'config.php';
// echo From_Email_Add; // config email

if(isset($_POST['submit_form'])){
		
	$name = $_POST['name'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];

	// Instantiation and passing `true` enables exceptions
	$mail = new PHPMailer(true);

	try {
	    //Server settings
	    // $mail->SMTPDebug = SMTP::DEBUG_SERVER; //It will display all PHP Mailer message. uncomment to see                      // Enable verbose debug output
	    $mail->isSMTP();                                            // Send using SMTP
	    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
	    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
	    $mail->Username   = From_Email_Add;                     // SMTP username
	    $mail->Password   = From_Email_Pass;                               // SMTP password
	    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
	    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

	    //Recipients
	    $mail->setFrom(From_Email_Add, From_Email_Name);
	    $mail->addAddress($email, $name);     // Add a recipient
	    // $mail->addAddress('ellen@example.com');               // Name is optional
	    $mail->addReplyTo(Reply_Email_Add, Reply_Email_Name);
	    // $mail->addCC('cc@example.com');
	    // $mail->addBCC('bcc@example.com');

	    // Attachments
	    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
	    $mail->addAttachment('./test_image.jpg', 'test.jpg');    // Optional name

	    // Content
	    $mail->isHTML(true);                                  // Set email format to HTML
	    $mail->Subject = 'PHP Mailer Test';//mail subject
	    $mail->Body    = 'Hello '.$name.'. <br><br> Your request has been submited successfully.<br> Following are the submited details.<br> Name : <b>'.$name.'</b>. <br> Email : <b>'.$email.'</b>.<br> Phone : <b>'.$phone.'</b>.';
	    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	    $mail->send();
	    $success = 'Message has been sent. Please check your mail';
	} catch (Exception $e) {
	    $error = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}

}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Simple Mail App</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>

	<div class="container my-2">
		<div class="card card-default">
			<div class="card-header"> PHP Mailer </div>
			<div class="card-body">
				<?php if($success){ ?><div class="alert alert-success"><?php echo $success; ?></div><?php } ?>
				<?php if($error){ ?><div class="alert alert-danger"><?php echo $error; ?></div><?php } ?>
				<form class="form" action="" method="POST">
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" name="name" id="name" class="form-control" placeholder="Enter you Name" required>
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" name="email" id="email" class="form-control" placeholder="Enter you Email" required>
					</div>
					<div class="form-group">
						<label for="phone">Phone</label>
						<input type="text" name="phone" id="phone" class="form-control" placeholder="Enter you Phone" required>
					</div>
					<div class="form-group">
						<input type="submit" name="submit_form" class="btn btn-primary">
					</div>
				</form>
			</div>
		</div>
		
	</div>

</body>
</html>