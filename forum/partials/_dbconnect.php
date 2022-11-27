<?php

    // Connect to the database
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "collidea";
    $conn = mysqli_connect($server,$username,$password,$database);
    if(!$conn){
        die("Failed to connect due to this error -> " . mysqli_connect_error());
    }

?>