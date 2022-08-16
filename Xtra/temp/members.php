<?php

include 'config.php';
include 'functions.php';

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Members</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>  -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="dashboard_stylesheet.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link " aria-current="page" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="members.php">Customers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Membership</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Package Plan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Trainers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Users</a>
                    </li>
                </ul>
            </div>

            <a href="logout.php">
                <button class="btn btn-dark btn-outline-light" name="logout"  id="logout">
                    Logout
                </button>
            </a>
        </div>
    </nav>
    <div class="mainCard">
        <div class="p-3 card card-primary">
            <!-- CARD HEADER -->
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-10 col-12">
                        <h3 class="card-title">Customers</h3>
                    </div>
                    <div class="col-sm-2 col-12">
                        <div class="card-tools float-end">    
                            <a href="add_m.php" id="create_m" class="btn btm-sm btn-primary"><span class="fas fa-plus"> Add Members</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- CARD BODY -->
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 col-12">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered table-hover">
                            <colgroup>
                                <col width="5%">
                                <col width="15%">
                                <col width="20%">
                                <col width="30%">
                                <col width="15%">
                                <col width="15%">
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
                            <?php
                                $display = "SELECT* FROM `customer`";
                                $dis = mysqli_query($conn,$display); 
                                $count=1;        
                                if(mysqli_num_rows($dis)> 0){
                                    while($dis_row = mysqli_fetch_assoc( $dis)){
                            ?>
                            <tbody>
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
                                                <a class="btn btn-sm btn-warning" href="edit.php?id=<?php echo $dis_row['customer_id'] ?>">Edit</a>
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
                                                    <p>Name: <?php echo $dis_row['customer_fname']. " ". $dis_row['customer_mname']. " ".$dis_row['customer_lname'] ?></p>
                                                    <p>Gender: <?php echo $dis_row['customer_gender'] ?></p>
                                                    <p>Email: <?php echo $dis_row['customer_email'] ?></p>
                                                    <p>Contact: <?php echo $dis_row['customer_contact'] ?></p>
                                                    <p>Address: <?php echo $dis_row['customer_address'] ?></p>
                                                    <p>Package Plan: N/A</p>
                                                    <p>Trainer: N/A kay wala pas database </p>
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
                                                    <a class="btn btn-danger" href="delete.php?id=<?php echo $dis_row['customer_id']?>" name="">Delete</a>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                </div>
                                                </div>
                                            </div>
                                            </div>
                                        


                                        </div>

                                    </td>
                            </tbody>
                            <?php
                                        $count++;
                                    }
                                }
                                
                            ?>                   
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>