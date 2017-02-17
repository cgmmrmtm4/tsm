<?php
/*
 * MHM: 2017-02-16
 * Comment:
 *  Do not allow direct access to include files.
 *  insert_db_funcs.php:
 *      Contains the CRUD functions to manipulate the MYSQL database.
 *
 * MHM: 2017-02-16
 * Comment:
 *  Insert functions for database requests.
 *
 * MHM: 2017-02-16
 * Comment:
 *  Insert into class database.
 */

if (count(get_included_files()) == 1) {
    exit("direct access not allowed.");
}

/* MHM: 2017-02-16
 * Comment:
 *  Add record to academic database.
 *  Input: connection to database, season ID, student ID, 
 *  class period, is class Honors, is class AP, class name,
 *  teacher name, grade, grade point value, and 
 *  weighted grade point value.
 *  Output: result of database query.
 */
function insert_class_into_db($connection, $seasonId, $studentId, $period, $honors, $ap, $className, $teacherName, $grade, $gp, $wgp) {
    $query  = "INSERT INTO academics (id, seasonId, ";
    $query .= "studentId, period, honors, AP, ";
    $query .= "className, teacherName, grade, ";
    $query .= "GP, WGP) VALUES (NULL, '{$seasonId}', ";
    $query .= "'{$studentId}', '{$period}', '{$honors}', ";
    $query .= "'{$ap}', '{$className}', '{$teacherName}', ";
    $query .= "'{$grade}', '{$gp}', '{$wgp}')";
    return($result = mysqli_query($connection, $query));
}
?>