<?php 
    session_start();

    if(!isset($_SESSION['user_id'])){
        header("Location: index.php");
    } else {
        require 'database_s.php';

        $message = "";
        
        $character = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        $route_token = str_shuffle($character);
        echo "<br>";
        echo "<br>";
        $token = substr($route_token, -30);
    }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Welcome to you WebApp</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script>
        function makeid() {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";

        for (var i = 0; i < 5; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));

        return text;
        }

        console.log(makeid());
    </script>
  </head>
  <body>
    <div class="container">
      <h1>Let´s create a new verifier! 🙌🏼</h1>
      <hr>
      <p>Your new verifyer will only contain a reCaptcha, no publicity.</p>
      <div class="row">
        <div class="col-lg-5 col-md-4 col-sm-12">
            <form action="rake_migration.php" method="POST">
                <div class="form-group">
                    <label for="route">Your Token:</label>
                    <input type="text" readonly class="form-control" id="token" name="route">
                </div>
                <div class="form-gorup">
                    <label for="to">Where you are going to redirect people?</label>
                    <input type="text" name="heading" id="to" class="form-control" placeholder="Redirection link here...">
                </div>
                <input type="hidden" name="owner" value="<?= $_SESSION['user_email'] ?>">

                <button type="submit" class="btn btn-block btn-info mt-3">Let's Go!</button>
            </form>
        </div>
        <div class="col-lg-5 col-md-4 col-sm-12"></div>
        <div class="col-lg-2 col-md-4 col-sm-12"></div>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script>
        document.getElementById('token').value = makeid();
    </script>
  </body>
</html>