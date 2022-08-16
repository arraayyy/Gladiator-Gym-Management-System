<?php
include 'config.php';

if(isset($_POST['submit_form'])){  // if the form has been submitted
    $fname= $_POST['fname'];  // get the form data
    $mname= $_POST['mname'];  
    $lname= $_POST['lname'];
    $email= $_POST['email'];
    $phone= $_POST['phone'];
    $add= $_POST['address'];
    $age= $_POST['age'];
    $w= $_POST['weight'];
    $h= $_POST['height'];
    $sex= $_POST['sex'];
    $date= date('y-m-d h:i:s');
 
    function bmi($w,$h) {
        $bmi = $w / ($h * $h);
        return $bmi;
    }   

    $bmi = bmi($w,$h); //<--- this is critical

    if ($bmi <= 18.5) {
        $output = "Underweight";

        } else if ($bmi > 18.5 AND $bmi<=24.9 ) {
        $output = "Normal";

        } else if ($bmi > 24.9 AND $bmi<=29.9) {
        $output = "Overweight";

        } else if ($bmi >= 30.0) {
        $output = "Obese";
    } 

    if(isset($_POST['healthOptions']) ){
        // $health= $_POST['healthOptions'];
        $he = $_POST['healthCondition'];
    }else{
        $he = "NULL";
    }



    // $date= date("Y-m-d");
    
    
    $insert="INSERT INTO `customer` (`customer_fname`, `customer_lname`, `customer_mname`,`customer_email`, `customer_contact`, `customer_age`, `customer_gender`, `customer_weight`, `customer_height`, `customer_bmi`, `customer_health`, `customer_address`, `customer_datecreated`, `customer_queue`) 
    VALUES ('$fname','$lname','$mname','$email','$phone','$age','$sex','$w','$h','$output','$he','$add','$date',0)";  
    
    $query = mysqli_query($conn,$insert);  
    

    if(!$query){   
        echo "Error". mysqli_error($conn);
    }
    header("Location:../../home.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Members</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    
    <style>
        html, body {
            width: 100%;
            height: 100%;
            margin: 0 auto;
        }

        .MI {
            white-space: nowrap;
        }

        .Health {
            white-space: nowrap;
        }



    </style>
    
    
</head>
<body>
    
    <div class="container py-3">
        <div class="card bg-dark container text-white align-items-center mt-3" style="width: 50rem;">
            <div class="card-header">
                <h3 class="card-title">Personal Information</h3>
                <hr size=3>
            </div>
            <form action="" method="POST" class="form px-3">
                <div class="mt-3">
                    <!--- NAME --->
                    <div class="row">
                        <div class="col-md-5 mt-4">
                            <label for="fname">First Name</label>
                            <input type="text" class="form-control" name="fname" id="fname" autocomplete="off" required>
                        </div>

                        <div class="col-md-5 mt-4">
                             <label for="lname">Last Name</label>
                            <input type="text" class="form-control" id="lname" name="lname" autocomplete="off" required>
                        </div>

                        <div class="col-md-2 MI mt-4">
                            <label for="mname">Middle Initial</label>
                            <input type="text" class="form-control" id="mname" autocomplete="off" name="mname">
                        </div>
                    </div>
                    
                    <div class="row">
                        <!--- EMAIL --->
                        <div class="col-md-6 mt-4">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" autocomplete="off" name="email">
                        </div>

                        <!-- CONTACT NUMBER -->
                        <div class="col-md-6 mt-4">
                            <label for="phone">Contact Number</label>
                            <input type="number" class="form-control" id="phone" name="phone" autocomplete="off" required>
                        </div>
                    </div>

                    <div class="row">
                        <!--- ADDRESS --->
                        <div class="col-md-8 mt-4">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" name="address" autocomplete="off" required>
                        </div>

                        <div class="col-md-2 mt-4">
                            <label for="sex">Sex</label>
                            <input type="text" class="form-control" id="sex" name="sex">
                        </div>

                        <!--- AGE --->
                        <div class="col-md-2 mt-4">
                            <label for="age">Age</label>
                            <input type="number" class="form-control" id="age" name="age" autocomplete="off" required>
                        </div>
                    </div>

                    <div class="row">
                        <!--- HEIGHT --->
                        <div class="col-md-2 mt-4">
                            <label for="height">Height</label>
                            <input type="text" class="form-control" id="height" name="height" placeholder="Meters" autocomplete="off" equired>
                        </div>

                        <!--- WEIGHT --->
                        <div class="col-md-2 mt-4">
                            <label for="weight">Weight</label>
                            <input type="text" class="form-control" id="weight" name="weight" placeholder="Kilogram" autocomplete="off"  required>
                        </div>

                        
                    </div>
                    <!-- Health Condition -->
                    <div class="container">
                        <form action="">
                            <p class="fs-6 mt-4">Do you have any health conditions?</p>
                            
                            <div class="form-check form-check-inline mb-4">
                                <input class="form-check-input" type="checkbox" onclick="checkMe()" name="healthOptions" id="myCheck" >
                                <label class="form-check-label" for="yes">Yes</label>
                            </div>

                            <div class="checked" id="conditions" style="display:none;">
                                <p>If yes, please write down below your condition</p>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" id="healthCondition" name="healthCondition" autocomplete="off" >
                                </div>
                            </div> 
                           
                        </form>
                    </div>

                    <script>
                        
                        function checkMe() {
                            var checkBox = document.getElementById("myCheck");
                            var text = document.getElementById("conditions");
                            if (checkBox.checked == true){
                                text.style.display = "block";
                            } else {
                                text.style.display = "none";
                            }
                        }
                    </script>
                    
                    <!-- SUBMIT BUTTON -->
                    <div class="container text-center py-3">
                        <input class="btn btn-primary" name="submit_form" type="submit" value="Submit">
                        <a href="../../home.php"  class="btn btn-secondary">Cancel</a>
                    </div>

                </div>
            </form>
        </div>
    </div>

</body>
</html>
