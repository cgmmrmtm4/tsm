<?php
    /*
     * MHM: 2017-01-17
     * Comment:
     *  Create a connection to the mysql database and store the database handle.
     *  Consider making a function instead of inline php.
     */
    $dbhost = "localhost";
    $dbuser = "cmrt_adm";
    $dbpass = "mhmcmg";
    $dbname = "cmrt_inc";
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    /*
     * MHM: 2017-01-17
     *
     * Comment:
     *  Check if connection was successful. If not, terminate the process.
     */
    if (mysqli_connect_errno()) {
        die("Database connection failed: " .
           mysqli_connect_error() .
           " (" . mysqli_conenct_errno() . ")"
        );
    }
?>