<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';  // Include the Composer autoload file

// Create an instance of PHPMailer
$mail = new PHPMailer(true);

try {
    // Sanitize input values from the form
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars($_POST['message']);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Invalid email format.");
    }

    // Set up PHPMailer to use SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.zoho.com';  // Zoho SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'penfi@pensionficto.com';  // Your Zoho email address
    $mail->Password = 'your-zoho-password';  // Your Zoho password or app-specific password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 465;

    // Set the sender and recipient details
    $mail->setFrom('penfi@pensionficto.com', 'PensionFi');
    $mail->addAddress('penfi@pensionficto.com');  // Recipient email

    // Subject and Body of the email
    $mail->Subject = "Message from Website Contact Form";
    $mail->Body = "Name: " . $name . "\nEmail: " . $email . "\n\nMessage:\n" . $message;
    $mail->AltBody = "Name: " . $name . "\nEmail: " . $email . "\n\nMessage:\n" . $message;

    // Send the email
    $mail->send();
    echo 'Message sent!';
} catch (Exception $e) {
    echo "Mailer Error: " . $mail->ErrorInfo;
}
?>