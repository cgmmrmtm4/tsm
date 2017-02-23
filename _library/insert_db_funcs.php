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
 *
 * MHM: 2017-02-20
 * Comment:
 *  Insert into records database.
 *
 * MHM: 2017-02-23
 * Comment:
 *  Insert stats in vbstats database.
 *  Cleanup return value for all functions.
 */

if (count(get_included_files()) == 1) {
    exit("direct access not allowed.");
}

/*
 * MHM: 2017-02-16
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
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    return $result;
}

/* 
 * MHM: 2017-02-20
 * Comment:
 *  Add game to schedule and records database.
 *  Input: connection to database, sport ID, date of game, location of game, is league opponent,
 *  opponent name, score and result.
 *  Output: result of database query.
 */
function insert_game_into_records($connection, $sportId, $date, $location, $league, $opponent, $score, $result) {
    $query  = "INSERT INTO records (id, sportId, ";
    $query .= "date, location, league, opponent, ";
    $query .= "score, result) VALUES (NULL, '{$sportId}', ";
    $query .= "'{$date}', '{$location}', '{$league}', ";
    $query .= "'{$opponent}', '{$score}', '{$result}')";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    return $result;
}

/*
 * MHM: 2017-02-21
 * Comment:
 *  Add stats to volleyball statistics database.
 *  Input: Connection to datebase, seasonId, opponent, assists, blocks, kills, digs, serves, aces and sideouts.
 *  Output: result of database query.
 */
function insert_stats_into_vbstats($connection, $seasonId, $opponent, $dbAssists, $dbBlocks, $dbKills, $dbDigs, $dbServes, $dbAces, $dbSideOuts) {
    $query  = "INSERT INTO vbstats (id, seasonId, ";
    $query .= "opponent, assists, blocks, kills, digs, ";
    $query .= "serves, aces, sideouts) VALUES (NULL, ";
    $query .= "'{$seasonId}', '{$opponent}', '{$dbAssists}', ";
    $query .= "'{$dbBlocks}', '{$dbKills}', '{$dbDigs}', ";
    $query .= "'{$dbServes}', '{$dbAces}', '{$dbSideOuts}')";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    return $result;
}
?>