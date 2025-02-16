<?php
$host = "localhost";
$username = "root";
$password = "";
$databse = "car_rental";

//connet to mysql
$conn =  new mysqli($host, $username, $password, $databse);

// check connection
if ($conn->connect_error){
    die("Connection failed" .$conn->connect_error);
}
?>