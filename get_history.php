<?php
// Prevent any output before setting headers
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Set content type to JSON
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// Only allow GET requests
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
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

try {
    // Prepare SQL statement to get history records ordered by most recent first
    $stmt = $db->prepare('SELECT id, expression, result, timestamp FROM history ORDER BY timestamp DESC LIMIT 50');
    $stmt->execute();
    
    // Fetch all records as an associative array
    $history = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Return the history data as JSON
    echo json_encode($history);
    
} catch(PDOException $e) {
    error_log('Database Error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Failed to retrieve calculation history']);
    exit;
}
?> 