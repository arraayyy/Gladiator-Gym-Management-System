<?php
    session_start();

    include("connectdb.php");


        $uname = $_POST['username'];
        $pword = $_POST['password'];

        if(!empty($uname) && !empty($pword)){  

            $query = "SELECT * FROM `user` WHERE `user_type` = 1 limit 1"; 
            
            $result = mysqli_query($conn, $query); 


            if($result){  
                if(mysqli_num_rows($result) > 0 ){ 
                    $user_data = mysqli_fetch_assoc($result); 
                    
                    if($user_data['user_password'] === $pword && $user_data['user_username'] === $uname){  
                        $_SESSION['user_id'] = $user_data['user_id'];  
                        header("Location: home.php"); 
                        die;
                    }else{
                        echo "<script> 
                        alert('Incorrect Username or Password')
                        window.location.replace('index.php');
                        </script>";
                    }
                }
            }
        } else {
            echo '<script>alert("Please Enter Valid Information")</script>';
        }

?>
