<?php


$_pageName = "posting";
$_cookieValue = time();

function setPageVisitCookie($pageName) {
  $cookieName = 'page_visit_' . md5($pageName); 
  $startTime = time(); 
  setcookie($cookieName, $startTime, time() + (86400 * 30), "/"); 
}

function getPageVisitTime($pageName) {
  $cookieName = 'page_visit_' . md5($pageName);

  if (isset($_COOKIE[$cookieName])) {
      $startTime = $_COOKIE[$cookieName];
      $endTime = time();
      $timeSpent = $endTime - $startTime;
      return $timeSpent;
  } else {
      return null; 
  }
}

$currentPage = $_SERVER['REQUEST_URI'];

if (!isset($_COOKIE['page_visit_' . md5($currentPage)])) {
  setPageVisitCookie($currentPage);
}

$timeSpent = getPageVisitTime($currentPage);

echo "<script>";
echo " console.log('". $_pageName ."'); ";
echo "console.log('" . addslashes($timeSpent) . "');"; 
echo "console.log('timeSpend');";
echo "</script>";

//==========================================
$servername = "127.0.0.1";
$username = "hour"; 
$password = "123"; 
$dbname = "community";


$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
       
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        
        $title = $_POST['title'];
        $description = $_POST['description'];
        $url = $_POST['url'];
        
       
        $sql = "INSERT INTO posts (title, description, url) VALUES (:title, :description, :url)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':title' => $title,
            ':description' => $description,
            ':url' => $url
        ]);
        
        header("Location: index.php");
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
                <input type="url" id="url" name="url">
            </div>
            
            <button type="submit">Submit Post</button>
        </form>
    </div>
</body>
</html>