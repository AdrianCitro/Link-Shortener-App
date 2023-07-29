<?php

  session_start();

  if (isset($_SESSION['user_id'])) {
    header('Location: /stackflow-2');
  }
  require 'database.php';

  if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $records = $conn->prepare('SELECT id, email, password FROM users WHERE email = :email');
    $records->bindParam(':email', $_POST['email']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $message = '';

    if (count($results) > 0 && password_verify($_POST['password'], $results['password'])) {
      $_SESSION['user_id'] = $results['id'];
      $_SESSION['user_email'] = $results['email'];
      header("Location: /stackflow-2");
    } else {
      $message = 'Sorry, those credentials do not match';
    }
  }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body>

    <?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>
    <?php if(isset($_SESSION['user_id'])): ?>
      <?php header("Location: index.php") ?>
    <?php endif; ?>
    <div class="container">
      <div class="mt-5"></div>
      <h1 class="text-center">Adrian<b>UrlShortener</b></h1>
      <h5 class="text-center">Login</h5>
      <p class="text-center">Welcome back 🙋‍♂️</p>
      <div class="mt-5"></div>
      <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12">

        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
          <form action="login.php" method="post">
            <fieldset class="form-group">
              <input type="text" name="email" id="email" placeholder="Email" class="form-control">
            </fieldset>
            <fieldset class="form-group">
              <input type="password" name="password" id="password" placeholder="Password" class="form-control">
            </fieldset>
            <button type="submit" class="btn btn-block btn-outline-primary">Login</button>
          </form>
          <p class="text-center mt-3">Don't have an account? <a href="signup.php">Sign Up</a></p>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
          
        </div>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="assets/js/bootstrap.min.js"></script>
  </body>
</html>
