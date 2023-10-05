<?php 
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, PATCH, GET, DELETE");

    $host = "localhost";
    $username = "root";
    $password ="";
    $dbname  = "UNSPLASHDB";

    $connection  = mysqli_connect($host, $username, $password, $dbname);
?>