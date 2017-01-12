<?php
    // 1. Create a database connection
    $dbhost = "localhost";
    $dbuser = "cmrt_adm";
    $dbpass = "mhmcmg";
    $dbname = "cmrt_inc";
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    // Test if connection succeeded
    if (mysqli_connect_errno()) {
        die("Database connection failed: " .
           mysqli_connect_error() .
           " (" . mysqli_conenct_errno() . ")"
        );
    }
?>