<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'config.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

try {
    $mail = new PHPMailer(true);

    // Server settings
    $mail->isSMTP();
    $mail->Host       = SMTP_HOST;
    $mail->SMTPAuth   = true;
    $mail->Username   = SMTP_USERNAME;
    $mail->Password   = SMTP_PASSWORD;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = SMTP_PORT;

    // Recipients
    $mail->setFrom(FROM_EMAIL, FROM_NAME);
    $mail->addAddress($_POST['to']);

    // Content
    $mail->isHTML(true);
    $mail->Subject = $_POST['subject'];

    // Load the selected template
    $template = file_get_contents("templates/{$_POST['template']}.html");

    // Replace placeholders in the template
    $template = str_replace('[Recipient\'s Name]', $_POST['recipientName'], $template);
    $template = str_replace('[Your detailed message goes here. This template supports longer, more complex content.]', $_POST['content'], $template);

    $mail->Body = $template;

    // Attachment
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
        $mail->addAttachment($_FILES['attachment']['tmp_name'], $_FILES['attachment']['name']);
    }

    $mail->send();
    $response['success'] = true;
    $response['message'] = 'Email sent successfully';
} catch (Exception $e) {
    $response['message'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

echo json_encode($response);