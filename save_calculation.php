<?php
// Prevent any output before setting headers
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Set content type to JSON
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Include database configuration
require_once 'db_config.php';

// Check if database connection was successful
if ($db === null) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

// Get the raw POST data and convert it to an associative array
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Check if required fields are present
if (!isset($data['expression']) || !isset($data['result'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required fields']);
    exit;
}

// Sanitize the input
$expression = htmlspecialchars($data['expression']);
$result = floatval($data['result']);

try {
    // Prepare SQL statement to insert calculation into database
    $stmt = $db->prepare('INSERT INTO history (expression, result) VALUES (:expression, :result)');
    
    // Bind parameters and execute
    $stmt->bindParam(':expression', $expression, PDO::PARAM_STR);
    $stmt->bindParam(':result', $result, PDO::PARAM_STR);
    $stmt->execute();
    
    // Get the ID of the inserted record
    $id = $db->lastInsertId();
    
    // Return success response
    echo json_encode([
        'success' => true,
        'id' => $id,
        'message' => 'Calculation saved successfully'
    ]);
    
} catch(PDOException $e) {
    error_log('Database Error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Failed to save calculation']);
    exit;
}
?> 