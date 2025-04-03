<?php

$servername = "127.0.0.1";
$username = "hour"; 
$password = "123";
$dbname = "community";

header('Content-Type: application/json');

try {

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    

    $sql = "SELECT * FROM posts";
    $stmt = $conn->query($sql);
    
    // Fetch into arr
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    

    echo json_encode([
        'success' => true,
        'data' => $posts
    ]);
    
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}

$conn = null;
?>