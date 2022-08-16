<?php
include_once "connectdb.php";
// $id = $_GET['edittrainer'];
if(isset($_POST['updatetrainer'])){
     $id = $_POST['update_trainerid'];

    $tname = $_POST['tname'];
    $temail = $_POST['temail'];
    $tcontact = $_POST['tcontact'];
    $trate = $_POST['trate'];

    $query = "UPDATE `trainer` 
    SET trainer_name='$tname', trainer_email='$temail', trainer_contact='$tcontact', trainer_rate='$trate' 
    WHERE trainer_id='$id'";
    $result = mysqli_query($conn, $query);   
    
    if($result){
        echo '<script>alert("Record Updated");</script>';
        header("Location: home.php");
    }
    else{
        echo '<script>alert("Failed to Update Record");</script>';
    }
}
    
?>