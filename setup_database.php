<?php
// Database setup script for FitFuel
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Setting up FitFuel Database...\n";

try {
    // Connect to MySQL server (without database)
    $pdo = new PDO("mysql:host=localhost", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected to MySQL server successfully.\n";
    
    // Read and execute the schema file
    $schema = file_get_contents('database/schema.sql');
    
    // Split the schema into individual statements
    $statements = explode(';', $schema);
    
    foreach ($statements as $statement) {
        $statement = trim($statement);
        if (!empty($statement)) {
            $pdo->exec($statement);
        }
    }
    
    echo "Database schema created successfully.\n";
    echo "Sample data inserted successfully.\n";
    echo "\nDatabase setup completed!\n";
    echo "You can now run the PHP server using: php -S localhost:8000 server.php\n";
    
} catch (PDOException $e) {
    echo "Database setup failed: " . $e->getMessage() . "\n";
    echo "Please make sure:\n";
    echo "1. MySQL/XAMPP is running\n";
    echo "2. MySQL is accessible on localhost with root user\n";
    echo "3. No password is set for root user (or update config/database.php)\n";
}
?>
