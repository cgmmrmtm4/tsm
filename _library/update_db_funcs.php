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
 *
 * MHM: 2017-02-20
 * Comment:
 *  update game is records database.
 */

if (count(get_included_files()) == 1) {
    exit("direct access not allowed.");
}

/* MHM: 2017-02-16
 * Comment:
 *  Update record in academic database.
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
    $result = mysqli_query($connection, $query);
    return($result);
}

/*
 * MHM: 2017-02-21
 * Comment:
 *  Update record in records database.
 *  Input: connection to database, schedule Id, sports Id, date, location, league game,
 *  opponent, score and result.
 *  Output: result of database query.
 */
function update_game_into_records($connection, $schedId, $sportId, $dbDate, $locationName, $dbLeague, $opponentName, $dbScore, $dbResult) {
    $query  = "UPDATE records SET ";
    $query .= "sportId = '{$sportId}', ";
    $query .= "date = '{$dbDate}', ";
    $query .= "location = '{$locationName}', ";
    $query .= "league = '{$dbLeague}', ";
    $query .= "opponent = '{$opponentName}', ";
    $query .= "score = '{$dbScore}', ";
    $query .= "result = '{$dbResult}' ";
    $query .= "WHERE id = {$schedId}";
    print_r($query);
    $result = mysqli_query($connection, $query);
    return($result);
}
?>