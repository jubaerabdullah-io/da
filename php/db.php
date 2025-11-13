<?php
$servername = "localhost";  // usually 'localhost'
$username = "root";         // your MySQL username
$password = "Sifat_Ulalaa";             // your MySQL password
$dbname = "StatDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
