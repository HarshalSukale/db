<?php
// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the feedback from the form
    $feedback = $_POST['feedback'];

    // Process the feedback (e.g., save it to a file, send it to an email, etc.)
    // ...

    // Display a success message
    echo "Thank you for your feedback!";
    exit;
}
?>