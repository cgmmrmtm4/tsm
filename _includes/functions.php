<?php

    function confirm_query($result_set) {
        if (!$result_set) {
            die("Database query failed.");
        }
    }

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

    function get_semester_academics($connection, $season, $year, $student) {
        $query  = "SELECT academics.* ";
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

    function get_volleyball_stats($connection, $season, $year) {
        $query  = "SELECT * FROM vbstats ";
        $query .= "JOIN hsseasons on hsseasons.id=vbstats.seasonId ";
        $query .= "WHERE hsseasons.season=\"$season\" AND hsseasons.year=$year";
        $result = mysqli_query($connection, $query);
        confirm_query($result);
        return $result;
    }

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

    function get_pictures($connection, $activity, $season, $year) {
        $query  = "SELECT av.thumbName, av.avName ";
        $query .= "FROM av ";
        $query .= "JOIN hsseasons on av.seasonId=hsseasons.id ";
        $query .= "WHERE av.subject=\"$activity\" AND av.video=0 ";
        $query .= "AND hsseasons.season=\"$season\" AND hsseasons.year=$year";
        $result = mysqli_query($connection, $query);
        confirm_query($result);
        return $result;
    }

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

    function get_vids($connection, $activity, $season, $year) {
        $query  = "SELECT av.thumbName, av.avName ";
        $query .= "FROM av ";
        $query .= "JOIN hsseasons on av.seasonId=hsseasons.id ";
        $query .= "WHERE av.subject=\"$activity\" AND av.video=1 ";
        $query .= "AND hsseasons.season=\"$season\" AND hsseasons.year=$year";
        $result = mysqli_query($connection, $query);
        confirm_query($result);
        return $result;
    }

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
?>