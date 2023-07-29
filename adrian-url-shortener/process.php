<?php
    session_start();
    if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){
        print_r(var_dump($_POST));

        $secret = "6LdNZHsUAAAAAPw9MStxY1TZtaHATrA1v1OxxCPD";
        $ip = $_SERVER['REMOTE_ADDR'];

        $captcha = $_POST['g-recaptcha-response'];

        $result = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha&remoteip=$ip");
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        var_dump($result);

        $array = json_decode($result,TRUE);
        if($array["success"]){
            header("Location: ".$_SESSION['header']."");
        } else {
            header("Location: hi-robot.html");
        }
    } else {
        $message = "<h1 class='text-center'>You must comple the captcha!</h1>";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Stackflow</title>
    <link rel="stylesheet" href="assets/css/style-mas.css">
</head>
<body>
    <?php if(!empty($message)): ?>
    <div class='text-center'><img src="assets/robot.svg" class="icon" height="90px" alt="">
        <?= $message ?></div>
    <?php endif; ?>
</body>
</html>