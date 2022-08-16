<?php
    include_once 'connectdb.php';

    if(isset($_POST['deletepp']))
    {
        $id = $_POST["delete_ppid"];
        $delete = "DELETE FROM `package_plan` WHERE `package_plan_id` = '$id'";
        $result=mysqli_query($conn, $delete);

        if($result) {
            echo '<script>alert("Record Deleted Successfully");</script>';
            header("Location: home.php");
        } else {
            echo "error".mysqli_error($conn);
        }
    }
?>