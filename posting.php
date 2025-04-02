<?php
// Database connection parameters
$servername = "127.0.0.1";
$username = "hour"; // Replace with your database username
$password = "123"; // Replace with your database password
$dbname = "community";

// Initialize variable for error message
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Create a PDO connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Get form data
        $title = $_POST['title'];
        $description = $_POST['description'];
        $url = $_POST['url'];
        
        // Prepare and execute SQL statement
        $sql = "INSERT INTO posts (title, description, url) VALUES (:title, :description, :url)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':title' => $title,
            ':description' => $description,
            ':url' => $url
        ]);
        
        // Redirect to index.html after successful submission
        header("Location: index.html");
        exit();
        
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
    
    $conn = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Post</title>
    <style>
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input, textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .message {
            margin: 10px 0;
            padding: 10px;
            background-color: #f2dede;
            color: #a94442;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add New Post</h2>
        
        <?php if ($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required>
            </div>
            
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="url">URL:</label>
                <input type="url" id="url" name="url" required>
            </div>
            
            <button type="submit">Submit Post</button>
        </form>
    </div>
</body>
</html>