<?php
require 'database.php';

if (isset($_GET['to'])) {
  $slug = $_GET['to'];
  $stmt = $conn->prepare('SELECT long_url FROM urls WHERE slug = :slug');
  $stmt->bindParam(':slug', $slug);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($result) {
    $fullUrl = $result['long_url'];
    header("Location: $fullUrl");
    exit();
  } else {
    die("Error: Short URL not found.");
  }
} else {
  die("Error: No short URL provided.");
}
?>
