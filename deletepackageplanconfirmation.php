<?php
include 'connectdb.php';

$id=$_GET['id'];

if(isset($id)){
    $delete = "DELETE FROM package_plan WHERE `package_plan_id` = $id ";

    $query = mysqli_query($conn,$delete);

    header('Location: home.php');
}


?>
