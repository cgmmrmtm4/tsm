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
 *  update game in records database.
 *
 * MHM: 2017-02-23
 * Comment:
 *  udpate stats in vbstats database.
 *  Cleanup return value for all functions.
 *  Update av record in av database.
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
    confirm_query($result);
    return $result;
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
    $query .= "sportId = {$sportId}, ";
    $query .= "date = '{$dbDate}', ";
    $query .= "location = '{$locationName}', ";
    $query .= "league = '{$dbLeague}', ";
    $query .= "opponent = '{$opponentName}', ";
    $query .= "score = '{$dbScore}', ";
    $query .= "result = '{$dbResult}' ";
    $query .= "WHERE id = {$schedId}";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    return $result;
}

/*
 * MHM: 2017-02-21
 * Comment:
 *  Update statistical record in vbstat database.
 *  Input: connection to database, stats Id, season Id, opponent,
 *  assists, blocks, kills, digs, serves, aces, sideouts.
 *  Output: result of database query.
 */
function update_stats_into_vbstats($connection, $statId, $seasonId, $opponent, $dbAssists, $dbBlocks, $dbKills, $dbDigs, $dbServes, $dbAces, $dbSideOuts) {
    $query  = "UPDATE vbstats SET ";
    $query .= "seasonId = {$seasonId}, ";
    $query .= "opponent = '{$opponent}', ";
    $query .= "assists = {$dbAssists}, ";
    $query .= "blocks = {$dbBlocks}, ";
    $query .= "kills = {$dbKills}, ";
    $query .= "digs = {$dbDigs}, ";
    $query .= "serves = {$dbServes}, ";
    $query .= "aces = {$dbAces}, ";
    $query .= "sideouts = {$dbSideOuts} ";
    $query .= "WHERE id = {$statId}";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    return $result;
}

/*
 * MHM: 2017-02-23
 * Comment:
 *  Update av record in av database
 *  Input: Connection to database, av Id, season Id, student ID, av type, subject, thumb name
 *  av file name.
 *  Output: result of database query
 */
function update_av_into_av($connection, $avId, $seasonId, $studentId, $dbav, $subject, $thumbName, $avName) {
    $query  = "UPDATE av SET ";
    $query .= "seasonId = {$seasonId}, ";
    $query .= "studentId = {$studentId}, ";
    $query .= "video = ${dbav}, ";
    $query .= "subject = '{$subject}', ";
    $query .= "thumbName = '{$thumbName}', ";
    $query .= "avName = '{$avName}' ";
    $query .= "WHERE id = {$avId}";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    return $result;
}
?>
