<?php
session_start();

require 'database.php';

// Function to generate a unique slug
function generateSlug() {
  global $conn;

  $maxAttempts = 10; // Maximum number of attempts to generate a unique slug
  $attempt = 0;

  do {
    $slug = substr(md5(uniqid(rand(), true)), 0, 6);
    $stmt = $conn->prepare('SELECT id FROM urls WHERE slug = :slug');
    $stmt->bindParam(':slug', $slug);
    $stmt->execute();

    $attempt++;
  } while ($stmt->fetch() && $attempt < $maxAttempts);

  if ($attempt === $maxAttempts) {
    // If we couldn't generate a unique slug after the maximum attempts, handle the error here
    die('Error: Unable to generate a unique slug.');
  }

  return $slug;
}

if (isset($_SESSION['user_id'])) {
  $records = $conn->prepare('SELECT id, email, password FROM users WHERE id = :id');
  $records->bindParam(':id', $_SESSION['user_id']);
  $records->execute();
  $results = $records->fetch(PDO::FETCH_ASSOC);

  $user = null;

  if (count($results) > 0) {
    $user = $results;
  }
}

if (!empty($_POST['url'])) {
  $long_url = $_POST['url'];
  $slug = generateSlug();

  $stmt = $conn->prepare('INSERT INTO urls (long_url, slug, user_id) VALUES (:long_url, :slug, :user_id)');
  $stmt->bindParam(':long_url', $long_url);
  $stmt->bindParam(':slug', $slug);
  $stmt->bindParam(':user_id', $_SESSION['user_id']);
  if ($stmt->execute()) {
    $short_url = "http://example.com/$slug"; // Replace "example.com" with your actual domain name.
    $message = "Short URL created successfully: <a href='$short_url' target='_blank'>$short_url</a>";
  } else {
    $message = 'Sorry, there was a problem creating the short URL.';
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Adrian URL Shortener</title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php if (!empty($user)): ?>
  <?php require 'partials/header.php' ?>
  <div class="container py-5">
    <h2>Your Short URLs</h2>
    <?php
      $urls = $conn->prepare('SELECT slug, long_url FROM urls WHERE user_id = :user_id');
      $urls->bindParam(':user_id', $_SESSION['user_id']);
      $urls->execute();
      $urls_result = $urls->fetchAll(PDO::FETCH_ASSOC);

      if (count($urls_result) > 0) {
        foreach ($urls_result as $url_item) {
          echo "
            <div class='card mb-4'>
              <div class='card-header'>
                Short URL: <a href='http://example.com/{$url_item['slug']}' target='_blank'>http://example.com/{$url_item['slug']}</a>
              </div>
              <div class='card-body'>
                Full URL: {$url_item['long_url']}
              </div>
            </div>
          ";
        }
      } else {
        echo "You haven't created any short URLs yet.";
      }
    ?>

    <!-- Add the form for URL shortener -->
    <form method="POST" class="mt-4">
      <div class="form-group">
        <label for="url">Enter the URL to shorten:</label>
        <input type="url" name="url" id="url" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary">Shorten URL</button>
    </form>
    <?php if (isset($message)): ?>
      <div class="alert alert-success mt-3">
        <?php echo $message; ?>
      </div>
    <?php endif; ?>
    <!-- End of form for URL shortener -->
  </div>
<?php else: ?>
  <!-- ... (existing code for the landing page) ... -->
<?php endif; ?>

<!-- Your footer and scripts -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
