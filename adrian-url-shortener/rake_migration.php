<?php 
    session_start();

    if(!isset($_SESSION['user_id']))
    {
        header("Location: index.php");
    } else {
        if(!empty($_POST['heading']))
        {
            require 'database_s.php';
            $heading = $_POST['heading'];
            
            $check_usr_type = "SELECT * FROM users WHERE id='".$_SESSION['user_id']."'";
            if($check_status = mysqli_query($enlace, $check_usr_type))
            {
                $fila = mysqli_fetch_array($check_status);
                $plan = $fila['account'];

                if($plan == 0)
                {
                    $see_all_veryfiers = "SELECT * FROM redirections WHERE owner='".$_SESSION['user_email']."'";
                    if($verif_plan = mysqli_query($enlace, $see_all_veryfiers))
                    {
                        if(mysqli_num_rows($verif_plan) >= 5)
                        {
                            $message = "You have 5 verifyers already!";
                        } else {
                            $insert = "INSERT INTO redirections (route, owner, heading) VALUES ('".$_POST['route']."', '".$_POST['owner']."', '".$heading."')";
                            if(mysqli_query($enlace, $insert))
                            {
                                echo "if 2";
                                echo "Your verificator has been applied!";
                                header("Location: index.php");
                            }
                        }
                    }
                }
                elseif ($plan == 1) 
                {
                    $see_all_veryfiers2 = "SELECT * FROM redirections WHERE owner='".$_SESSION['user_emial']."'";
                    if($check_verifyers2 = mysqli_query($enlace, $see_all_veryfiers2))
                    {
                        if(mysqli_num_rows($check_verifyers2) >= 15)
                        {
                            $message = "You have 15 verifyers already!";
                        } else {
                            $insert2 = "INSERT INTO redirections (route, owner, heading) VALUES ('".$_POST['route']."', '".$_POST['owner']."', '".$heading."')";
                            if(mysqli_query($enlace, $insert2))
                            {
                                echo "if 3";
                                echo "Your verificator has been applied!";
                                header("Location: index.php");
                            } else {
                                echo "Error creating this verifyer";
                            }
                        }
                    }
                } elseif ($plan == 2)
                {
                    $insert_plan_business = "SELECT * FROM redirections WHERE owner='".$_SESSION['user_emial']."'";
                    if($check_plan_business = mysqli_query($enlace, $insert_plan_business))
                    {
                        echo "Added succesfully";
                    }
                }
            }
        }
            /*$query = "SELECT * FROM redirections WHERE route='".$_POST['route']."'";
            if($result = mysqli_query($enlace, $query))
            {
                echo "if 1";
                if(mysqli_num_rows($result) > 0)
                {
                    echo "error 1";
                    $message = "Sorry, we´ve made a mistake during the process 🤦🏼‍";
                } else {
                    echo "error 2";
                    $insert = "INSERT INTO redirections (route, owner, heading) VALUES ('".$_POST['route']."', '".$_POST['owner']."', '".$heading."')";
                    if(mysqli_query($enlace, $insert)){
                        echo "if 2";
                        echo "Your verificator has been applied!";
                        header("Location: index.php");
                    }
                }
            }*/
        }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Oops</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12"></div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <?php if(!empty($message)): ?>
                <?= "<center><img src='assets/robot.svg' height='80' class='mt-5' alt='Bot' /></center>" ?>
                <?= "<h1 class='text-center'>Oops!</h1>" ?>
                <?= "<h5 class='text-center'>$message</h5>" ?>
                <?= "<center><a href='upgrade.php' class='btn btn-outline-primary text-center mt-2'>Upgrade my plan</a></center>" ?>
            <?php endif; ?>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12"></div>
    </div>
</body>
</html>