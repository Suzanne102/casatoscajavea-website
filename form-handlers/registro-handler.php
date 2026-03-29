<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "<h2>Acceso inválido</h2>";
    exit;
}

// ---------- HELPERS ----------
function clean(string $value): string {
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}

// ---------- COLLECT FIELDS ----------
$tipodoc          = clean($_POST['tipodoc']          ?? '');
$numeroID         = clean($_POST['no-id']            ?? '');
$fechaExpedicion  = clean($_POST['fecha-expedicion'] ?? '');
$apellido1        = clean($_POST['apellido1']        ?? '');
$apellido2        = clean($_POST['apellido2']        ?? '');
$nombre           = clean($_POST['nombre']           ?? '');
$sexo             = clean($_POST['sexo']             ?? '');
$fechaNacimiento  = clean($_POST['fecha-nacimiento'] ?? '');
$pais             = clean($_POST['pais']             ?? '');
$email            = clean($_POST['email']            ?? '');
$telefono         = clean($_POST['telefono']         ?? '');
$fechaLlegada     = clean($_POST['fecha-llegada']    ?? '');

// ---------- DIRECTORIES ----------
$uploadDir  = __DIR__ . '/uploads/';
$privateDir = __DIR__ . '/private/';
$pdfDir     = $privateDir . 'pdfs/';

foreach ([$uploadDir, $privateDir, $pdfDir] as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// ---------- CLEAN OLD ID IMAGES (> 24h) ----------
$now = time();
$maxAge = 24 * 60 * 60; // 24 hours

foreach (glob($uploadDir . '*') as $filePath) {
    if (is_file($filePath) && ($now - filemtime($filePath)) > $maxAge) {
        @unlink($filePath);
    }
}

// ---------- HANDLE FILE UPLOAD ----------
$uploadOK = false;
$uploadedFilePath = '';
$savedFileName = '';

if (!empty($_FILES['id-upload']['name'])) {
    $originalName = basename($_FILES['id-upload']['name']);
    $savedFileName = time() . '_' . preg_replace('/[^A-Za-z0-9._-]/', '_', $originalName);
    $targetFile = $uploadDir . $savedFileName;

    $allowed = ['jpg', 'jpeg', 'png', 'pdf'];
    $ext = strtolower(pathinfo($savedFileName, PATHINFO_EXTENSION));

    if (in_array($ext, $allowed, true)) {
        if (move_uploaded_file($_FILES['id-upload']['tmp_name'], $targetFile)) {
            $uploadOK = true;
            $uploadedFilePath = $targetFile;
        }
    }
}

// ---------- SAVE CSV ----------
$csvFile = $privateDir . 'registro-huespedes.csv';
$csvRow  = [
    date('Y-m-d H:i:s'),
    $tipodoc,
    $numeroID,
    $fechaExpedicion,
    $apellido1,
    $apellido2,
    $nombre,
    $sexo,
    $fechaNacimiento,
    $pais,
    $email,
    $telefono,
    $fechaLlegada,
    $uploadOK ? $savedFileName : 'No file'
];

$csvHandle = @fopen($csvFile, 'a');
if ($csvHandle) {
    // Optional: write header on empty file
    if (0 === filesize($csvFile)) {
        fputcsv($csvHandle, [
            'timestamp',
            'tipodoc',
            'numeroID',
            'fechaExpedicion',
            'apellido1',
            'apellido2',
            'nombre',
            'sexo',
            'fechaNacimiento',
            'pais',
            'email',
            'telefono',
            'fechaLlegada',
            'id_file'
        ]);
    }
    fputcsv($csvHandle, $csvRow);
    fclose($csvHandle);
}

// ---------- GENERATE PDF WITH FPDF ----------
$pdfPath = $pdfDir . ($numeroID !== '' ? $numeroID : ('guest_' . time())) . '.pdf';

if (file_exists(__DIR__ . '/vendor/fpdf.php')) {
    require_once __DIR__ . '/vendor/fpdf.php';

    // Create PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Casa Tosca Javea - Guest Registration Form', 0, 1, 'C');
    $pdf->Ln(5);

    $pdf->SetFont('Arial', '', 12);

    // Basic info
    $pdf->Cell(50, 8, 'Name:', 0, 0);
    $pdf->Cell(0, 8, $nombre . ' ' . $apellido1 . ' ' . $apellido2, 0, 1);

    $pdf->Cell(50, 8, 'Document:', 0, 0);
    $pdf->Cell(0, 8, strtoupper($tipodoc) . ' - ' . $numeroID, 0, 1);

    $pdf->Cell(50, 8, 'Issue date:', 0, 0);
    $pdf->Cell(0, 8, $fechaExpedicion, 0, 1);

    $pdf->Cell(50, 8, 'Date of birth:', 0, 0);
    $pdf->Cell(0, 8, $fechaNacimiento, 0, 1);

    $pdf->Cell(50, 8, 'Nationality:', 0, 0);
    $pdf->Cell(0, 8, $pais, 0, 1);

    $pdf->Cell(50, 8, 'Sex:', 0, 0);
    $pdf->Cell(0, 8, $sexo, 0, 1);

    $pdf->Cell(50, 8, 'Arrival date:', 0, 0);
    $pdf->Cell(0, 8, $fechaLlegada, 0, 1);

    $pdf->Cell(50, 8, 'Email:', 0, 0);
    $pdf->Cell(0, 8, $email, 0, 1);

    $pdf->Cell(50, 8, 'Phone:', 0, 0);
    $pdf->Cell(0, 8, $telefono, 0, 1);

    $pdf->Ln(8);

    // If we have an image, show a small thumbnail
    if ($uploadOK && is_file($uploadedFilePath) && strtolower(pathinfo($uploadedFilePath, PATHINFO_EXTENSION)) !== 'pdf') {
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 8, 'ID document image:', 0, 1);
        // x, y, width
        $y = $pdf->GetY();
        $pdf->Image($uploadedFilePath, 10, $y + 2, 60);
        $pdf->Ln(50);
    }

    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Ln(5);
    $pdf->Cell(0, 8, 'Generated on ' . date('Y-m-d H:i:s') . ' by Casa Tosca Javea.', 0, 1, 'L');

    $pdf->Output('F', $pdfPath);
}

// ---------- EMAIL NOTICE (simple text email) ----------
$to      = 'info@casatoscajavea.com';
$subject = 'Nuevo registro de huesped - Casa Tosca';

$message  = "Nuevo registro enviado:\n\n";
$message .= "Nombre: $nombre $apellido1 $apellido2\n";
$message .= "Documento: $tipodoc - $numeroID\n";
$message .= "Fecha de expedicion: $fechaExpedicion\n";
$message .= "Fecha de nacimiento: $fechaNacimiento\n";
$message .= "Pais: $pais\n";
$message .= "Sexo: $sexo\n";
$message .= "Fecha de llegada: $fechaLlegada\n";
$message .= "Email: $email\n";
$message .= "Telefono: $telefono\n";
$message .= "Archivo cargado: " . ($uploadOK ? $savedFileName : 'No') . "\n";

$headers = "From: info@casatoscajavea.com\r\n";

@mail($to, $subject, $message, $headers);

// ---------- REDIRECT TO SUCCESS PAGE ----------
header('Location: /en/pages/forms/registration-confirmation.html');
exit;
?>