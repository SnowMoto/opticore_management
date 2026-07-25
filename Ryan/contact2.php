<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer-master/Exception.php';
require './PHPMailer-master/PHPMailer.php';
require './PHPMailer-master/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userCaptcha = trim($_POST['captcha']);
    $realCaptcha = trim($_POST['captcha_answer']);

    if (strcasecmp($userCaptcha, $realCaptcha) !== 0) {
        header("Location: /index.html?error=" . urlencode("CAPTCHA failed. Please try again."));
        exit;
    }

    $name = htmlspecialchars($_POST["name"]);
    $phone = htmlspecialchars($_POST["phone"]);
    $email = filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL);
    $subject = htmlspecialchars($_POST["subject"]);
    $message = htmlspecialchars($_POST["message"]);

    if (!$email) {
        header("Location: /index.html?error=" . urlencode("Please enter a valid email address."));
        exit;
    }

    $mail = new PHPMailer(true);
    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host = 'smtp.zoho.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'contact@opticore-management.com'; // your Zoho email
        $mail->Password = 'Ryajan06$$'; // use an app-specific password from Zoho
        $mail->SMTPSecure = 'ssl'; // or 'tls' with port 587
        $mail->Port = 465;

        // Sender and recipient
        $mail->setFrom('contact@opticore-management.com', 'Opticore Website');
        $mail->addAddress('contact@opticore-management.com'); // or another recipient

        $mail->addReplyTo($email, $name);

        // Email content
        $mail->isHTML(false);
        $mail->Subject = "New message from contact form: $subject";
        $mail->Body = "You have received a new message:\n\n" .
                      "Name: $name\n" .
                      "Phone: $phone\n" .
                      "Email: $email\n" .
                      "Subject: $subject\n" .
                      "Message:\n$message";

        $mail->send();
        header("Location: /index.html?success=1");
        exit;
    } catch (Exception $e) {
        header("Location: /index.html?error=" . urlencode("Message failed to send. Error: " . $mail->ErrorInfo));
        exit;
    }
} else {
    header("Location: /index.html?error=" . urlencode("Invalid request."));
    exit;
}
