<?php
/*
 * MHM: 2017-02-16
 * Comment:
 *  Do not allow direct access to include files.
 *  update_db_funcs.php:
 *      Contains the CRUD functions to manipulate the MYSQL database.
 *
 * MHM: 2017-02-16
 * Comment:
 *  Update functions for database requests.
 *
 * MHM: 2017-02-16
 * Comment:
 *  update class entry in the database.
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
function update_class_into_db($connection, $classId, $seasonId, $studentId, $period, $honors, $ap, $className, $teacherName, $grade, $gp, $wgp) {
    $query  = "UPDATE academics SET ";
    $query .= "seasonId = {$seasonId}, ";
    $query .= "studentId = {$studentId}, ";
    $query .= "period = {$period}, ";
    $query .= "honors = {$honors}, ";
    $query .= "AP = {$ap}, ";
    $query .= "className = '{$className}', ";
    $query .= "teacherName = '{$teacherName}', ";
    $query .= "grade = '{$grade}', ";
    $query .= "GP = {$gp}, ";
    $query .= "WGP = {$wgp} ";
    $query .= "WHERE id = {$classId}";
    return($result = mysqli_query($connection, $query));
}
?>