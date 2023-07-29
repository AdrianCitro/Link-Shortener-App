<?php 
    session_start();

    require 'database_s.php';
    
    if(!isset($_SESSION['id'])){
        header("Location: index.php");
    } else {
        $query = "SELECT heading FROM redirections WHERE route='".$_GET['href']."'";
        if($result = mysqli_query($enlace, $query)){
            $fila = mysqli_fetch_array($result);
            $header = $fila['heading'];
            $_SESSION['header']=$header;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>StackFlow</title>
    <link rel="stylesheet" href="assets/css/style-mas.css">
</head>
<body>
    <center>
        <div class="logo">
            <p><span>Stack</span>Flow</p>
        </div>
        <h1>Just verifying that you are human...</h1>
        <form action="process.php" method="POST">
            <div required class="g-recaptcha" data-sitekey="6LdNZHsUAAAAACpUuw_2TxoTLaQsdkMPJtNVcjHZ"></div>
            <br/>
            <input type="submit" class="button" value="Submit">
        </form>
        <br>
        <p>You are being redirected to: <?= $header ?></p>
    </center>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</body>
</html>
</body>
</html>