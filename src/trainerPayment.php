<?php
include_once "../connectdb.php";

if(isset($_POST['submit'])){
    $regId = $_POST['regId'];
    $customerId = $_POST['memberId'];
    $trainerId = $_POST['trainerNameDropdown'];
    $hours = $_POST['hoursSlider'];

    $query = "SELECT `trainer_rate`, `trainer_name` FROM trainer WHERE `trainer_id` = '$trainerId'";
    $row = mysqli_query($conn,$query);
    while($rows=$row->fetch_assoc()){
         $trainer = $rows;
    }
    $remarks = "Paid - ".$trainer['trainer_name']; 
    $total = $trainer["trainer_rate"] * $hours;
    $insertQuery = "INSERT INTO `payment`(`reg_id`, `customer_id`, `package_plan`, `payment_amount`, `remarks`, `date_issued`)
    VALUES ('$regId','$customerId','Trainer','$total' ,'$remarks', NOW())";
    $result = mysqli_query($conn,$insertQuery);
    if($result){
        echo '<script>alert("Record Saved");</script>';
        header("Location: ../home.php");
    }else{
        echo "Error: " . $insertQuery . ":-" . mysqli_error($conn);
        echo '<script>alert("Failed to Save Record");</script>';
    }
}
    
?>