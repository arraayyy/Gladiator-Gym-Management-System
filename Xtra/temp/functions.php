<!---------- TO CHECK LOGIN ---------->
<?php
    // include 'config.php';

    function check_login($conn){  

        if(isset($_SESSION['user_id'])){
            $id = $_SESSION['user_id'];
            $query = "SELECT * FROM user WHERE user_id = '$id' LIMIT 1";

            $result = mysqli_query($conn, $query);

            if($result && mysqli_num_rows($result) > 0 ){
                $user_data = mysqli_fetch_assoc($result);
                return $user_data;
            }
        }

        // redirect login
        header("Location: login.php");
        die;
    }

    // ADD CUSTOMER
   


?>
