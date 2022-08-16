<?php
    // session_start();

    include_once "connectdb.php";
    // function check_login($conn){

    //     if(isset($_SESSION['user_id'])){
    //         $id = $_SESSION['user_id'];
    //         $check = "select * from user where user_id = '$id' limit 1";

    //         $result = mysqli_query($conn, $check);

    //         if($result && mysqli_num_rows($result) > 0 ){
    //             $user_data = mysqli_fetch_assoc($result);
    //             return $user_data;
    //         }
    //     }

    //     header("Location: loginpage.php");
    //     die;
    // }
    // $user_data = check_login($conn);
    session_start();

    date_default_timezone_set('Hongkong');

    if(@$_SESSION['paymentAlert']){
        echo '<script>alert("'.$_SESSION['paymentAlert'].'")</script>';
        unset($_SESSION['paymentAlert']);
    }

    $customer_query = $conn->query("SELECT * FROM customer WHERE is_deleted = 0");
    while($row_customer=$customer_query->fetch_assoc()):
        $customer_queue = $row_customer['customer_queue'];
        $next_customer_queue = $customer_queue + 1;
        $customer_id = $row_customer['customer_id'];
        $registration_query = $conn->query("SELECT * FROM registration WHERE customer_queue = $customer_queue AND customer_id = $customer_id");
        $queue_query =  $conn->query("SELECT * FROM registration WHERE customer_queue = $customer_queue AND customer_id = $customer_id AND CURDATE() >= `start_date` AND CURDATE() <= `end_date`");
        if(mysqli_num_rows($registration_query) > 0) {
            $registration_row = $registration_query->fetch_assoc();
            if($registration_row["end_date"] < date('Y-m-d')) {
                $check_query = $conn->query("SELECT * FROM registration WHERE customer_queue = $next_customer_queue AND customer_id = $customer_id");
                if(mysqli_num_rows($check_query) > 0) {
                    $query = "UPDATE customer SET customer_queue = '$next_customer_queue' WHERE `customer_id` = $customer_id";
                    mysqli_query($conn, $query);
                }
                $queue_query =  $conn->query("SELECT * FROM registration WHERE customer_queue = $next_customer_queue AND customer_id = $customer_id AND CURDATE() >= `start_date` AND CURDATE() <= `end_date`");
            }
        }

        if(mysqli_num_rows($queue_query) > 0) {
            $cust_active_query =  $conn->query("UPDATE `customer` SET `is_active`= 1 WHERE customer_id=$customer_id");
        } else {
            $cust_expired_query = $conn->query("UPDATE `customer` SET `is_active`= 0 WHERE customer_id=$customer_id");
        }

        if($customer_queue == 0) {
            $cust_expired_query = $conn->query("UPDATE `customer` SET `is_active`= 0 WHERE customer_id=$customer_id");
        }
        
    endwhile;

    $trainer_query = $conn->query("SELECT * FROM trainer ORDER BY trainer_id ASC");
    while($row_trainer=$trainer_query->fetch_assoc()):
       $row_trainers[] = $row_trainer;
    endwhile;

    $active_query =  $conn->query("SELECT COUNT(*) FROM customer WHERE is_active = 1 AND is_deleted = 0");
    $active_row = $active_query->fetch_assoc();
    $count_active = $active_row['COUNT(*)'];
?>

<!DOCTYPE HTML>  
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS and JS-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
  
    <!-- <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <title>Gladiator Gym</title>
    <link rel="stylesheet" href="Xtra/temp/dashboard_stylesheet.css">
    <style>
        td{
            vertical-align: middle !important;
        }

        .admin {
            width:3vw;
            margin:auto;
            border-radius:20px;
        }

        .package {
            white-space: nowrap;
        }


    </style>
</head>
<body>
<div>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-4 text-center mt-4">
                <h1>Gladiator Gym</h1>
                <hr>    
                    
                <h4 class="text-muted"><?php echo "Admin Page"?></h4>
        </div>

        
        <div class="container">
            <div class="btn-group dropleft float-end">
                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="admin.png" alt="Profile icon" class="admin" id="admin">
                </button>
                <div class="dropdown-menu text-center">
                    <a href="admin.php" class="link-dark dropdown-item" style="text-decoration:none;"><i class="fa-solid fa-user"></i>&emsp;Profile</a>
                    <a href="logout.php" class="link-dark dropdown-item" style="text-decoration:none;"><i class="fa fa-sign-out" aria-hidden="true"></i> Log Out</a>
                </div>
                
            </div>

        </div>

    </div>
    <hr>
    <br>
    
    <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="true">Home</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#customer" type="button" role="tab" aria-controls="customer" aria-selected="false">Customer</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="display-tab" data-bs-toggle="tab" data-bs-target="#customerValidity" type="button" role="tab" aria-controls="customerValidity" aria-selected="false">Subscription</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="plans-tab" data-bs-toggle="tab" data-bs-target="#plans" type="button" role="tab" aria-controls="plans" aria-selected="false">Package Plan</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="trainers-tab" data-bs-toggle="tab" data-bs-target="#trainers" type="button" role="tab" aria-controls="trainers" aria-selected="false">Trainers</button>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent" style="text-align:center">
        <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="plan-tab">
            <div class="container homeBox">
                <br>
                <h4>Welcome back Administrator<?php //echo ; ?>!</h4>
                <hr>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-4 col-xs-12">
                            <div class="container box1">
                                <i class="fas fa-users"></i>
                                <?php
                                        $active = $conn->query("SELECT COUNT(*) FROM `customer` WHERE is_deleted = 0");
                                        $active_count = $active->fetch_assoc();
                                        $count = $active_count['COUNT(*)'];
                                ?>
                                <h5> <?php echo $count; ?> </h5>
                                <h5>Total Customers</h5>
                            </div>
                        </div>
                        
                        <div class="col-sm-4 col-xs-12">
                            <div class="container box2">
                                <i class="fas fa-th-list"></i>
                                <h5> <?php echo $count_active; ?></h5>
                                <h5>Total Active Members</h5>
                            </div>
                        </div>
                        
                        <div class="col-sm-4 col-xs-12">
                            <div class="container box3">
                                <i class="fas fa-list"></i>
                                <?php
                                    $packageCounter = 0;
                                        $package = "SELECT * FROM `package_plan`";
                                        $pack = mysqli_query($conn,$package);        
                                        if(mysqli_num_rows($pack)> 0){
                                            while($pack_row = mysqli_fetch_assoc($pack)){
                                                $packageCounter++;
                                            }
                                        }
                                ?>
                                <h5> <?php echo $packageCounter++; ?></h5>
                                <h5>Total Packages</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="customer" role="tabpanel" aria-labelledby="plan-tab">
            <div class="mainCard">
                <div class="p-3 card card-primary border border-0">
                    <!-- CARD HEADER -->
                    <div class="card-header bg-white border border-0">
                        <div class="row">
                            <div class="col-sm-10 col-12">
                                <h3 class="card-title text-left">Customers</h3>
                            </div>
                            <div class="col-sm-2 col-12">
                                <div class="card-tools float-end">    
                                    <a href="Xtra/temp/add_m.php" id="create_m" class="btn btm-sm btn-primary"><span class="fas fa-plus"> Add Members</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- CARD BODY -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-12">
                            <div class="">
                                <table class="table" id="table_id" class="display" >
                                    <colgroup>
                                        <col width="5%">
                                        <col width="15%">
                                        <col width="20%">
                                        <col width="25%">
                                        <col width="15%">
                                        <col width="20%">
                                    </colgroup>
                                    <thead>
                                        <tr class="text-center">
                                            <th>#</th>
                                            <th>Customer ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Contact</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $display = "SELECT* FROM `customer` WHERE is_deleted = 0";  
                                        $dis = mysqli_query($conn,$display); 
                                        $count=1;         
                                        if(mysqli_num_rows($dis)> 0){ 
                                            while($dis_row = mysqli_fetch_assoc( $dis)){ 
                                    ?>
                                    
                                        <tr>
                                            <td class="text-center"><?php echo  $count?></td>
                                            <td class="text-center"><?php echo $dis_row['customer_id'];?></td>
                                            <td><?php echo $dis_row['customer_fname'].' '. $dis_row['customer_mname'].' '.$dis_row['customer_lname']; ?></td>
                                            <td><?php echo $dis_row['customer_email']; ?></td>
                                            <td><?php echo $dis_row['customer_contact']; ?></td>
                                            <td align="center">
                                                <div class="row">
                                                    <!-- <div class="col-md-3">
                                                        <a class="btn btn-sm btn-primary" href="view.php?id=<?php echo $dis_row['customer_id'] ?>"> View</a>
                                                    </div>      &nbsp; -->
                                                    <div class="col-md-3">
                                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#viewmodal<?php echo $dis_row['customer_id'] ?>">View</button>
                                                    </div> &nbsp;
                                                    <div class="col-md-3">
                                                        <a class="btn btn-sm btn-warning" href="Xtra/temp/edit.php?id=<?php echo $dis_row['customer_id'] ?>">Edit</a>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal<?php echo $dis_row['customer_id'] ?>">Delete</button>
                                                    </div>

                                                    <!-- View Modal -->
                                                    <div class="modal fade" id="viewmodal<?php echo $dis_row['customer_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="modal<?php echo $dis_row['customer_id'] ?>" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Customer Details</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <table class="table">
                                                                        <tbody>
                                                                            <tr>
                                                                                <th scope="row">Name:</th>
                                                                                <td><?php echo $dis_row['customer_fname']. " ". $dis_row['customer_mname']. " ".$dis_row['customer_lname'] ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Gender:</th>
                                                                                <td><?php echo $dis_row['customer_gender'] ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Age:</th>
                                                                                <td><?php echo $dis_row['customer_age'] ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">BMI:</th>
                                                                                <td><?php echo $dis_row['customer_bmi'] ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Email:</th>
                                                                                <td><?php echo $dis_row['customer_email'] ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Contact:</th>
                                                                                <td><?php echo $dis_row['customer_contact'] ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Address:</th>
                                                                                <td><?php echo $dis_row['customer_address'] ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                            <tr>
                                                                                <th scope="row">Health Condition:</th>
                                                                                <td><?php 
                                                                                        if($dis_row['customer_health'] == "NULL"){
                                                                                            echo "None";
                                                                                        } else {
                                                                                            echo $dis_row['customer_health'];
                                                                                        }
                                                                                    ?>
                                                                                </td>
                                                                            </tr>
                                                                            </tr>
                                                                            
                                                                            
                                                                            
                                                                        </tbody>
                                                                    </table>
                                                                    <!-- <p>Name: <?php echo $dis_row['customer_fname']. " ". $dis_row['customer_mname']. " ".$dis_row['customer_lname'] ?></p>
                                                                    <p>Gender: <?php echo $dis_row['customer_gender'] ?></p>
                                                                    <p>Email: <?php echo $dis_row['customer_email'] ?></p>
                                                                    <p>Contact: <?php echo $dis_row['customer_contact'] ?></p>
                                                                    <p>Address: <?php echo $dis_row['customer_address'] ?></p>
                                                                    <p>Package Plan: N/A</p>
                                                                    <p>Trainer: N/A kay wala pas database </p> -->
                                                                </div>
                                                                <div class="modal-footer">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Delete Modal -->
                                                    <div class="modal fade" id="modal<?php echo $dis_row['customer_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="modal<?php echo $dis_row['customer_id'] ?>" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure you want to delete this record?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <a class="btn btn-danger" href="Xtra/temp/delete.php?id=<?php echo $dis_row['customer_id']?>" name="">Delete</a>
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                


                                                </div>

                                            </td>
                                        </tr>
                                    
                                    <?php
                                                $count++;
                                            }
                                        }
                                        
                                    ?>  
                                    </tbody>                 
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="customerValidity" role="tabpanel" aria-labelledby="plan-tab">
            <div class="container ">
                <div class="customValidHeader d-flex bd-highlight mb-3">
                    <h3 class="me-auto p-2 bd-highlight">Customer and Subscriptions</h3>
                    <div>
                        <button type="button" class="btn btn-primary addTransacBtn" data-toggle="modal" data-target="#paymentDetails">Payment Details</button>
                        <button
                            type="button" 
                            class="btn btn-success addTransacBtn pb-2"
                            data-bs-toggle="modal" 
                            data-bs-target="#addNewCusVal"><span class="fas fa-plus">
                            New
                            </span>
                        </button>
                    </div>
                    

                        <!-- Modal for Payment Details -->
                        <div class="modal fade" id="paymentDetails" tabindex="-1" role="dialog" aria-labelledby="paymentDetailsTitle" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="paymentDetailsTitle">Payment Details</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table display" id="payment_table">
                                            <colgroup>
                                                <col width="30%">
                                                <col width="20%">
                                                <col width="20%">
                                                <col width="10%">
                                                <col width="20%">
                                            </colgroup>
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Customer Name</th>
                                                    <th>Amount</th>
                                                    <th>Package</th>
                                                    <th>Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                            $paymentSQL= "SELECT * FROM `payment`";
                                            $result = mysqli_query($conn,$paymentSQL);
                                            while($result_row = mysqli_fetch_assoc($result)){
                                                $customer_id = $result_row["customer_id"];
                                                $customername_query = "SELECT * FROM `customer` WHERE customer_id = '$customer_id'";
                                                $customer_rows = mysqli_query($conn,$customername_query);
                                                $customer_row = mysqli_fetch_assoc($customer_rows);
                                                ?>
                                                
                                                <tr> 
                                                    <th><?php echo $result_row["date_issued"] ?></th>
                                                    <th><?php echo ($customer_row['customer_fname']." ".$customer_row['customer_lname']) ?></th>
                                                    <th><?php echo $result_row["payment_amount"] ?></th>
                                                    <th><?php echo ucfirst($result_row["package_plan"]) ?></th>
                                                    <th><?php echo ucfirst($result_row["remarks"]) ?></th>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="customValidBody">
                    <div class="table-responsive">
                        <table class="table table-hover" id="table_id1" class="display">
                            <thead style="text-align: center;">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col" >Member ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Plan</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                    $validity = "SELECT * FROM (SELECT * FROM customer WHERE is_deleted = 0) AS cus
                                        LEFT JOIN registration ON registration.customer_id = cus.customer_id AND registration.customer_queue = cus.customer_queue
                                        -- INNER JOIN `trainer` ON registration.trainer_id = trainer.trainer_id 
                                        INNER JOIN `package_plan` ON registration.package_plan_id = package_plan.package_plan_id 
                                        ORDER BY registration.reg_id";
                                    $val = mysqli_query($conn,$validity);
                                    
                                    $count=1;         
                                    if(mysqli_num_rows($val)> 0){
                                        while($val_row = mysqli_fetch_assoc($val)){
                                ?>
                                        <tr>
                                            <th scope="row"><?php echo $count++; ?></th>
                                            <td><?php echo $val_row['customer_id']; ?></td>
                                            <td><?php echo ($val_row['customer_fname']." ".$val_row['customer_lname']); ?></td>
                                            <td><?php echo ($val_row['package_plan_type']); ?></td>                                         
                                            <td>
                                                <?php 
                                                    if(strtotime(date("Y/m/d")) < strtotime($val_row['start_date'])) {
                                                        echo '<span class="customerValidityStatus1" style="background-color: #f0ad4e;">Pending</span>' ;
                                                    } else if(strtotime(date("Y/m/d")) < strtotime($val_row['end_date'])) {
                                                        echo '<span class="customerValidityStatus1">Active</span>' ;
                                                    } else {
                                                        echo '<span class="customerValidityStatus2">Expired</span>'; 
                                                    }                                                                                  
                                                ?>
                                            </td>

                                            <td>    
                                                <button 
                                                    type="button"
                                                    class="btn btn-outline-primary "
                                                    data-toggle="modal" 
                                                    data-target="#viewCusVal-<?php echo $val_row['reg_id']; ?>"
                                                    >
                                                    Details
                                                </button>

                                                <div class="modal fade" id="viewCusVal-<?php echo $val_row['reg_id']; ?>" tabindex="-1" aria-labelledby="viewCusValLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"><i class="fa-solid fa-address-card mr-2"></i> Member Plan Details</h5>
                                                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body" style="text-align:left;">
                                                                <h3>Current Plan:</h3>
                                                                <input type="hidden" name="rowModalId" value="<?php echo $val_row['reg_id']; ?>"/>
                                                                <p>Member ID: <b><?php echo $val_row['customer_id']; ?></b></p>
                                                                <p>Name: <b></b><?php echo ($val_row['customer_fname']." ".$val_row['customer_lname']); ?></p>
                                                                <p>Plan: <b><?php echo $val_row['package_plan_type']; ?></b></p>
                                                                <p>Start Date: <b><?php echo $val_row['start_date']; ?></b></p>
                                                                <p>End Date: <b><?php echo $val_row['end_date']; ?></b></p>
                                                                <hr class="my-3">
                                                                <p>Plan Membership Fee: <b id="modalPlanFee"><?php echo $val_row['package_plan_amount']; ?></b></p>
                                                                <hr class="my-3">
                                                                <h3>Pending Plans:</h3>
                                                                <?php 
                                                                    $customerId = $val_row['customer_id'];
                                                                    $customerQueue = $val_row['customer_queue'];
                                                                    $detailsSQL = "SELECT * FROM ( SELECT * FROM registration WHERE registration.customer_queue > '$customerQueue' AND registration.customer_id = '$customerId') AS reg 
                                                                    LEFT JOIN package_plan ON package_plan.package_plan_id = reg.package_plan_id";
                                                                    $result = mysqli_query($conn,$detailsSQL);        
                                                                    while($result_row = mysqli_fetch_assoc($result)){
                                                                        ?>
                                                                        <p>Plan: <b><?php echo $result_row['package_plan_type']; ?></b></p>
                                                                        <p>Start Date: <b><?php echo $result_row['start_date']; ?></b></p>
                                                                        <p>End Date: <b><?php echo $result_row['end_date']; ?></b></p>
                                                                        <br>
                                                                <?php } ?>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form action="sql_CustomerValidity.php" method="post">
                                                                    <input type="hidden" name="updateId" value="<?php echo $val_row['reg_id']; ?>"/>
                                                                    <input type="hidden" name="updateStatus" value="<?php echo $val_row['status']; ?>"/>
                                                                    <!-- <button type="submit" name="updatePlan" id="updatePlan" class="btn btn-primary">Update Plan</button> -->
                                                                </form>
                                                                <!-- <button type="button" class="btn btn-primary" data-dismiss="modal" data-bs-toggle="modal" data-bs-target="#paymentModal" onclick="paymentTable()">Payment</button> -->
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <button 
                                                    id="<?php echo ($val_row['reg_id']."-extend"); ?>"
                                                    data-memberId="<?php echo $val_row['customer_id']; ?>"
                                                    data-regId = "<?php echo $val_row['reg_id']; ?> "
                                                    data-dateEnd = "<?php echo $val_row['end_date'] ?>"
                                                    type="button" 
                                                    class="btn btn-outline-secondary"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#extendPlan"
                                                    onclick="extendFunc(id)"
                                                    >
                                                    Extend
                                                </button>

                                                <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#paymentDetails-<?php echo $val_row['reg_id'] ?>">Payment Details</button>
                                              
                                                <!-- Modal for Payment Details -->
                                                <div class="modal fade" id="paymentDetails-<?php echo $val_row['reg_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="paymentDetailsTitle-<?php echo $val_row['reg_id'] ?>" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="paymentDetailsTitle-<?php echo $val_row['reg_id'] ?>">Payment Details</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body p-0">
                                                                
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Date</th>
                                                                            <th>Amount</th>
                                                                            <th>Package</th>
                                                                            <th>Remarks</th>
                                                                            <th></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <?php 
                                                                
                                                                    $customerID = $val_row['customer_id'];
                                                                    $paymentSQL= "SELECT * FROM `payment` WHERE customer_id = '$customerID'";
                                                                    $result = mysqli_query($conn,$paymentSQL);
                                                                    

                                                                    while($result_row = mysqli_fetch_assoc($result)){
                                                                        $reg_id = $result_row['reg_id'];
                                                                        $regSQL = "SELECT * FROM `registration` WHERE reg_id = '$reg_id'";
                                                                        $reg_result = mysqli_query($conn,$regSQL);
                                                                        $reg_result_row = mysqli_fetch_assoc($reg_result);
                                                                        ?>
                                                                        <form action="src/refundPayment.php" method="POST">
                                                                            <input type="hidden" name="payment_id" value="<?php echo $result_row["payment_id"] ?>"/>
                                                                            <input type="hidden" name="reg_id" value="<?php echo $result_row["reg_id"] ?>"/>
                                                                            <input type="hidden" name="customer_id" value="<?php echo $result_row["customer_id"] ?>"/>
                                                                            <tr> 
                                                                                <th><?php echo $result_row["date_issued"] ?></th>
                                                                                <th><?php echo $result_row["payment_amount"] ?></th>
                                                                                <th><?php echo ucfirst($result_row["package_plan"]) ?></th>
                                                                                <th><?php echo ucfirst($result_row["remarks"]) ?></th>
                                                                                <th><button name="submit" value="submit" type="submit" class="btn btn-danger btn-lg <?php if($result_row["is_refunded"] == 1 || date('Y-m-d', strtotime($reg_result_row['start_date'] . ' +1 day')) < date('Y-m-d', time())) { echo 'disabled'; } ?>" role="button" aria-disabled="true">Refund</button></th>
                                                                            </tr>
                                                                        </form>
                                                                    <?php } ?>
                                                                    </tbody>
                                                                </table> 
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                       

                                                
                                                <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#trainerModal-<?php echo $val_row['reg_id'] ?>">Trainer</button>

                                                <!-- Modal for Trainer -->
                                                <div class="modal fade" id="trainerModal-<?php echo $val_row['reg_id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle-<?php echo $val_row['reg_id'] ?>">Trainer</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="src/trainerPayment.php" method="POST">
                                                            <div class="modal-body">
                                                                <div class="mb-3" style="text-align: left;">
                                                                        <input name="regId" type="hidden" value="<?php echo $val_row['reg_id'] ?>">
                                                                        <input name="memberId" type="hidden" value="<?php echo $val_row['customer_id'] ?>">
                                                                        <label class="form-label">Select Trainer</label>
                                                                        <select class="form-control" name="trainerNameDropdown" required>
                                                                        <option value="" disabled selected>Select Trainer</option>
                                                                        <?php
                                                                            for($key=0; $key < count($row_trainers); $key++){
                                                                        ?>     
                                                                            <option value="<?php echo $row_trainers[$key]['trainer_id'] ?>"><?php echo $row_trainers[$key]['trainer_name'] ?></option>
                                                                        <?php } ?>
                                                                        </select>
                                                                        <label class="form-label mt-3">Workout Hours</label>
                                                                        <div class="input-group">
                                                                            <input name="hoursSlider" type="range" class="form-range" value="1" min="0.5" max="24" step="0.5" oninput="this.nextElementSibling.value = this.value">
                                                                            <output>1</output>
                                                                            <label>&nbsp:&nbspHours</label>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" name="submit" value="submit" class="btn btn-primary">Apply</button>
                                                            </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>

                                                <button 
                                                    type="button" 
                                                    id="<?php echo $val_row['reg_id']; ?>"
                                                    class="btn btn-outline-danger"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#delCusVal"
                                                    data-id="<?php echo $val_row['reg_id']; ?>"
                                                    data-memberId="<?php echo $val_row['customer_id']; ?>"
                                                    onclick="delFunc(id)">
                                                    Delete
                                                </button>
                                            </td>
                                            <!-- <td>
                                                <?php 
                                                    echo ($val_row['remainingPayment'] > 0) ? 
                                                        '<button type="button" class="btn btn-warning" disabled>Not Yet Fully Paid</button>' : 
                                                        '<button type="button" class="btn btn-success" disabled>Fully Paid</button>'; 
                                                ?>
                                            </td> -->
                                        </tr>
                                
                                <?php
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="plans" role="tabpanel" aria-labelledby="plan-tab">
        
            <div class="container">
                <div class="d-flex bd-highlight mb-3">
                    <h3 class="me-auto p-2 bd-highlight">Package Plan List</h3>
                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addPackagePlanModal"><span class="fas fa-plus">
                    Add Package Plan
                    </button>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card border border-0">
                    <div class="card-header bg-white border border-0">
                                <!-- <b class="h2 float-left">Package Plan List</b> -->
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <colgroup>
                                <col width="5%">
                                <col width="20%">
                                <col width="25%">
                                <col width="20%">
                                <col width="20%">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Package Plans</th>
                                    <th class="text-center">Description</th>
                                    <th class="text-center">Amount</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i = 1;
                                    $package = $conn->query("SELECT * FROM package_plan ORDER BY package_plan_id ASC");
                                    while($row=$package->fetch_assoc()):
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $i++ ?></td>
                                    <td>
                                    <p>Package Plan: <b><?php echo $row['package_plan_type'] ?></b></p>
                                    </td>
                                    <td>
                                        <p> <small><b><?php echo $row['package_plan_desc'] ?></b></small></p>
                                    </td>
                                    <td class="text-center">
                                        <b>Php <?php echo number_format($row['package_plan_amount'],2) ?></b>
                                    </td>
                                    <td align="center">
                                        <div class="row text-center align-items-center justify-content-center">
                                            <div class="col-md-3">
                                                <a href="editpackageplan.php?editpp=<?php echo $row['package_plan_id']; ?>">
                                                    <input type="button" class="btn btn-primary" name="editpp"  id="editpp"  value="Edit" >
                                                </a>  
                                            </div>
                                            <div class="col-md-3">
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#pmodal<?php echo $row['package_plan_id']; ?>">Delete</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Delete modal for package plan -->
                                <div class="modal fade" id="pmodal<?php echo $row['package_plan_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="modal<?php echo $row['package_plan_id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete this package?
                                        </div>
                                        <div class="modal-footer">
                                            <a class="btn btn-danger" href="deletepackageplanconfirmation.php?id=<?php echo $row['package_plan_id'];?>" name="">Delete</a>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>           
                                
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>	    
        
        <div class="tab-pane fade" id="trainers" role="tabpanel" aria-labelledby="trainers-tab">
            <br>
            <div class="container">
                <div class="d-flex bd-highlight mb-3">
                    <h3 class="me-auto p-2 bd-highlight">List of Trainers</h3>
                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addTrainerModal"><span class="fas fa-plus">
                    Add Trainer
                    </button>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border border-0">

                            <div class="card-body">
                                <table class="table table-bordered table-hover">

                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Information</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $x = 1;
                                        $trainer = $conn->query("SELECT * FROM trainer ORDER BY trainer_id ASC");
                                        while($row=$trainer->fetch_assoc()):
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $x++ ?></td>
                                            <td class="">
                                            <p><i class="fa fa-user"></i> <b><?php echo $row['trainer_name'] ?></b></p>
                                            <p><small><i class="fa fa-at"></i> <b><?php echo $row['trainer_email'] ?></b></small></p>
                                            <p><small><i class="fa fa-phone-square-alt"></i> <b><?php echo $row['trainer_contact'] ?></b></small></p>
                                            <p><small><i class="fa fa-money-bill"></i> <b>Php <?php echo number_format($row['trainer_rate'],2) ?></b></small></p>
                                            </td>
                                            <td class="text-center">
                                                <a href="edittrainer.php?edittrainer=<?php echo $row['trainer_id']; ?>">
                                                    <input type="button" class="btn btn-primary" name="edittrainer"  id="edittrainer"  value="Edit" >
                                                </a>  
                                                <div class="col p-3">
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#dmodal<?php echo $row['trainer_id']; ?>">Delete</button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- DELETE MODAL FOR TRAINER -->
                                        <div class="modal fade" id="dmodal<?php echo $row['trainer_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="modal<?php echo $row['trainer_id']; ?>" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this trainer?
                                                </div>
                                                <div class="modal-footer">
                                                    <a class="btn btn-danger" href="deletetrainerconfirmation.php?id=<?php echo $row['trainer_id'];?>" name="">Delete</a>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                            </div>
                                        </div>         
                                        
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
        <hr>                                   
    </div>
    

</div>
<script>
    function viewFunc(id){
        const btn = document.getElementById(id);
        const modalId = btn.getAttribute('id'); //reg_id
        const memberId = btn.getAttribute('data-memberId'); //cutomer_id
        const memberName = btn.getAttribute('data-memberName');
        const plan = btn.getAttribute('data-plan');
        const planFee = btn.getAttribute('data-planFee');
        const trainer = btn.getAttribute('data-trainer');
        const trainerFee = btn.getAttribute('data-trainerFee');
        const status = btn.getAttribute('data-status');
        const startDate = btn.getAttribute('data-sDate');
        const endDate = btn.getAttribute('data-eDate');

        sessionStorage.setItem("modalId", modalId);
        sessionStorage.setItem("memberId", memberId);
        sessionStorage.setItem("memberName", memberName);
        sessionStorage.setItem("plan", plan);
        sessionStorage.setItem("planFee", planFee);
        sessionStorage.setItem("trainer", trainer);
        sessionStorage.setItem("trainerFee", trainerFee);
        sessionStorage.setItem("startDate", startDate);
        sessionStorage.setItem("endDate", endDate);

        document.getElementById("rowModalId").value = modalId;
        document.getElementById("updateId").value = modalId;
        document.getElementById("modalId").innerHTML = memberId;
        document.getElementById("modalName").innerHTML = memberName;
        document.getElementById("modalPlan").innerHTML = plan;
        document.getElementById("modalPlanFee").innerHTML = planFee;
        document.getElementById("updateStatus").value = status;
        document.getElementById("sDate").innerHTML = startDate;
        document.getElementById("eDate").innerHTML = endDate;

        document.getElementById("paymentPackagePlanFee").innerHTML = "Php. " + planFee + ".00";
        document.getElementById("paymentPackagePlanFeeInput").value = parseInt(planFee);
        
        document.getElementById("paymentTrainerFee").innerHTML = "Php. " + trainerFee + ".00";
        document.getElementById("paymentTrainerFeeInput").value = parseInt(trainerFee);

        document.getElementById("totalPayable").innerHTML = "Php. " + (parseInt(planFee)+parseInt(trainerFee)) + ".00";
        document.getElementById("paymentTotalPayable").value = (parseInt(planFee)+parseInt(trainerFee));
    }

    function extendFunc(id){
        const btn = document.getElementById(id);
        const regID = btn.getAttribute('data-regId')
        const dateEnd = btn.getAttribute('data-dateEnd')
        const memberId = btn.getAttribute('data-memberId'); //reg_id
        var date = new Date(dateEnd)
        date.setDate(date.getDate() + 1);
        date = formatDate(date)
        document.getElementById("extendRegID").value = regID;
        document.getElementById("extendMemberId").value = memberId;
        document.getElementById("extendDate").value = date;

    }
    
    const formatDate = (date) => {
        let d = new Date(date);
        let month = (d.getMonth() + 1).toString();
        let day = d.getDate().toString();
        let year = d.getFullYear();
        if (month.length < 2) {
            month = '0' + month;
        }
        if (day.length < 2) {
            day = '0' + day;
        }
        return [year, month, day].join('-');
    }

    function delFunc(id){
        const btn = document.getElementById(id);
        const customerId = btn.getAttribute('data-memberId');


        document.getElementById("delCustomVal").value = customerId;
    }

    function closemodal(){
        $('.modal').modal('hide') // closes all active pop ups.
        $('.modal-backdrop').remove() // removes the grey overlay.
    }

    $(document).on("click", "#open-viewDialog", function () {
        // var myBookId = $(this).data('id');
        var ModalId = $(this).data('modalId');
        // console.log($(this).data('modalId'));
        // $(".modal-body #rowModalId").val( ModalId );
    });

    function paymentTable(){
        console.log(sessionStorage.getItem("modalId", modalId));
    }
    
</script>
<?php include('addpackageplanmodal.php'); ?>
<?php include('addtrainermodal.php'); ?>
</body>

<!-- Add Cutomer Validity Modal -->
<div class="modal fade" id="addNewCusVal" tabindex="-1" aria-labelledby="addNewCusVal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">+ New Membership Plan </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="sql_CustomerValidity.php" method="post">
            <div class="mb-3">
                <label for="addNewCusVal_member" class="form-label">Member</label>
                <select class="form-select" id="addNewCusVal_member" name="addNewCusVal_member"  required>
                    <option value="none" selected disabled>Select Customer...</option>
                <?php
                    $customer = "SELECT * FROM `customer` WHERE is_deleted = 0";
                    $cus = mysqli_query($conn,$customer);        
                    if(mysqli_num_rows($cus)> 0){
                        while($cus_row = mysqli_fetch_assoc($cus)){
                ?>
                            <option value="<?php echo ($cus_row['customer_id']); ?>"><?php echo ($cus_row['customer_fname']." ".$cus_row['customer_lname']); ?></option>
                <?php 
                        }
                    }
                ?>
                    </select>
            </div>
            <div class="mb-3">
                <label for="addNewCusVal_package" class="form-label">Package</label>
                <select class="form-select" id="addNewCusVal_package" name="addNewCusVal_package"  required>
                    <option value="none" selected disabled>Select Package...</option>
                <?php
                    $customer = "SELECT * FROM `package_plan`";
                    $cus = mysqli_query($conn,$customer);        
                    if(mysqli_num_rows($cus)> 0){
                        while($cus_row = mysqli_fetch_assoc($cus)){
                ?>
                            <option value="<?php echo $cus_row['package_plan_id']; ?>"><?php echo $cus_row['package_plan_type']; ?></option>
                <?php 
                        }
                    }
                ?>
                    </select>
            </div>  
            <div class="mb-3">
                <label for="addNewCusVal_startDate" class="form-label">Start Date</label>
                <input type="date" value ="" class="form-control" name="addNewCusVal_startDate" id="addNewCusVal_startDate">
            </div>
            <!-- <div class="mb-3">
                <label for="addNewCusVal_endDate" class="form-label">End Date</label>
                <input type="date" class="form-control" name="addNewCusVal_endDate" id="addNewCusVal_endDate">
            </div> -->


            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="addNewCusValBtn" class="btn btn-primary">Add</button>
            </div>
        </form>
      </div>
      
    </div>
  </div>
</div>

<!-- View Cutomer Validity Modal -->
<!-- <div class="modal fade" id="viewCusVal" tabindex="-1" aria-labelledby="viewCusValLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fa-solid fa-address-card mr-2"></i> Member Plan Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h3>Current Plan:</h3>
        <input type="hidden" name="rowModalId" id="rowModalId" value=""/>
        <p>Member ID: <b id="modalId"></b></p>
        <p>Name: <b id="modalName"></b></p>
        <p>Plan: <b id="modalPlan"></b></p>
        <p>Start Date: <b id="sDate"></b></p>
        <p>End Date: <b id="eDate"></b></p>
        <hr class="my-3">
        <p>Plan Membership Fee: <b id="modalPlanFee"></b></p>
      </div>
      <div class="modal-footer">
        <form action="sql_CustomerValidity.php" method="post">
            <input type="hidden" name="updateId" id="updateId" value=""/>
            <input type="hidden" name="updateStatus" id="updateStatus" value=""/> -->
            <!-- <button type="submit" name="updatePlan" id="updatePlan" class="btn btn-primary">Update Plan</button> -->
        <!-- </form> -->
        <!-- <button type="button" class="btn btn-primary" data-dismiss="modal" data-bs-toggle="modal" data-bs-target="#paymentModal" onclick="paymentTable()">Payment</button> -->
        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> -->

<!-- Delete Cutomer Validity Modal -->
<div class="modal fade" id="delCusVal" tabindex="-1" aria-labelledby="delCusValLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Membership Plan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="sql_CustomerValidity.php" method="post">
        <div class="modal-body">
            <h6>Are you sure you want to delete? </h6>
            <input type="hidden" id="delCustomVal" name="delCustomVal" value="" />
        </div>
        <div class="modal-footer">
            <button type="submit" name="delCustomValBtn" value="sumbit" class="btn btn-danger">Delete</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>



<!-- Extend Cutomer Validity Modal FInal -->
<div class="modal fade" id="extendPlan" tabindex="-1" aria-labelledby="extendPlanLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="extendPlanLabel">+ New Membership Plan </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
  
        <form action="sql_CustomerValidity.php" method="POST">
            <div class="mb-3">
                <label for="extendPlan_package" class="form-label">Extend by:</label>
                <input type="hidden" id="extendRegID" name="extendRegID" value="" />
                <!-- PACKAGE -->
                <select class="form-select" id="extendPlan_package" name="extendPlan_package" required>
                <option value="" disabled selected>Select your Package</option>
                <?php
                    $extension_query = "SELECT * FROM `package_plan`";
                    $package = mysqli_query($conn,$extension_query);        
                        while($package_row = mysqli_fetch_assoc($package)){
                            $row[] = $package_row;
                        }
                       for($x = 0; $x < count($row); $x++){
                ?>
                    <option value="<?php echo $row[$x]["package_plan_id"]; ?>"><?php echo $row[$x]["package_plan_type"]  ?></option>
                <?php 
                       }
                       
                ?>

                </select>
            </div>
         
            <div class="mb-3">
                <label for="extend_startDate" class="form-label">Start Date</label>
                <input type="date" value="" id="extendDate" class="form-control" name="extend_startDate" required>
            </div>
            
            <input type="hidden" id="extendMemberId" name="extendMemberId" value="" />
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" value="submit" name="extendPlanBtn" class="btn btn-primary">Extend</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModal" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">PAYMENT</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick=closemodal()></button>
      </div>
      <div class="modal-body">
        <div class="container">
            <div class="">
                <form action="sql_Payment.php" method="post">
                    <h6><b>New Payment</b></h6>
                    <div class="mb-3">
                        <!-- <span class="d-flex justify-content-between"><p>Plan Membership Fee:</p><p><b>Php. 1000.00</b></p></span> -->
                        <input type="hidden" id="rowModalId" name="rowModalId" value="">
                        <span class="d-flex justify-content-between"><p>Package Plan Amount:</p><p><b id="paymentPackagePlanFee"></b></p></span>
                        <input type="hidden" id="paymentPackagePlanFeeInput" name="paymentPackagePlanFeeInput" value="">
                        <span class="d-flex justify-content-between"><p>Trainer Fee:</p><p><b id="paymentTrainerFee"></b></p></span>
                        <input type="hidden" id="paymentTrainerFeeInput" name="paymentTrainerFeeInput" value="">
                    </div>
                    <div class="mb2">
                        <span class="d-flex justify-content-between"><p>Reamining Amount To Pay:</p><p><b id="totalPayable"></b></p></span>
                        <!-- <span class="d-flex justify-content-between">
                            <p>Reamining Amount To Pay:</p>
                            <p>
                                <b>
                                    <?php 
                                        // $trainerPayment1 = "SELECT * FROM `trainer` WHERE `trainer_id` = $trainer";
                                        // $trainerPayment2 = mysqli_query($conn,$trainerPayment1);
                                        
                                        // if(mysqli_num_rows($trainerPayment2)> 0){
                                        //     while($trainerPayment_row = mysqli_fetch_assoc($trainerPayment2)){
                                        //         $trainerPayment = $trainerPayment_row['trainer_rate'];
                                        //     }
                                        // }
                                    ?>
                                </b>
                            </p>
                        </span> -->
                        <input type="hidden" id="paymentTotalPayable" name="paymentTotalPayable" value="">
                    </div>
                    <div class="mb-3">
                        <label for="payment_amount" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="payment_amount" name="payment_amount" required>
                    </div>
                    <div class="mb-3">
                    <label for="payment_method" class="form-label">Payment Method</label>
                        <select class="form-select" aria-label="Default select example" id="payment_method" name="payment_method">
                            <option selected>Open this select mode of payment</option>
                            <option value="1">Bank Transfer: BPI</option>
                            <option value="2">Bank Transfer: BDO</option>
                            <option value="3">Gcash</option>
                            <option value="4">Pay Physically</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="payment_remarks" class="form-label">Remarks</label>
                        <div class="form-floating">
                            <textarea class="form-control" id="payment_remarks" name="payment_remarks" required></textarea>
                        </div>
                    </div>
                    <button type="submit" name="submitPayment"class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick=closemodal()>Close</button>
      </div>
    </div>
  </div>

  <!-- Extend Cutomer Validity Modal -->
<!-- <div class="modal fade" id="extendPlan" tabindex="-1" aria-labelledby="extendPlanLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="extendPlanLabel">+ New Membership Plan </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="sql_CustomerValidity.php" method="put">
            <div class="mb-3">
                <label for="extendPlan_package" class="form-label">Extend by:</label>
                <select class="form-select" id="extendPlan_package" name="extendPlan_package"  required>
                    <option value="none" selected disabled>Select Package...</option>
                <?php
                    $extension_query = "SELECT * FROM `package_plan`";
                    $package = mysqli_query($conn,$extension_query);        
                    if(mysqli_num_rows($package)> 0){
                        while($package_row = mysqli_fetch_assoc($package)){
                ?>
                            <option value="<?php echo $package_row['package_plan_id']; ?>"><?php echo $cus_row['package_plan_type']; ?></option>
                <?php 
                        }
                    }
                ?>
                    </select>
            </div>
            <input type="hidden" id="extendMemberId" name="extendMemberId" value="" />

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="extendPlanBtn" class="btn btn-primary">Extend</button>
            </div>
        </form>
      </div>
      
    </div>
  </div>
</div> -->
  
</div>
</html>

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
<script>
    $(document).ready( function () {
    $('#table_id').DataTable({
        "autoWidth" : false,
        "columnDefs": [
            { "orderable": false, "targets": 0 },
            { "orderable": false, "targets": 5 }
        ]
    });

    $('#table_id1').DataTable({
        "autoWidth" : false,
        "columnDefs": [
            { "orderable": false, "targets": 0 },
            { "orderable": false, "targets": 5 }
        ]

    });
    $(document).ready( function () {
        $('#payment_table').DataTable();
        
    });
});
</script>
