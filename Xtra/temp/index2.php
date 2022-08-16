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
    <title>Home page</title>
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
                <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="members.php">Customers</a>
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

    <div class="container homeBox">
        <br>
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
</body>
</html>