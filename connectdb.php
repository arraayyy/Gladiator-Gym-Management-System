<?php
$host="localhost";
$user="root";
$password="";
$db="db_gladiator";



$conn=mysqli_connect($host,$user,$password,$db);

if($conn){
    // echo "Connection successful";
}else{
    die("Connection Failed ".mysqli_connect_error());
}

?>