<?php

  require 'database.php';

  $message = '';

  if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $stmt->bindParam(':password', $password);

    if ($stmt->execute()) {
      $message = 'Successfully created new user';
    } else {
      $message = 'Sorry there must have been an issue creating your account';
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>SignUp</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body>
    <?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>

    <h1 class="text-center mt-5">SignUp</h1>
    <p class="text-center">or <a href="login.php">Login</a></p>
    <?php if(isset($_SESSION['user_id'])): ?>
      <p class="text-center">Your session is already open.</p>
    <?php endif; ?>
    <div class="row">
      <div class="col-lg-4 col-md-4 col-sm-12"></div>
      <div class="col-lg-4 col-md-4 col-sm-12">
        <form action="signup.php" method="POST">
          <fieldset class="form-group">
            <input name="email" class="form-control" type="text" placeholder="Enter your email">
          </fieldset>
          <fieldset class="form-group">
            <input name="password" type="password" class="form-control" placeholder="Enter your Password">
          </fieldset>
          <fieldset class="form-group">
            <input name="confirm_password" class="form-control" type="password" placeholder="Confirm Password">
          </fieldset>
          <input type="submit" class="btn btn-outline-primary btn-block" value="Submit">
        </form>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-12"></div>
    </div>

  </body>
</html>
