<?php
// Enable CORS (Remove this in production)
// header("Access-Control-Allow-Origin: http://localhost:4321");
// header("Access-Control-Allow-Headers: Content-Type");
// header("Access-Control-Allow-Methods: POST");

header('Content-Type: application/json');

// Get the POST data as JSON
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Initialize response array
$response = [
    'success' => false,
    'message' => ''
];

// Validate input data
if (!$data) {
    $response['message'] = 'Dati non validi.';
    echo json_encode($response);
    exit;
}

$name = trim($data['name']);
$surname = trim($data['surname']);
$reviewText = trim($data['reviewText']);
$gdprConsent = $data['gdprConsent'];

// Check if all required fields are present
if (empty($name) || empty($surname) || empty($reviewText)) {
    $response['message'] = 'Tutti i campi sono obbligatori.';
    echo json_encode($response);
    exit;
}

// Check if GDPR consent is given
if (empty($gdprConsent) || $gdprConsent != 1) {
    $response['message'] = 'È necessario accettare le modalità di trattamento dei dati personali.';
    echo json_encode($response);
    exit;
}

try {
    // Connect to db
    require_once 'db.php';
    
    // Prepare SQL statement
    $stmt = $pdo->prepare('INSERT INTO reviews (date, name, surname, text) VALUES (NOW(), :name, :surname, :text)');
    
    // Bind parameters
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':surname', $surname);
    $stmt->bindParam(':text', $reviewText);
    
    // Execute the statement
    $stmt->execute();
    
    // Set success response
    $response['success'] = true;
    $response['message'] = 'Grazie per la tua recensione! Sarà pubblicata dopo l\'approvazione.';
    
} catch (PDOException $e) {
    // Send generic error message to user
    $response['message'] = 'Si è verificato un errore durante il salvataggio della recensione. Riprova più tardi.';
} catch (Exception $e) {
    // Send generic error message to user
    $response['message'] = 'Si è verificato un errore imprevisto. Riprova più tardi.';
}

// Send JSON response
echo json_encode($response);
?>
