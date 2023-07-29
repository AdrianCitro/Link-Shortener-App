<?php 
    require 'database_s.php';

    if(isset($_SESSION['user_id']))
    {
        header("Location: index.php");
    } else {
        $route_to_delete = $_POST['route_id'];

        $query = "SELECT * FROM redirections WHERE route='".$route_to_delete."'";
        if($result = mysqli_query($enlace, $query))
        {
            if(mysqli_num_rows($result) > 0)
            {
                $delete = "DELETE FROM redirections WHERE route='".$route_to_delete."'";
                if(mysqli_query($enlace, $delete))
                {
                    echo "Deleted successfully route ".$route_to_delete;
                } else {
                    echo "Error while deleting the route".$route_to_delete;
                }
            } else {
                echo "Sorry, we couldn't find the route ".$route_to_delete;
            }
        }
    }


?>