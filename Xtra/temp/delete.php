<?php
include 'config.php';


$id=$_GET['id'];

if(isset($id)){
    $delete = "UPDATE `customer` SET `is_deleted`=1 WHERE `customer_id` = $id ";

    $query = mysqli_query($conn,$delete);

    header('Location:../../home.php');
}


?>
