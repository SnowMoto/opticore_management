<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // CAPTCHA verification
    $userCaptcha = trim($_POST['captcha']);
    $realCaptcha = trim($_POST['captcha_answer']);

    if (strcasecmp($userCaptcha, $realCaptcha) !== 0) {
        header("Location: /index.html?error=" . urlencode("CAPTCHA failed. Please try again."));
        exit;
    }

    // Collect and sanitize form inputs
    $name = htmlspecialchars($_POST["name"]);
    $phone = htmlspecialchars($_POST["phone"]);
    $email = filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL);
    $subject = htmlspecialchars($_POST["subject"]);
    $message = htmlspecialchars($_POST["message"]);

    if (!$email) {
        header("Location: /index.html?error=" . urlencode("Please enter a valid email address."));
        exit;
    }

    // Email setup
    $to = "contact@opticore-management.com";  // Change to your real email
    $email_subject = "New message from contact form: $subject";
    $email_body = "You have received a new message:\n\n" .
                "Name: $name\n" .
                "Phone: $phone\n" .
                "Email: $email\n" .
                "Subject: $subject\n" .
                "Message:\n$message";

    $headers = "From: $email\n";
    $headers .= "Reply-To: $email";

    // Send email
    if (mail($to, $email_subject, $email_body, $headers)) {
        header("Location: /index.html?success=1");
        exit;
    } else {
        header("Location: /index.html?error=" . urlencode("Message failed to send."));
        exit;
    }
} else {
    header("Location: /index.html?error=" . urlencode("Invalid request."));
    exit;
}
?>
