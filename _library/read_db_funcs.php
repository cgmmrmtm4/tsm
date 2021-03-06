<?php
/*
 * MHM: 2017-01-16
 * Comment:
 *  Do not allow direct access to include files.
 *  functions.php:
 *      Contains the CRUD functions to manipulate the MYSQL database.
 *
 * MHM: 2017-01-16
 * Comment:
 *  Verify database query returned a result.
 *  Input: The return value of a database query.
 *  Output: None.
 *  Special: Kills application on failure.
 *
 * MHM: 2017-01-19
 * Comment:
 *  Add a new database query to get the travel location
 *
 * MHM: 2017-01-21
 * Comment:
 *  Simplify get_vb_stat_season(). We really only need the handle to the database.
 *
 * MHM: 2017-02-05
 * Comment:
 *  Add mysql_prep() to handle potential escape characters. And redirect_to() to load
 *  a specific page.
 *
 * MHM: 2017-02-06
 * Comment:
 *  Changed get picture, get video and get stat functions to return all fields so that we have
 *  access to each rows Id.
 *
 * MHM: 2017-02-12
 * Comment:
 *  Two new read functions. Get the list of teachers and the list of classes for a specific student.
 *
 * MHM: 2017-02-13
 * Comment:
 *  Add functions to get opponents and locations from databases.
 *
 * MHM: 2017-02-13
 * Comment:
 *  Get a single class entry to edit.
 *
 * MHM: 2017-02-16
 * Comment:
 *  More utility get requests to retrieve specific information.
 *  Added get_studentId, getseasonId, covert_grade_to_gp and covert_grade_to_wgp.
 *
 * MHM: 2017-02-20
 * Comment:
 *  Retrieve a sportId given a seasonId.
 *
 * MHM: 2017-02-21
 * Comment:
 *  Retrieve a game record given a schedule Id
 *
 * MHM: 2017-02-23
 * Comment:
 *  Retrieve a stat record given a stat Id.
 *  Retrieve a av recrod given a av Id.
 *
 * MHM: 2017-10-26
 * Comment:
 *  Make academic list ascending by class period.
 */

if (count(get_included_files()) == 1) {
    exit("direct access not allowed.");
}

/*
 * MHM: 2017-02-23
 * Comment:
 * Return a av record given an av ID.
 * Input: Connection to database and an AV id.
 * Output: The result of the query.
 */
function get_av_by_id($connection, $avId) {
    $query  = "SELECT * FROM av ";
    $query .= "WHERE av.id=\"$avId\";";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    return $result;
}

/*
 * MHM: 2017-02-21
 * Comment:
 *  Return a stat record given the stat Id.
 *  Input: Connection to database and stat ID.
 *  Output: The result of the query.
 */
function get_stats_by_id($connection, $statId) {
    $query  = "SELECT * FROM vbstats ";
    $query .= "WHERE vbstats.id=\"$statId\";";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    return $result;
}

/*
 * MHM: 2017-02-21
 * Comment:
 *  Return a game record given the schedule Id.
 *  Input: Connection to database and a schedule ID
 *  Output: The result of the query.
 */
function get_game_by_id($connection, $schedId) {
    $query  = "SELECT * FROM records ";
    $query .= "WHERE records.id=\"$schedId\";";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    return $result;
}

/*
 * MHM: 2017-02-20
 * Comment:
 *  Get the sportId given the seasonId.
 *  Input: connection to database and season Id.
 *  Output: a sports Id.
 */
function get_sportId($connection, $seasonId) {
    $query = "SELECT sports.id FROM sports ";
    $query .= "WHERE sports.seasonId =\"$seasonId\";";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    $row = mysqli_fetch_assoc($result);
    $sportId = $row['id'];
    return $sportId;
}

/* MHM: 2017-02-14
 * Comment:
 *  Return a student ID given a name.
 *  Input: connection to database and student name.
 *  Output: student ID.
 */
function get_studentId($connection, $student) {
    $query  = "SELECT students.id FROM students ";
    $query .= "WHERE students.studentName=\"$student\";";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    $row = mysqli_fetch_assoc($result);
    $studentId = $row['id'];
    mysqli_free_result($result);
    return $studentId;
}

/* MHM: 2017-02-14
 * Comment:
 *  Return a season ID given a season and year
 *  Input: season and year.
 *  Output: season ID.
 */
function get_seasonId($connection, $season, $year) {
    $query  = "SELECT hsseasons.id FROM hsseasons ";
    $query .= "WHERE hsseasons.season=\"$season\" ";
    $query .= "AND hsseasons.year=\"$year\";";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    $row = mysqli_fetch_assoc($result);
    $studentId = $row['id'];
    mysqli_free_result($result);
    return $studentId;
}

/* MHM: 2017-02-14
 * Comment:
 *  Return a gp value for a given grade.
 *  Input: grade
 *  Output: grade point value.
 */
function convert_grade_to_gp($connection, $grade) {
    $query  = "SELECT grades.GP FROM grades ";
    $query .= "WHERE grades.grade=\"$grade\";";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    $row = mysqli_fetch_assoc($result);
    $gp = $row['GP'];
    mysqli_free_result($result);
    return $gp;
}

/* MHM: 2017-02-14
 * Comment:
 *  Return a wgp value for a given grade.
 *  Input: grade
 *  Output: weighted grade point value.
 */
function convert_grade_to_wgp($connection, $grade) {
    $query  = "SELECT grades.WGP FROM grades ";
    $query .= "WHERE grades.grade=\"$grade\";";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    $row = mysqli_fetch_assoc($result);
    $wgp = $row['WGP'];
    mysqli_free_result($result);
    return $wgp;
}

/*
 * MHM: 2017-02-13
 * Comment:
 *  Return a single class entry.
 *  Input: none
 *  Output: A single class row.
 */
function get_class_by_id($connection, $classId) {
    $query  = "SELECT * FROM academics ";
    $query .= "WHERE academics.id=\"$classId\";";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    return $result;
}
/*
 * MHM: 2017-02-13
 * Comment:
 *  Return a list of oppents from the statistic tables.
 *  Input: none
 *  Output: A list of oppenents
 */
function get_vbstats_opponents($connection) {
    $query  = "SELECT DISTINCT vbstats.opponent FROM vbstats ";
    $query .= "ORDER BY vbstats.opponent ASC;";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    return $result;
}

/*
 * MHM: 2017-02-13
 * Comment:
 *  Return a list of locations from the records tables.
 *  Input: none
 *  Output: A list of locations
 */
function get_records_locations($connection) {
    $query  = "SELECT DISTINCT records.location FROM records ";
    $query .= "ORDER BY records.location ASC;";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    return $result;
}

/*
 * MHM: 2017-02-13
 * Comment:
 *  Return a list of locations from the records tables.
 *  Input: none
 *  Output: A list of opponents
 */
function get_records_opponents($connection) {
    $query  = "SELECT DISTINCT records.opponent FROM records ";
    $query .= "ORDER BY records.opponent ASC;";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    return $result;
}
/*
 * MHM: 2017-02-12
 * Comment:
 *  Return a list of teaches the student has taken.
 *  Input: Database handle, the students name.
 *  Output: A list of teachers.
 */
function get_teachers_by_student($connection, $student) {
    $query  = "SELECT DISTINCT academics.teacherName FROM academics ";
    $query .= "JOIN students ON students.id=academics.studentId AND ";
    $query .= "students.studentName=\"$student\" ";
    $query .= "ORDER BY academics.teacherName ASC;";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    return $result;
}

/*
 * MHM: 2017-02-12
 * Comment:
 *  Return a list of classes the student has taken.
 *  Input: Database handle, the students name.
 *  Output: A list of classes.
 */
function get_classes_by_student($connection, $student) {
    $query  = "SELECT DISTINCT academics.className FROM academics ";
    $query .= "JOIN students ON students.id=academics.studentId AND ";
    $query .= "students.studentName=\"$student\" ";
    $query .= "ORDER BY academics.className ASC;";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    return $result;
}


/*
 * MHM: 2017-01-16
 * Comment:
 *  Return a list of rewards the student received for a particular activity
 *  Input: Database handle, type of activity, student name
 *  Output: List of awards.
 */
function get_awards_by_catagory($connection, $catagory, $student) {
    $query  = "SELECT * FROM awards ";
    $query .= "JOIN students ON ";
    $query .= "awards.studentId=students.id AND ";
    $query .= "students.studentName=\"$student\" AND ";
    $query .= "catagory=\"$catagory\" ";
    $query .= "ORDER BY year DESC, title";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    return $result;
}

/*
 * MHM: 2017-01-16
 * Comment:
 *  Return a list of academic semesters a student attended school.
 *  Input: Database handle, student name
 *  Output: List of academic semesters.
 */
function get_academic_years($connection, $student) {
    $query  = "SELECT DISTINCT hsseasons.season, hsseasons.year ";
    $query .= "FROM academics ";
    $query .= "JOIN hsseasons ON ";
    $query .= "academics.seasonId=hsseasons.id ";
    $query .= "JOIN students ON ";
    $query .= "hsseasons.studentId=students.id AND ";
    $query .= "students.studentName=\"$student\"";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    return $result;
}

/*
 * MHM: 2017-01-16
 * Comment:
 *  Return a list of academic results from a selected semester.
 *  Input: Database handle, the semester season, the year and the students name.
 *  Output: List of classes and grades.
 */
function get_semester_academics($connection, $season, $year, $student) {
    $query  = "SELECT academics.* ";
    $query .= "FROM students ";
    $query .= "JOIN hsseasons ON ";
    $query .= "hsseasons.studentId=students.id AND ";
    $query .= "students.studentName=\"$student\" ";
    $query .= "JOIN academics ON ";
    $query .= "academics.seasonId=hsseasons.id AND ";
    $query .= "hsseasons.season=\"$season\" AND ";
    $query .= "hsseasons.year=$year ";
    $query .= "ORDER BY academics.period ASC";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    return $result;
}

/*
 * MHM: 2017-01-16
 * Comment:
 *  Return a semester's GPA value.
 *  Input: Database handle, the semester season, the year and the students name.
 *  Output: Return unweighted and weighted GPA.
 */
function get_semester_gpa($connection, $season, $year, $student) {
    $query  = "SELECT ROUND(AVG(GP), 3) AS GPA, ";
    $query .= "ROUND(AVG(WGP), 3) AS WGPA ";
    $query .= "FROM students ";
    $query .= "JOIN hsseasons ON ";
    $query .= "hsseasons.studentId=students.id AND ";
    $query .= "students.studentName=\"$student\" ";
    $query .= "JOIN academics ON ";
    $query .= "academics.seasonId=hsseasons.id AND ";
    $query .= "hsseasons.season=\"$season\" AND ";
    $query .= "hsseasons.year=$year";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    return $result;
}

/*
 * MHM: 2017-01-16
 * Comment:
 *  Return a running GPA from first semester to selected semester.
 *  Input: Database handle, the semester season, the year and the students name.
 *  Output: Return unweighted and weighted GPA as of selected semester.
 */
function get_running_gpa($connection, $season, $year, $student) {
    $query  = "SELECT ROUND(AVG(GP), 3) AS GPA, ";
    $query .= "ROUND(AVG(WGP), 3) AS WGPA ";
    $query .= "FROM students ";
    $query .= "JOIN hsseasons ON ";
    $query .= "hsseasons.studentId=students.id AND ";
    $query .= "students.studentName=\"$student\" ";
    $query .= "JOIN academics ON ";
    $query .= "academics.seasonId<=hsseasons.id AND ";
    $query .= "hsseasons.season=\"$season\" AND ";
    $query .= "hsseasons.year=$year AND ";
    $query .= "hsseasons.studentId=academics.studentId";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    return $result;
}

/*
 * MHM: 2017-01-16
 * Comment:
 *  Return a list of seasons for a particular sport the
 *  student participated.
 *  Input: Database handle, sport name, student name
 *  Output: List of years participated.
 */
function get_sport_seasons($connection, $sport, $student) {
    $query  = "SELECT DISTINCT hsseasons.season, hsseasons.year ";
    $query .= "FROM hsseasons ";
    $query .= "JOIN students ON ";
    $query .= "students.studentName=\"$student\" AND ";
    $query .= "students.id=hsseasons.studentId ";
    $query .= "JOIN sports ON sports.seasonid=hsseasons.id AND ";
    $query .= "sports.sport=\"$sport\" ";
    $query .= "ORDER BY year ASC";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    return $result;
}

/*
 * MHM: 2017-01-16
 * Comment:
 *  Return a list seaons that have pictures and/or video content.
 *  Input: Database handle, activity name, picture or video boolean, student name
 *  Output: List of seasons.
 */
function get_activity_av_seasons($connection, $activity, $video, $student) {
    $query  = "SELECT DISTINCT hsseasons.season, hsseasons.year ";
    $query .= "FROM hsseasons ";
    $query .= "JOIN students ON ";
    $query .= "students.studentName=\"$student\" AND ";
    $query .= "students.id=hsseasons.studentId ";
    $query .= "JOIN av ON ";
    $query .= "av.seasonId=hsseasons.id AND ";
    $query .= "av.subject=\"$activity\" AND av.video=$video ";
    $query .= "ORDER BY year ASC";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    return $result;
}

/*
 * MHM: 2017-01-19
 * Comment:
 *  Return a list seaons that have statasitcal content.
 *  Input: Database handle, activity name, picture or video boolean, student name
 *  Output: List of seasons.
 *
 * MHM: 2017-01-21
 *  Input: Database handle.
 *
 */
function get_vb_stat_seasons($connection) {
    $query  = "SELECT DISTINCT hsseasons.season, hsseasons.year ";
    $query .= "FROM hsseasons ";
    $query .= "JOIN vbstats ON ";
    $query .= "vbstats.seasonId=hsseasons.id ";
    $query .= "ORDER BY year ASC";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    return $result;
}

/*
 * MHM: 2017-01-16
 * Comment:
 *  Return wheter the sport season is for Varsity or JV.
 *  Input: Database handle, sport name, year
 *  Output: Returns a string
 */
function get_varsity_or_jv_label($connection, $sport, $year) {
    if ($year != 2009) {
        $query  = "SELECT sports.varsity FROM sports ";
        $query .= "JOIN hsseasons ON sports.seasonId=hsseasons.id ";
        $query .= "WHERE sports.sport=\"$sport\" AND hsseasons.year=$year";
        $result = mysqli_query($connection, $query);
        $label = JV;
        confirm_query($result);
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['varsity'] == 0) {
                $label = JV;
            } else {
                $label = VARSITY;
            }
        }
        mysqli_free_result($result);
    } else {
        $label=FROSH;
    }
    return $label;   
}

/*
 * MHM: 2017-01-16
 * Comment:
 *  Return the teams overall record for a given season.
 *  Input: Database handle, sport name, season, year
 *  Output: Returns wins, loses and tie totals.
 */
function get_team_overall_record($connection, $sport, $season, $year) {
    $overallRecord = array("Wins" => 0, "Losses" => 0, "Ties" => 0);
    $query  = "SELECT records.result, count(*) FROM hsseasons ";
    $query .= "JOIN sports ON sports.sport=\"$sport\" ";
    $query .= "AND sports.seasonId=hsseasons.id ";
    $query .= "JOIN records ON records.sportId=sports.id ";
    $query .= "WHERE hsseasons.season=\"$season\" ";
    $query .= "AND hsseasons.year=$year ";
    $query .= "GROUP BY records.result ";
    $query .= "ORDER BY records.result";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    while ($row = mysqli_fetch_assoc($result)) {
        switch ($row['result']) {
            case 'L': 
                $overallRecord["Losses"]=$row['count(*)'];
                break;
            case 'W':
                $overallRecord["Wins"]=$row['count(*)'];
                break;
            case 'T':
                $overallRecord["Ties"]=$row['count(*)'];
                break;
        }
    }
    mysqli_free_result($result);
    return $overallRecord;
}

/*
 * MHM: 2017-01-16
 * Comment:
 *  Return the teams league record for a given season.
 *  Input: Database handle, sport name, season, year
 *  Output: Returns wins, loses and tie totals.
 */
function get_team_league_record($connection, $sport, $season, $year) {
    $leagueRecord = array("Wins" => 0, "Losses" => 0, "Ties" => 0);
    $query  = "SELECT records.result, count(*) FROM hsseasons ";
    $query .= "JOIN sports ON sports.sport=\"$sport\" ";
    $query .= "AND sports.seasonId=hsseasons.id ";
    $query .= "JOIN records ON records.sportId=sports.id ";
    $query .= "WHERE hsseasons.season=\"$season\" ";
    $query .= "AND hsseasons.year=$year ";
    $query .= "AND records.league=\"*\" ";
    $query .= "GROUP BY records.result ";
    $query .= "ORDER BY records.result";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    while ($row = mysqli_fetch_assoc($result)) {
        switch ($row['result']) {
            case 'L': 
                $leagueRecord["Losses"]=$row['count(*)'];
                break;
            case 'W':
                $leagueRecord["Wins"]=$row['count(*)'];
                break;
            case 'T':
                $leagueRecord["Ties"]=$row['count(*)'];
                break;
        }
    }
    mysqli_free_result($result);
    return $leagueRecord;
}

/*
 * MHM: 2017-01-16
 * Comment:
 *  Return the teams game results for a given season.
 *  Input: Database handle, sport name, season, year
 *  Output: A list of results for each game for the selected season.
 */
function get_schedule_and_results($connection, $sport, $season, $year) {
    $query  = "SELECT records.* ";
    $query .= "FROM hsseasons ";
    $query .= "JOIN sports ON ";
    $query .= "sports.sport=\"$sport\" AND ";
    $query .= "sports.seasonId=hsseasons.id ";
    $query .= "JOIN records ON ";
    $query .= "records.sportId=sports.id ";
    $query .= "WHERE hsseasons.season=\"$season\" AND ";
    $query .= "hsseasons.year=$year";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    return $result;
}

/*
 * MHM: 2017-01-16
 * Comment:
 *  Return the individual stats for a given season.
 *  Input: Database handle, season, year
 *  Output: A list of statisics for each game for the selected season.
 */
function get_volleyball_stats($connection, $season, $year) {
    $query  = "SELECT vbstats.* FROM vbstats ";
    $query .= "JOIN hsseasons on hsseasons.id=vbstats.seasonId ";
    $query .= "WHERE hsseasons.season=\"$season\" AND hsseasons.year=$year";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    return $result;
}

/*
 * MHM: 2017-01-16
 * Comment:
 *  Return the individuals total stats for a given season.
 *  Input: Database handle, season, year
 *  Output: The years totaled statistical information.
 */
function get_volleyball_season_totals($connection, $season, $year) {
    $query  = "SELECT SUM(assists) AS totassists, ";
    $query .= "ROUND(AVG(assists),2) AS avgassists, ";
    $query .= "SUM(blocks) AS totblocks, ";
    $query .= "ROUND(AVG(blocks),2) AS avgblocks, ";
    $query .= "SUM(kills) AS totkills, ";
    $query .= "ROUND(AVG(kills),2) AS avgkills, ";
    $query .= "SUM(digs) AS totdigs, ";
    $query .= "ROUND(AVG(digs),2) AS avgdigs, ";
    $query .= "SUM(serves) AS totserves, ";
    $query .= "ROUND(AVG(serves),2) AS avgserves, ";
    $query .= "SUM(aces) AS totaces, ";
    $query .= "ROUND(AVG(aces),2) AS avgaces, ";
    $query .= "SUM(sideouts) AS totsideouts, ";
    $query .= "ROUND(AVG(sideouts),2) AS avgsideouts ";
    $query .= "FROM vbstats JOIN hsseasons on hsseasons.id=vbstats.seasonId ";
    $query .= "WHERE hsseasons.season=\"$season\" AND hsseasons.year=$year";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    return $result;
}

/*
 * MHM: 2017-01-16
 * Comment:
 *  Return the number of pictures for a given season.
 *  Input: Database handle, activity name, season, year
 *  Output: An integer containing the number of pictures.
 */
function get_number_of_pictures($connection, $activity, $season, $year) {
    $retcnt = 0;
    $query  = "SELECT count(*) AS cnt ";
    $query .= "FROM av ";
    $query .= "JOIN hsseasons on av.seasonId=hsseasons.id ";
    $query .= "WHERE av.subject=\"$activity\" AND av.video=0 ";
    $query .= "AND hsseasons.season=\"$season\" AND hsseasons.year=$year";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    $cnt = mysqli_fetch_assoc($result);
    $retcnt = $cnt['cnt'];
    mysqli_free_result($result);
    return $retcnt;
}

/*
 * MHM: 2017-01-16
 * Comment:
 *  Return the list of picture file names.
 *  Input: Database handle, activity name, season, year
 *  Output: List of picture names.
 */
function get_pictures($connection, $activity, $season, $year) {
    $query  = "SELECT av.* ";
    $query .= "FROM av ";
    $query .= "JOIN hsseasons on av.seasonId=hsseasons.id ";
    $query .= "WHERE av.subject=\"$activity\" AND av.video=0 ";
    $query .= "AND hsseasons.season=\"$season\" AND hsseasons.year=$year";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    return $result;
}

/*
 * MHM: 2017-01-16
 * Comment:
 *  Return the number of videos for a given season.
 *  Input: Database handle, activity name, season, year
 *  Output: An integer containing the number of videos.
 */
function get_number_of_vids($connection, $activity, $season, $year) {
    $retcnt = 0;
    $query  = "SELECT count(*) AS cnt ";
    $query .= "FROM av ";
    $query .= "JOIN hsseasons on av.seasonId=hsseasons.id ";
    $query .= "WHERE av.subject=\"$activity\" AND av.video=1 ";
    $query .= "AND hsseasons.season=\"$season\" AND hsseasons.year=$year";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    $cnt = mysqli_fetch_assoc($result);
    $retcnt = $cnt['cnt'];
    mysqli_free_result($result);
    return $retcnt;
}

/*
 * MHM: 2017-01-16
 * Comment:
 *  Return a list video file names.
 *  Input: Database handle, activity name, season, year
 *  Output: List of video names.
 */
function get_vids($connection, $activity, $season, $year) {
    $query  = "SELECT av.* ";
    $query .= "FROM av ";
    $query .= "JOIN hsseasons on av.seasonId=hsseasons.id ";
    $query .= "WHERE av.subject=\"$activity\" AND av.video=1 ";
    $query .= "AND hsseasons.season=\"$season\" AND hsseasons.year=$year";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    return $result;
}

/*
 * MHM: 2017-01-16
 * Comment:
 *  Return student ranking for a given semester.
 *  Input: Database handle, season, year
 *  Output: The students ranking information.
 */
function get_top_of_class($connection, $season, $year) {
    $query  = "SELECT rank, totalStudents, ROUND(((rank / totalStudents)*100),2) ";
    $query .= "AS pct ";
    $query .= "FROM rankings ";
    $query .= "JOIN hsseasons ";
    $query .= "ON rankings.seasonId=hsseasons.id ";
    $query .= "WHERE hsseasons.season=\"$season\" AND hsseasons.year=$year";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    return $result;
}

/*
 * MHM: 2017-01-19
 * Comment:
 *  Return the location of the trip.
 */
function get_travel_location($connection, $season, $year) {
    $query  = "SELECT travel.location ";
    $query .= "FROM travel ";
    $query .= "JOIN hsseasons ";
    $query .= "ON hsseasons.id=travel.seasonId ";
    $query .= "AND hsseasons.season=\"$season\" ";
    $query .= "AND hsseasons.year=$year";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    $location = mysqli_fetch_assoc($result);
    $retloc = $location['location'];
    mysqli_free_result($result);
    return $retloc;
}
?>