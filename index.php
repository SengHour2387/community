<html lang="en">

<?php
$_pageName = "index";
$_cookieValue = time();

function setPageVisitCookie($pageName) {
  $cookieName = 'page_visit_' . md5($pageName); // Unique cookie name
  $startTime = time(); // Current timestamp
  setcookie($cookieName, $startTime, time() + (86400 * 30), "/"); // Expires in 30 days
}

function getPageVisitTime($pageName) {
  $cookieName = 'page_visit_' . md5($pageName);

  if (isset($_COOKIE[$cookieName])) {
      $startTime = $_COOKIE[$cookieName];
      $endTime = time();
      $timeSpent = $endTime - $startTime;
      return $timeSpent;
  } else {
      return null; // Cookie not set
  }
}

$currentPage = $_SERVER['REQUEST_URI'];

if (!isset($_COOKIE['page_visit_' . md5($currentPage)])) {
  setPageVisitCookie($currentPage);
}

$timeSpent = getPageVisitTime($currentPage);

echo "<script>";
echo " console.log('". $_pageName ."'); ";
echo "console.log('" . addslashes($timeSpent) . "');"; // Important: Escape quotes
echo "console.log('timeSpend');";
echo "</script>";
?>  
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Community</title>
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <div id="navBar">
      <p>Community</p>
      <button id="btnAddPost" onclick="goToPostPage()">+</button>
    </div>
    <div class="postList"></div>
    <script src="post.js"></script>
  </body>
</html>
