<?php
// Basic error handling
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Check if SQLite is available
$sqlite_available = extension_loaded('pdo_sqlite');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculator with History</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Simple Calculator</h1>
        
        <?php if (!$sqlite_available): ?>
        <div class="error-message">
            <p>Warning: SQLite extension is not available. History functionality will not work correctly.</p>
        </div>
        <?php endif; ?>
        
        <div class="calculator">
            <div class="display">
                <input type="text" id="display" readonly>
            </div>
            <div class="buttons">
                <button class="btn clear" id="clear">C</button>
                <button class="btn operator" id="backspace">⌫</button>
                <button class="btn operator" id="divide">÷</button>
                <button class="btn operator" id="multiply">×</button>
                
                <button class="btn number" id="7">7</button>
                <button class="btn number" id="8">8</button>
                <button class="btn number" id="9">9</button>
                <button class="btn operator" id="subtract">-</button>
                
                <button class="btn number" id="4">4</button>
                <button class="btn number" id="5">5</button>
                <button class="btn number" id="6">6</button>
                <button class="btn operator" id="add">+</button>
                
                <button class="btn number" id="1">1</button>
                <button class="btn number" id="2">2</button>
                <button class="btn number" id="3">3</button>
                <button class="btn equals" id="equals">=</button>
                
                <button class="btn number zero" id="0">0</button>
                <button class="btn number" id="decimal">.</button>
            </div>
        </div>
        
        <div class="history-section">
            <h2>Calculation History</h2>
            <div id="history-container">
                <div id="history-list">
                    <p class="loading">Loading history...</p>
                </div>
            </div>
            <button id="clear-history">Clear History</button>
        </div>
    </div>
    
    <script src="script.js"></script>
</body>
</html> 