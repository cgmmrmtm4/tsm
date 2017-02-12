<?php
/* 
 * MHM: 2017-02-09
 * Comment:
 *  Create new library file that contains all db utility routines and db validation functions.
 */

if (count(get_included_files()) == 1) {
    exit("direct access not allowed.");
}

/*
 * MHM: 2017-02-05
 * Comment:
 *  Escape special characters before making a SQL call.
 *  Input: string that needs to be escaped.
 *  Output: escaped string.
 */
function mysql_prep($string) {
	global $connection;
		
    $escaped_string = mysqli_real_escape_string($connection, $string);
    return $escaped_string;
}

/*
 * MHM: 2017-02-05
 * Comment:
 *  Check status of database query. If failure, terminate.
 *  Input: result set from database query.
 */
function confirm_query($result_set) {
    if (!$result_set) {
        die("Database query failed.");
    }
}

?>