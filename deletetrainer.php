<?php
    include_once 'connectdb.php';

    // if(isset($_POST['deletetrainer']))
    if(isset($_POST['deletetcon']))
    {
         $id = $_GET["deletetrainer"];
        $id = $_POST["delete_tid"];
        $delete = "DELETE FROM `trainer` WHERE `trainer_id` = '$id'";
        $result=mysqli_query($conn, $delete);

        if($result) {
            echo '<script>alert("Record Deleted Successfully");</script>';
            header("Location: home.php");
        } else {
            echo "error".mysqli_error($conn);
        }
    }

?>