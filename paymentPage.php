<?php
    include "connectdb.php";
    // session_start();
    $id = $_GET['paymentId'] ?? "";
    $_SESSION['paymentId']=$id;
    $query = mysqli_query($conn,"SELECT * FROM registration WHERE reg_id='$id'");
    $data = mysqli_fetch_array($query);


    $packagePlanId = $data['package_plan_id'];
    $packagePlan = mysqli_query($conn, "SELECT * FROM package_plan WHERE package_plan_id='$packagePlanId'");
    $packagePlan_row = mysqli_fetch_array($packagePlan);


    $trainerId = $data['trainer_id'];
    $trainer = mysqli_query($conn, "SELECT * FROM trainer WHERE trainer_id='$trainerId'");
    $trainer_row = mysqli_fetch_array($trainer);
    // echo $_SESSION['paymentId'];

    $paymentID = $data['reg_id'];
    $paymentSQL= "SELECT * FROM `payment` WHERE reg_id = '$paymentID'";
    $result = mysqli_query($conn,$paymentSQL);        
        while($result_row = mysqli_fetch_assoc($result)){
            $paymentHistory[] = $result_row;
        }
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
    <div class="container-fluid py-3">
        <div class="card container align-items-center mt-3" style="width: 80rem;">
            <!-- <div class="row d-flex justify-content-center"> -->
                <div class="row w-100">

                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for($x=0; $x<count($paymentHistory); $x++) { ?>
                                <tr> 
                                    <th><?php echo $paymentHistory[$x]["date_issued"] ?></th>
                                    <th><?php echo $paymentHistory[$x]["payment_amount"] ?></th>
                                    <th><?php echo ucfirst($paymentHistory[$x]["remarks"]) ?></th>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-6 text-center">
                        <!-- <br>
                        <br>
                        <h3>New Payment</h3>
                        <br> -->
                        <!-- <div class="card-header"> -->
                            <h3 class="card-title mt-3">New Payment</h3>
                            <hr size=4>
                        
                        <form action="sql_Payment.php" method="post">
                            <input type="hidden" name="payment_Id" id="payment_Id" value="<?php echo $id; ?>">
                            <div class="mb-3">
                                <!-- <span class="d-flex justify-content-between"><p>Plan Membership Fee:</p><p><b>Php. 1000.00</b></p></span> -->
                                <input type="hidden" id="rowModalId" name="rowModalId" value="">
                                <span class="d-flex justify-content-between"><p>Package Plan Amount:</p><p><b>Php. <?php echo $packagePlan_row['package_plan_amount']; ?></b></p></span>
                                <input type="hidden" id="paymentPackagePlanFeeInput" name="paymentPackagePlanFeeInput" value="">

                                <input type="hidden" id="paymentTrainerFeeInput" name="paymentTrainerFeeInput" value="">
                            </div>
                            <div class="mb2">
                                <span class="d-flex justify-content-between mb-3"><p>Balance:</p><p><b>Php. <?php echo $data['remainingPayment']; ?></b></p></span>
                                <input type="hidden" id="paymentTotalPayable" name="paymentTotalPayable" value="<?php echo $data['remainingPayment']; ?>">
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
                                    <option value="4">Over the counter</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="payment_remarks" class="form-label">Remarks</label>
                                <div class="form-floating">
                                    <textarea class="form-control" id="payment_remarks" name="payment_remarks" required></textarea>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" name="submitPayment"class="btn btn-primary mb-4">Save changes</button>
                                <a href="home.php"  class="btn btn-secondary mb-4">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
                
            <!-- </div> -->
        </div>
    </div>
</body>
</html>