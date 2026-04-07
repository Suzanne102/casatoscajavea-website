<?php
// Block direct access
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Invalid access.";
    exit;
}

// Simple spam honeypot
if (!empty($_POST['website'])) {
    exit; // bot detected
}

// Helper sanitize
function clean($value) {
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}

// Collect fields
$firstName     = clean($_POST['firstName']     ?? ($_POST['fullName'] ?? ''));
$lastName      = clean($_POST['lastName']      ?? '');
$email         = clean($_POST['email']         ?? '');
$phone         = clean($_POST['phone']         ?? '');
$apartNo       = clean($_POST['apart-no']      ?? '');
$noOfPeople    = clean($_POST['no-of-people']  ?? '');
$checkInDate   = clean($_POST['checkInDate']   ?? '');
$checkOutDate  = clean($_POST['checkOutDate']  ?? '');
$timestamp     = date('Y-m-d H:i:s');

// Prepare CSV directory
$csvDir = __DIR__ . '/private/';
if (!is_dir($csvDir)) {
    mkdir($csvDir, 0755, true);
}

$csvFile = $csvDir . 'enquiry-leads.csv';

// Write CSV
$csvHandle = fopen($csvFile, 'a');

if ($csvHandle) {
    if (filesize($csvFile) === 0) {
        // Write header only once
        fputcsv($csvHandle, [
            'timestamp','firstName','lastName','email','phone',
            'apartment','noOfPeople','checkInDate','checkOutDate'
        ]);
    }

    fputcsv($csvHandle, [
        $timestamp, $firstName, $lastName, $email, $phone,
        $apartNo, $noOfPeople, $checkInDate, $checkOutDate
    ]);

    fclose($csvHandle);
}

// Send an email (optional – you can remove this section)
$to      = "info@casatoscajavea.com";
$subject = "New Enquiry – Casa Tosca";
$message = "New enquiry received:\n\n"
         . "Name: $firstName $lastName\n"
         . "Email: $email\n"
         . "Phone: $phone\n"
         . "Apartment: $apartNo\n"
         . "Guests: $noOfPeople\n"
         . "Arrival: $checkInDate\n"
         . "Departure: $checkOutDate\n"
         . "Sent on: $timestamp\n";

$headers = "From: info@casatoscajavea.com\r\n";
@mail($to, $subject, $message, $headers);

// Redirect to THANK YOU page/Spanish version
header("Location: /pages/forms/consulta-exito.html?test=1");

exit;