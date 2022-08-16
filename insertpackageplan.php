<?php
include_once "connectdb.php";

if(isset($_POST['savepp'])){
    $id = $_POST['ppid'];
    $ppname = $_POST['package_plan'];
    $numdays = $_POST['numdays'];
    $desc = $_POST['description'];
    $amount = $_POST['amount'];

    $query = "INSERT INTO `package_plan`(`package_plan_id`, `package_plan_type`, `numdays`, `package_plan_desc`, `package_plan_amount`) 
    VALUES ('$id','$ppname','$numdays','$desc','$amount')";
    $result = mysqli_query($conn, $query);   
    
    if($result){
        echo '<script>alert("Record Saved Successfully");</script>';
        header("Location: home.php");
    }
    else{
        echo '<script>alert("Failed to Save Record");</script>';
    }
}
    
?>