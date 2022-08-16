<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="dashboard_stylesheet.css">

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- fontawesone -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <title>Dashboard</title>
</head>
<body>
    <section id="headNavbar">
        <nav class="navbar navbar-dark bg-primary">
            <div class="container-fluid ">
                <a class="navbar-brand px-5" href="#dashboard.php">
                Gym Management System
                </a>
            </div>
        </nav>
    </section>
    <section id="dashboardContent">
        <div class="dashboardContentContainer">
            <div class="row outerRow">
                <div class="col-2 dashboardBtn">
                    <ul class="nav flex-column mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"><i class="fas fa-home"></i>Home</button>
                            
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-members-tab" data-bs-toggle="pill" data-bs-target="#pills-members" type="button" role="tab" aria-controls="pills-members" aria-selected="false"><i class="fas fa-user-friends"></i>Customers</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-membership-tab" data-bs-toggle="pill" data-bs-target="#pills-membership" type="button" role="tab" aria-controls="pills-membership" aria-selected="false"><i class="fas fa-id-card"></i>Membership</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-plans-tab" data-bs-toggle="pill" data-bs-target="#pills-plans" type="button" role="tab" aria-controls="pills-plans" aria-selected="false"><i class="fas fa-th-list"></i>Package Plan</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-trainers-tab" data-bs-toggle="pill" data-bs-target="#pills-trainers" type="button" role="tab" aria-controls="pills-trainers" aria-selected="false"><i class="fas fa-user"></i>Trainers</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-users-tab" data-bs-toggle="pill" data-bs-target="#pills-users" type="button" role="tab" aria-controls="pills-users" aria-selected="false"><i class="fas fa-users"></i>Users</button>
                        </li>
                    </ul>
                </div>
                <div class="col-10">
                    <div class="tab-content " id="pills-tabContent">
                        <div class="tab-pane fade show active dashBoardMainBox" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="container homeBox">
                                <h4>Welcome back Administrator<?php //echo ; ?>!</h4>
                                <hr>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-4 col-xs-12">
                                            <div class="container box1">
                                                <i class="fas fa-users"></i>
                                                <h5>3<?php //echo ; ?></h5>
                                                <h5>Active Members</h5>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-xs-12">
                                            <div class="container box2">
                                                <i class="fas fa-th-list"></i>
                                                <h5>1<?php //echo ; ?></h5>
                                                <h5>Total Membership Plans</h5>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-xs-12">
                                            <div class="container box3">
                                                <i class="fas fa-list"></i>
                                                <h5>2<?php //echo ; ?></h5>
                                                <h5>Total Packages</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-members" role="tabpanel" aria-labelledby="pills-members-tab"><h1>MEMBERS</h1>

                        
                        </div>




                        <div class="tab-pane fade" id="pills-membership" role="tabpanel" aria-labelledby="pills-membership-tab"><h1>MEMBERSHIPS</h1></div>
                        <div class="tab-pane fade" id="pills-schedule" role="tabpanel" aria-labelledby="pills-schedule-tab"><h1>SCHEDULE</h1></div>
                        <div class="tab-pane fade" id="pills-plans" role="tabpanel" aria-labelledby="pills-plans-tab"><h1>PLANS</h1></div>
                        <div class="tab-pane fade" id="pills-package" role="tabpanel" aria-labelledby="pills-package-tab"><h1>PACKAGE</h1></div>
                        <div class="tab-pane fade" id="pills-trainers" role="tabpanel" aria-labelledby="pills-trainers-tab"><h1>TRAINERS</h1></div>
                        <div class="tab-pane fade" id="pills-users" role="tabpanel" aria-labelledby="pills-users-tab"><h1>USERS</h1></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>