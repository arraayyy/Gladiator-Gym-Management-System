<?php

    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "db_gladiator";

    $conn = mysqli_connect($server, $username, $password, $database);

    if (!$conn){
        die("Connection Failed" . mysqli_connect_error());
    }
?>
