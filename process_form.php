<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // --- IMPORTANT: CHANGE THIS TO YOUR EMAIL ADDRESS ---
    $to = "your.email@example.com";

    // --- Collect form data ---
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = trim($_POST["message"]);

    // --- Basic validation ---
    if (empty($name) || empty($subject) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // If there's an error, redirect to an error page or back to the form
        http_response_code(400);
        echo "Please fill out all fields and provide a valid email address.";
        exit;
    }

    // --- Build the email content ---
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Subject: $subject\n\n";
    $email_content .= "Message:\n$message\n";

    // --- Build the email headers ---
    $email_headers = "From: $name <$email>";

    // --- Send the email ---
    if (mail($to, $subject, $email_content, $email_headers)) {
        // Redirect to a success page or display a success message
        http_response_code(200);
        echo "Thank You! Your message has been sent.";
    } else {
        // If mail fails to send
        http_response_code(500);
        echo "Oops! Something went wrong, and we couldn't send your message.";
    }

} else {
    // Not a POST request
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}
?>