<?php
include_once "connectdb.php";
// $id = $_GET['editpp'];
if(isset($_POST['updatepp'])){
    $id = $_POST['update_ppid'];

    $ppname = $_POST['ppname'];
    $ppdesc = $_POST['ppdescription'];
    $ppdays = $_POST['ppdays'];
    $ppamount = $_POST['ppamount'];

    $query = "UPDATE `package_plan` 
    SET package_plan_type='$ppname', numdays='$ppdays', package_plan_desc='$ppdesc', package_plan_amount='$ppamount' 
    WHERE package_plan_id='$id'";
    $result = mysqli_query($conn, $query);   
    
    if($result){
        echo '<script>alert("Record Updated Successfully");</script>';
        header("Location: home.php");
    }
    else{
        echo '<script>alert("Failed to Update Record");</script>';
    }
}
    
?>