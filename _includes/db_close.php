<?php
    /*
     * MHM: 2017-01-17
     * Comment:
     *  Close the connection to the mysql database.
     *  Consider making a function instead of inline php.
     */
    if (isset($connection)) {
        mysqli_close($connection);
    }
?>