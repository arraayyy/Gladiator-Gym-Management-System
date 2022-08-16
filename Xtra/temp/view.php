<?php
include 'config.php';
$id=$_GET['id'];

$display="SELECT * FROM `customer` WHERE `customer_id`='$id' LIMIT 1";
$view = mysqli_query($conn,$display);


echo "<br>";
while($row= mysqli_fetch_assoc($view)){

?>

<div>
    <div class="card">
        <div class="card-header">Customer Details</div>
        <div class="card-body">
            <p>Name: <?php echo $row['customer_fname']. " ". $row['customer_mname']. " ".$row['customer_lname'] ?></p>
            <p>Gender: <?php echo $row['customer_gender'] ?></p>
            <p>Email: <?php echo $row['customer_email'] ?></p>
            <p>Contact: <?php echo $row['customer_contact'] ?></p>
            <p>Address: <?php echo $row['customer_address'] ?></p>
            <p>Package Plan: N/A</p>
            <p>Trainer: N/A kay wala pas database </p>
        </div>
    </div>

</div>

<?php
    }
?>