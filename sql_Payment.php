<?php
    include 'connectdb.php';
    session_start();

    if(isset($_POST['submitPayment'])){
        $reg_id = $_POST['payment_Id'];
        $method = $_POST['payment_method'];
        $totalPayable = (int)$_POST['paymentTotalPayable'];
        $payment = (int)$_POST['payment_amount'];
        $remaining = $totalPayable-$payment;
        $remarks = $_POST['payment_remarks'];
        $date = date('y-m-d h:i:s');
        // echo ($reg_id ." ID");

        if($totalPayable > 0){
            $query = "INSERT INTO `payment`(`reg_id`, `payment_amount`, `payment_type`, `remarks`, `date_issued`) VALUES ('$reg_id','$payment','$method','$remarks','$date')";
            $result = mysqli_query($conn, $query);   
            echo $query;
            if($result){
                echo '<script>alert("Record Saved Successfully");</script>';
                
                $query2 = "UPDATE `registration` SET remainingPayment='$remaining' WHERE reg_id='$reg_id'";
                $result2 = mysqli_query($conn, $query2);   
                
                if($result){
                    echo '<script>alert("Record Updated Successfully");</script>';
                    header("Location: home.php");
                }
                else{
                    echo '<script>alert("Failed to Update Record");</script>';
                }
            }
            else{
                echo '<script>alert("Failed to Save Record");</script>';
            }
        }
        else{
            echo '<script>alert("Record Not Updated");</script>';
            header("Location: home.php");
        }
    }


?>