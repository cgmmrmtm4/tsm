<?php
/*
 * MHM: 2017-02-21
 * Comment:
 *  Do not allow direct access to include files.
 *  update_db_funcs.php:
 *      Contains the CRUD functions to manipulate the MYSQL database.
 *
 * MHM: 2017-02-21
 * Comment:
 *  delete functions for database requests.
 */

if (count(get_included_files()) == 1) {
    exit("direct access not allowed.");
}

/* MHM: 2017-02-21
 * Comment:
 *  Delete record from academic database.
 *  Input: connection to database, classIdseason ID.
 *  Output: result of database query.
 */
function delete_class_from_db($connection, $classId) {
    $query  = "DELETE FROM academics WHERE id = {$classId}";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    return $result;
}

/*
 * MHM: 2017-02-21
 * Comment:
 *  Delete record in records database.
 *  Input: connection to database, schedule Id.
 *  Output: result of database query.
 */
function delete_game_from_records($connection, $schedId) {
    $query  = "DELETE FROM records WHERE id = {$schedId}";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    return $result;
}

/*
 * MHM: 2017-02-21
 * Comment:
 *  Delete statistical record from vbstat database.
 *  Input: connection to database, stats Id.
 *  Output: result of database query.
 */
function delete_stats_from_vbstats($connection, $statId) {
    $query  = "DELETE FROM vbstats WHERE id = {$statId}";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    return $result;
}
?>