<?php
// Database connection file
$host = 'localhost';
$user = '23CS156';
$password = 'Harsha@4304'; // Set your MySQL password here
$dbname = 'salary_management_system';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
