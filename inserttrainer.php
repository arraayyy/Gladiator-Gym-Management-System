<?php
include_once "connectdb.php";

if(isset($_POST['savetrainer'])){
    $id = $_POST['trainerid'];
    $tname = $_POST['name'];
    $temail = $_POST['email'];
    $tcontact = $_POST['contact'];
    $trate = $_POST['rate'];

    $query = "INSERT INTO `trainer`(`trainer_id`, `trainer_name`, `trainer_email`,`trainer_contact`, `trainer_rate`) 
    VALUES ('$id','$tname','$temail','$tcontact','$trate')";
    $result = mysqli_query($conn, $query);   
    
    if($result){
        echo '<script>alert("Record Saved");</script>';
        header("Location: home.php");
    }
    else{
        echo '<script>alert("Failed to Save Record");</script>';
    }
}
    
?>