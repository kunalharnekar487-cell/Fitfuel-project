<?php
include 'database.php';

if ($conn) {
    echo "✅ Database connection successful!";
} else {
    echo "❌ Connection failed!";
}
?>
