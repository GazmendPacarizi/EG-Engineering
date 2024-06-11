<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $name = filter_var(trim($_POST["name"]), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = filter_var(trim($_POST["subject"]), FILTER_SANITIZE_STRING);
    $message = filter_var(trim($_POST["message"]), FILTER_SANITIZE_STRING);

    // Validate the form data
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        // Redirect back to the form with an error message
        header("Location: contact.html?error=Please fill in all fields");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Redirect back to the form with an error message
        header("Location: contact.html?error=Invalid email format");
        exit;
    }

    // Set the recipient email address
    $to = "gazmendpaqarizi@gmail.com"; // Replace with your email address

    // Set the email subject
    $email_subject = "New contact form submission: $subject";

    // Construct the email body
    $email_body = "You have received a new message from the contact form on your website.\n\n".
                  "Name: $name\n".
                  "Email: $email\n".
                  "Subject: $subject\n\n".
                  "Message:\n$message";

    // Set the email headers
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Send the email
    if (mail($to, $email_subject, $email_body, $headers)) {
        // Redirect to a thank you page or back to the form with a success message
        header("Location: contact.html?success=Message sent successfully");
    } else {
        // Redirect back to the form with an error message
        header("Location: contact.html?error=Unable to send message. Please try again later.");
    }
}
?>