<?php

    include "connectdb.php";
    // session_start();
    $id = $_GET['edittrainer'] ?? "";
    $_SESSION['trainerid']=$id;
    $query = mysqli_query($conn,"SELECT * FROM trainer WHERE trainer_id='$id'");

    $data = mysqli_fetch_array($query);
?>
<!DOCTYPE HTML>  
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <title>Gladiator Gym</title>
    <style>
	td{
		vertical-align: middle !important;
	}
    </style>
</head>
<body>
        <div class="container">
            <div class="card container align-items-center mt-3" style="width: 45rem;">
            <!-- <div class="row d-flex justify-content-center"> -->
                <div class="col-md-6 text-center">
                    <!-- <br>
                    <br>
                    <h3>Edit Trainer Info</h3>
                    <br> -->
                    <h3 class="card-title mt-3">Trainer Information</h3>
                    <hr size=4>
                    <form action="updatetrainer.php" method="POST">
                        <input type="hidden" name="update_trainerid" id="update_trainerid" value="<?php echo $id?>">
                        <div class="form-group">
                            <label class="control-label mt-4">Name</label>
                            <br>
                            <input class="form-control" type="text" name="tname" value="<?php echo $data['trainer_name'] ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label mt-3">Email</label>
                            <br>  
                            <input class="form-control" type="text" name="temail" value="<?php echo $data['trainer_email'] ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label mt-3">Contact</label>
                            <br>
                            <input class="form-control" type="text" name="tcontact" value="<?php echo $data['trainer_contact'] ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label mt-3">Rate</label>
                            <br>
                            <input class="form-control" type="text" name="trate" value="<?php echo $data['trainer_rate'] ?>">
                        </div>
                        <br>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary" name="updatetrainer">Done</button>
                            <a href="home.php">
                                <input type="button" class="btn btn-secondary" name="back"  id="back" value="Back">
                            </a>
                        </div>
                    </form>
                </div>
            <!-- </div> -->
            </div>
        </div>    
</body>
</html>