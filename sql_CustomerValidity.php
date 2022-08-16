<?php
    include 'connectdb.php';

    if(isset($_POST['addNewCusValBtn'])){
        $member = $_POST['addNewCusVal_member'];
        $package = $_POST['addNewCusVal_package'];
        $packagePayment;
        $sDate = $_POST['addNewCusVal_startDate'];
        $checkUserQueue =  "SELECT customer_queue FROM `customer` WHERE `customer_id` = $member";
        $result_row = mysqli_query($conn,$checkUserQueue);
        $result = mysqli_fetch_assoc($result_row);

        if($result['customer_queue']==0){
            $packagePayment1 = "SELECT * FROM `package_plan` WHERE `package_plan_id` = $package";
            $packagePayment2 = mysqli_query($conn,$packagePayment1);
            
            if(mysqli_num_rows($packagePayment2)> 0){
                while($packagePayment_row = mysqli_fetch_assoc($packagePayment2)){
                    $packagePayment = $packagePayment_row['package_plan_amount'];
                }
            }

            $plan1 = "SELECT * FROM `package_plan` WHERE `package_plan_id` = $package";
            $plan2 = mysqli_query($conn,$plan1);
            
            if(mysqli_num_rows($plan2)> 0){
                while($plan_row = mysqli_fetch_assoc($plan2)){
                    $days = $plan_row['numdays'];
                }
            }
            $eDate = date('Y-m-d', strtotime($sDate. ' + '.$days.' days'));

            $checkLastQueue =  "SELECT COUNT(*) FROM `registration` WHERE `customer_id` = $member AND customer_queue != -1";
            $result_row = mysqli_query($conn,$checkLastQueue);
            $result = mysqli_fetch_assoc($result_row);
            $count = $result['COUNT(*)'] + 1;
            $queue_update = "UPDATE customer SET customer_queue = $count WHERE customer_id = $member"; 
            $result = mysqli_query($conn,$queue_update);        

            $query = "INSERT INTO `registration`(`customer_id`, `customer_queue`, `package_plan_id`, `start_date`, `end_date`, `remainingPayment`, `status`) 
            VALUES ('$member','$count','$package','$sDate','$eDate','$packagePayment','1')";
            $result = mysqli_query($conn, $query);   
            
            $regId = mysqli_insert_id($conn);
            $checkPackage =  "SELECT `package_plan_type` FROM `package_plan` WHERE `package_plan_id` = $package";
            $result_row = mysqli_query($conn,$checkPackage);
            $result = mysqli_fetch_assoc($result_row);
            $packagePlan = $result['package_plan_type'];
            

            $query = "INSERT INTO `payment`(`reg_id`, `customer_id`, `package_plan`, `payment_amount`, `remarks`, `date_issued`)
            VALUES ('$regId','$member','$packagePlan','$packagePayment','Paid',NOW())";
            $result = mysqli_query($conn,$query);
            if($result){
                echo '<script>alert("Record Saved Successfully");</script>';
                echo '<script>setTimeout(function(){location.href="home.php"} , 100);</script>';
            }
            else{
                echo '<script>alert("Failed to Save Record");</script>';
                echo '<script>setTimeout(function(){location.href="home.php"} , 100);</script>';
            }
        }else{
            echo '<script>alert("Customer is already a member!");</script>';
            echo '<script>setTimeout(function(){location.href="home.php"} , 100);</script>';
        }
    }

    if(isset($_POST['delCustomValBtn'])){
        $customer_id = $_POST['delCustomVal'];
        // echo $reg_id;

        
        $query = "UPDATE customer SET customer_queue = 0 WHERE customer_id = $customer_id";
        $result = mysqli_query($conn, $query);   
        
        if($result){
            echo '<script>alert("Record Deleted Successfully");</script>';
            echo '<script>setTimeout(function(){location.href="home.php"} , 100);</script>';
        }
        else{
            echo '<script>alert("Failed to Save Record");</script>';
            echo '<script>setTimeout(function(){location.href="home.php"} , 100);</script>';
        }
    }

    if(isset($_POST['updatePlan'])){
        $reg_id = $_POST['updateId'];
        $status = $_POST['updateStatus'];
        // echo $status;

        if($status == 1){
            $status = 0;
        }
        else{
            $status = 1;
        }

        
        $query = "UPDATE `registration` SET `status`='$status' WHERE `reg_id` = $reg_id";
        $result = mysqli_query($conn, $query);   
        
        if($result){
            echo '<script>alert("Record Deleted Successfully");</script>';
            header("Location: home.php");
        }
        else{
            echo '<script>alert("Failed to Save Record");</script>';
        }
    }
    
    if(isset($_POST['extendPlanBtn'])){
        $valid = true;
        $customer_id = $_POST['extendMemberId'];
        $package_id = $_POST['extendPlan_package'];
        $start_date = $_POST['extend_startDate'];
        $reg_id = $_POST['extendRegID'];

        $package_query = "SELECT * FROM `package_plan` WHERE `package_plan_id` = $package_id";
        $package_data = mysqli_query($conn,$package_query);
        $check_queue =  "SELECT COUNT(*) FROM registration WHERE `customer_id` = $customer_id AND customer_queue != -1";
        $check_data = mysqli_query($conn,$check_queue);
        $check = mysqli_fetch_assoc($check_data);
        $customer_queue = "SELECT customer_queue FROM customer WHERE `customer_id` = $customer_id";
        $customer_data = mysqli_query($conn,$customer_queue);
        $customer = mysqli_fetch_assoc($customer_data);
        $customer_queue = $customer["customer_queue"];
        $next_queue = $customer_queue + 1;

        $query = "SELECT * FROM registration WHERE customer_id = $customer_id AND customer_queue = $customer_queue";
        $row = mysqli_query($conn,$query);
        $data = mysqli_fetch_assoc($customer_data);

        if($check['COUNT(*)']==$customer["customer_queue"]){
            if(mysqli_num_rows($package_data)> 0){
                $package = mysqli_fetch_assoc($package_data);

                $reg_query = "SELECT * FROM `registration`
                    WHERE `customer_id` = $customer_id AND customer_queue != -1
                    ORDER BY `end_date` DESC";
                if ($reg_data = mysqli_query($conn,$reg_query)) {
                    $row = mysqli_fetch_assoc($reg_data);
                    $total_payment = $package['package_plan_amount'];
                    $new_end_date = date('Y-m-d', strtotime($start_date.' + '.$package['numdays'].' days'));
                    $customer_queue = mysqli_num_rows($reg_data);
                    $extension_query = sprintf(
                        "INSERT INTO `registration`(`customer_id`, `package_plan_id`, `customer_queue`, `start_date`, `end_date`, `remainingPayment`, `status`) 
                        VALUES ('%s','$package_id','$next_queue','$start_date','$new_end_date','$total_payment','1')",
                        $row['customer_id'],
                        $row['end_date']
                    );
                    $result = mysqli_query($conn, $extension_query);
                    $reg_query = "SELECT * FROM `registration` INNER JOIN `package_plan` ON package_plan.package_plan_id = registration.package_plan_id ORDER BY registration.reg_id DESC";
                    $reg_data = mysqli_query($conn,$reg_query);
                    $reg_row = mysqli_fetch_assoc($reg_data);

                    $reg_id = $reg_row['reg_id'];
                    $customer_id = $reg_row['customer_id'];
                    $package_plan = $reg_row['package_plan_type'];
                    $payment_amount = $reg_row['package_plan_amount'];
                    $remarks = "Paid";
                    $is_refunded = '0';
                    $payment_query = "INSERT INTO `payment`(`reg_id`, `customer_id`, `package_plan`, `payment_amount`, `remarks`, `is_refunded`)
                    VALUES ('$reg_id','$customer_id','$package_plan','$payment_amount','$remarks' ,'$is_refunded')";
                    $result = mysqli_query($conn, $payment_query);
                }   
            }
            if($result){
                echo '<script>alert("Successfully extended plan!");</script>';
                echo '<script>setTimeout(function(){location.href="home.php"} , 100);</script>';
            }
            else{
                echo '<script>alert("Failed to extend plan!");</script>';
                echo '<script>setTimeout(function(){location.href="home.php"} , 100);</script>';
            }
        }
        else{
            echo '<script>alert("Customer already has a pending plan");</script>';
            echo '<script>setTimeout(function(){location.href="home.php"} , 100);</script>';
        }
    }
?>