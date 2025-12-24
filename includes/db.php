<?php
/**
 * Database Connection Configuration
 * 
 * Establishes MySQL database connection for the Nebula Security Labs application.
 * This file is included by all pages that need database access.
 * 
 * WARNING: This configuration uses default XAMPP credentials for local development.
 * In production, use secure credentials and store them in environment variables.
 */

// Database connection parameters
$servername = "localhost";  // MySQL server address
$username = "root";          // MySQL username (default XAMPP)
$password = "";              // MySQL password (empty for default XAMPP)
$dbname = "vulnweb";         // Database name

// Establish MySQL connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check if connection was successful
if (!$conn) {
    die("DB connection failed: " . mysqli_connect_error());
}
?>