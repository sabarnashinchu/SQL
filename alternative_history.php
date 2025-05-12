<?php
// Test if SQLite3 class is available
if (class_exists('SQLite3')) {
    echo "SQLite3 class is available.<br>";
    
    try {
        // Create/open database
        $db = new SQLite3('database/calculator.db');
        echo "Database opened successfully.<br>";
        
        // Create table if not exists
        $db->exec('CREATE TABLE IF NOT EXISTS history (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            expression TEXT NOT NULL,
            result REAL NOT NULL,
            timestamp DATETIME DEFAULT CURRENT_TIMESTAMP
        )');
        echo "Table created or already exists.<br>";
        
        // Insert a test record
        $stmt = $db->prepare('INSERT INTO history (expression, result) VALUES (:expr, :result)');
        $stmt->bindValue(':expr', '2+2', SQLITE3_TEXT);
        $stmt->bindValue(':result', 4, SQLITE3_FLOAT);
        $stmt->execute();
        echo "Test record inserted.<br>";
        
        // Retrieve records
        $results = $db->query('SELECT * FROM history ORDER BY timestamp DESC LIMIT 10');
        echo "<h3>Recent Calculations:</h3>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Expression</th><th>Result</th><th>Timestamp</th></tr>";
        
        while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['expression'] . "</td>";
            echo "<td>" . $row['result'] . "</td>";
            echo "<td>" . $row['timestamp'] . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
        
        // Close the database
        $db->close();
        
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "SQLite3 is not available in this PHP installation.<br>";
    echo "PHP version: " . phpversion() . "<br>";
    echo "Loaded extensions: <br>";
    echo "<pre>";
    print_r(get_loaded_extensions());
    echo "</pre>";
}
?> 