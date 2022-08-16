<?php
include_once "../connectdb.php";

if(isset($_POST['submit'])){

    $paymentId = $_POST['payment_id'];
    $regId = $_POST['reg_id'];
    $customerId = $_POST['customer_id'];

    $query = "UPDATE payment SET is_refunded = 1, remarks='Refunded' WHERE payment_id = $paymentId";
    $result = mysqli_query($conn,$query);

    $query = "UPDATE registration SET customer_queue = -1 WHERE reg_id = $regId";
    $result = mysqli_query($conn, $query);

    $checkQuery = "SELECT COUNT(*) FROM registration WHERE customer_id = $customerId AND customer_queue != -1";
    $result_row = mysqli_query($conn, $checkQuery);
    $check = $result_row->fetch_assoc();
    $count = $check['COUNT(*)'];
    $next_count = $count + 1;
    $query = "UPDATE registration SET customer_queue = $count WHERE customer_queue = $next_count AND customer_id = $customerId";
    $result = mysqli_query($conn, $query);
    $query = "UPDATE customer SET customer_queue = $count WHERE customer_id = $customerId";
    $result = mysqli_query($conn, $query);

    if($result){
        echo '<script>alert("Record Saved");</script>';
        header("Location: ../home.php");
    }else{
        echo "Error: " . $query . ":-" . mysqli_error($conn);
        echo '<script>alert("Failed to Save Record");</script>';
    }
}
    
?>
