<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = htmlspecialchars($_POST['firstName']);
    $lastName = htmlspecialchars($_POST['lastName']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $postalCode = htmlspecialchars($_POST['postalCode']);
    $country = htmlspecialchars($_POST['country']);
    $apartNo = htmlspecialchars($_POST['apart-no']);
    $noOfPeople = htmlspecialchars($_POST['no-of-people']);
    $checkInDate = htmlspecialchars($_POST['checkInDate']);
    $checkOutDate = htmlspecialchars($_POST['checkOutDate']);

    // Perform validation (optional)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
        exit();
    }

    // Prepare the email content
    $to = "info@casatoscajavea.com";
    $subject = "New Booking Request from $firstName $lastName";
    $headers = "From: $email" . "\r\n" .
               "Reply-To: $email" . "\r\n" .
               "X-Mailer: PHP/" . phpversion();
    $body = "Name: $firstName $lastName\n".
            "Email: $email\n".
            "Phone: $phone\n".
            "Postal Code: $postalCode\n".
            "Country: $country\n".
            "Apartment: $apartNo\n".
            "Number of People: $noOfPeople\n".
            "Check-In Date: $checkInDate\n".
            "Check-Out Date: $checkOutDate\n";

    // Send the email
    if (mail($to, $subject, $body, $headers)) {
        // Redirect to a thank you page
        header("Location: /thank-you.html");
    } else {
        echo "Sorry, something went wrong. Please try again later.";
    }
    exit();
}
?>
