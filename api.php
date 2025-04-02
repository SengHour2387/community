<?php

$servername = "127.0.0.1"; // As shown in the image
$username = "hour"; // Replace with your database username
$password = "123"; // Replace with your database password
$dbname = "community";

header('Content-Type: application/json');

try {
    // Create a PDO connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // SQL query to fetch all data from the posts table
    $sql = "SELECT * FROM posts";
    $stmt = $conn->query($sql);
    
    // Fetch all rows
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Return JSON response
    echo json_encode([
        'success' => true,
        'data' => $posts
    ]);
    
} catch (PDOException $e) {
    // Return error response
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}

$conn = null;
?>