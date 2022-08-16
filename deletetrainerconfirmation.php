
<?php
include 'connectdb.php';

$id=$_GET['id'];

if(isset($id)){
    $delete = "DELETE FROM trainer WHERE `trainer_id` = $id ";

    $query = mysqli_query($conn,$delete);

    header('Location: home.php');
}

