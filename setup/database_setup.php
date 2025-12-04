<?php
/**
 * Database Setup Script
 * Run this file once to set up or update the database structure
 */

require_once __DIR__ . '/../main.php';

echo "<h2>Database Setup</h2>";

try {
    $conn = getDBConnection();
    
    // Check and add resume column if missing
    echo "<p>Checking resume column...</p>";
    $result = $conn->query("SHOW COLUMNS FROM user_table LIKE 'resume'");
    
    if ($result->num_rows === 0) {
        $sql = "ALTER TABLE user_table ADD COLUMN resume VARCHAR(100) NULL AFTER profile_image";
        if ($conn->query($sql)) {
            echo "<p style='color: green;'>✓ Resume column added</p>";
        } else {
            echo "<p style='color: red;'>✗ Error adding resume column: " . $conn->error . "</p>";
        }
    } else {
        echo "<p style='color: green;'>✓ Resume column exists</p>";
    }
    
    // Fix foreign key constraints for cascade delete
    echo "<h3>Updating Foreign Keys...</h3>";
    
    $tables = ['workshop_table', 'studentwork_table'];
    
    foreach ($tables as $table) {
        echo "<p>Fixing $table...</p>";
        
        $result = $conn->query("SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE 
                                WHERE TABLE_SCHEMA = 'RootFlower' 
                                AND TABLE_NAME = '$table' 
                                AND REFERENCED_TABLE_NAME = 'user_table'");
        
        if ($result && $row = $result->fetch_assoc()) {
            $constraintName = $row['CONSTRAINT_NAME'];
            $conn->query("ALTER TABLE $table DROP FOREIGN KEY `$constraintName`");
            $conn->query("ALTER TABLE $table 
                          ADD CONSTRAINT `$constraintName` 
                          FOREIGN KEY (email) REFERENCES user_table(email) 
                          ON DELETE CASCADE ON UPDATE CASCADE");
            echo "<p style='color: green;'>✓ $table updated</p>";
        } else {
            echo "<p style='color: orange;'>⚠ No foreign key found for $table</p>";
        }
    }
    
    $conn->close();
    
    echo "<h3 style='color: green;'>✅ Database setup complete!</h3>";
    echo "<p><strong>You can now delete this setup folder.</strong></p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
}
?>
<style>
    body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; background: #f5f5f5; }
    h2 { color: #333; border-bottom: 2px solid #dc3545; padding-bottom: 10px; }
    p { background: white; padding: 10px; margin: 10px 0; border-radius: 5px; }
</style>
