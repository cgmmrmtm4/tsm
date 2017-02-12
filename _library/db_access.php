<?php
/* 
 * MHM: 2017-02-09
 * Comment:
 *  Create new library file that contains all db access routines and db validation functions.
 */

if (count(get_included_files()) == 1) {
    exit("direct access not allowed.");
}

/*
 * MHM: 2017-02-09
 * Comment:
 *  Close the connection to the mysql database.
 *  Input: connection to the database;
 *  Output: none.
 *
 */
function close_db($connection) {
    if (isset($connection)) {
        mysqli_close($connection);
    }
}

/*
 * MHM: 2017-02-09
 * Comment:
 *  Create a connection to the mysql database and store the database handle.
 *  Input: none.
 *  Output: a connection to the database.
 */
function open_db() {
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
    return $connection;
}
?>