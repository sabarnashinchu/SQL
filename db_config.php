<?php
// Prevent any unwanted output
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Database configuration file
$db_path = __DIR__ . '/../database/calculator.db';

// Create database directory if it doesn't exist
if (!file_exists(__DIR__ . '/../database')) {
    mkdir(__DIR__ . '/../database', 0777, true);
}

// Global connection variable
$db = null;

try {
    // Connect to SQLite database
    $db = new PDO('sqlite:' . $db_path);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create history table if it doesn't exist
    $db->exec('CREATE TABLE IF NOT EXISTS history (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        expression TEXT NOT NULL,
        result REAL NOT NULL,
        timestamp DATETIME DEFAULT CURRENT_TIMESTAMP
    )');
    
} catch(PDOException $e) {
    // Log error but don't output directly - will handle in the API endpoints
    error_log('Database Error: ' . $e->getMessage());
    $db = null;
}
?> 