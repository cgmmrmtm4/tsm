<?php
/*
 * MHM: 2017-02-12
 * Comment:
 *  Future support for edit game.
 *
 * MHM: 2017-02-13
 * Comment:
 *  Removed variables pictures, videos and stats and now just use pIndex to
 *  reference the different panels.
 *
 * MHM: 2017-02-21
 * Comment:
 *  Provide support for editing a game record.
 */
require("../_includes/req_includes.php");
$siteroot = HOMEROOT;
$imagepath = IMGROOT;
$pagelogo = "$imagepath" . PHOTOMISC . "/spft.jpg";
$matchScores = array();

$connection = open_db();
if (isset($_POST['submit'])) {
    /*
     * validate data
     */
    
    $required_fields = array("location", "opponent");
    validate_presences($required_fields);
    
    $fields_with_max_lengths = array("location" => 40, "opponent" => 40);
    validate_max_lengths($fields_with_max_lengths);
    
    $matchScores['matchmb'] = $_POST['matchmb'];
    $matchScores['matchopp'] = $_POST['matchopp'];
    $matchScores['mbs1'] = $_POST['mbs1'];
    $matchScores['mbs2'] = $_POST['mbs2'];
    $matchScores['mbs3'] = $_POST['mbs3'];
    $matchScores['mbs4'] = $_POST['mbs4'];
    $matchScores['mbs5'] = $_POST['mbs5']; 
    $matchScores['opps1'] = $_POST['opps1'];
    $matchScores['opps2'] = $_POST['opps2'];
    $matchScores['opps3'] = $_POST['opps3'];
    $matchScores['opps4'] = $_POST['opps4'];
    $matchScores['opps5'] = $_POST['opps5'];
    
    validate_match_score($matchScores);
    validate_game_scores($matchScores);
    
    $schedId = $_POST['schedId'];
    $student = $_POST['studentName'];
    $season = $_POST['season'];
    $year = $_POST['year'];
    $pIndex = $_POST['pIndex'];
    $selection = $_POST['selection'];
    $locationName = $_POST['location'];
    $opponentName = $_POST['opponent'];
    $month = $_POST['month'];
    $day = $_POST['day'];
    $returnPage = $_POST['retPage'];
    
    if (empty($errors)) {
        /*
         * MHM: 17-02-12
         * Comment:
         *  Perform modify.
         */
        
        $dbDate = $year . "-" . $month . "-" . $day;
        $dbScore = "";
        $maxGames = $matchScores['matchmb'] + $matchScores['matchopp'];
        for ($count=1; $count <= $maxGames; $count++) {
            $foo = "mbs";
            $foo .= $count;
            $mbScore = $matchScores[$foo];
            $foo = "opps";
            $foo .= $count;
            $oppScore = $matchScores[$foo];
            $dbScore .= $mbScore . " - " . $oppScore;
            if ($count < $maxGames) {
                $dbScore .= ", ";
            } else {
                $dbScore .= " ";
            }
        }
        $dbScore .= " (";
        $dbScore .= $matchScores['matchmb'] . " - " . $matchScores['matchopp'];
        $dbScore .= ")";
        if ($matchScores['matchmb'] > $matchScores['matchopp']) {
            $dbResult = "W";
        } else {
            if ($matchScores['matchmb'] < $matchScores['matchopp']) {
                $dbResult = "L";
            } else {
                $dbResult = "T";
            }
        }
        
        if (check_if_league_team($opponentName)) {
            $dbLeague = "*";
        } else {
            $dbLeague = "";
        }
        $seasonId = get_seasonId($connection, $season, $year);
        $sportId = get_sportId($connection, $seasonId);
        $result = update_game_into_records($connection, $schedId, $sportId, $dbDate, $locationName, $dbLeague, $opponentName, $dbScore, $dbResult);
        
        if ($result) {
            $_SESSION["message"] = "Game successfully updated in database.";
            close_db($connection);
            redirect_to("volleyball.php?studentName=$student&season=$season&pIndex=$pIndex&year=$year");
        } else {
            $_SESSION["message"] = "Failed to edit game in database!";
            $errors["update"] = mysqli_error($connection);
        }
    }
}

if ((isset($_POST['edit'])) || (isset($_POST['submit']))) {
    if (isset($_POST['edit'])) {
        $schedId = $_POST['schedId'];
        $student = $_POST['studentName'];
        $season = $_POST['season'];
        $year = $_POST['year'];
        $pIndex = $_POST['pIndex'];
        $selection = $_POST['selection'];
        $returnPage = $_POST['retPage'];
        $gameList = get_game_by_id($connection, $schedId);
        $gameInfo = mysqli_fetch_assoc($gameList);
        $sportId = $gameInfo['sportId'];
        $dbDate = $gameInfo['date'];
        $locationName = $gameInfo['location'];
        $dbLeague = $gameInfo['league'];
        $opponentName = $gameInfo['opponent'];
        $dbScore = $gameInfo['score'];
        $parseScores = preg_split("/[\s-,\)(]+/", $dbScore);
        $parseScoresLength = count($parseScores);
        $matchScores['matchmb'] = $parseScores[$parseScoresLength - 3];
        $matchScores['matchopp'] = $parseScores[$parseScoresLength - 2];
        $numberOfGames = $matchScores['matchmb'] + $matchScores['matchopp'];
        $matchScores['mbs1'] = $parseScores[0];
        $matchScores['opps1'] = $parseScores[1];
        if ($numberOfGames > 1) {
            $matchScores['mbs2'] = $parseScores[2];
            $matchScores['opps2'] = $parseScores[3];
        } else {
            $matchScores['mbs2'] = 0;
            $matchScores['opps2'] = 0;
        }
        if ($numberOfGames > 2) {
            $matchScores['mbs3'] = $parseScores[4];
            $matchScores['opps3'] = $parseScores[5];
        } else {
            $matchScores['mbs3'] = 0;
            $matchScores['opps3'] = 0;
        }
        if ($numberOfGames > 3) {
            $matchScores['mbs4'] = $parseScores[6];
            $matchScores['opps4'] = $parseScores[7];
        } else {
            $matchScores['mbs4'] = 0;
            $matchScores['opps4'] = 0;
        }
        if ($numberOfGames > 4) {
            $matchScores['mbs5'] = $parseScores[8];
            $matchScores['opps5'] = $parseScores[9];
        } else {
            $matchScores['mbs5'] = 0;
            $matchScores['opps5'] = 0;
        }
        
        $parseDate = preg_split("/-/", $dbDate);
        $month = $parseDate[1];
        $day = $parseDate[2];
    }
    
    /*
     * Display the form
     */
?>
<!DOCTYPE HTML>
    <html lang="en">
        <head>
        <meta charset="utf-8">
        <title>Update a Game</title>
        <link href="../_css/styles.css" rel="stylesheet" type="text/css">
        </head>
        <body id="page_volleyball">
            <div class="wrapper">
<?php
            /*
             * MHM: 2017-01-16
             * Comment:
             *  Include common navigational header.
             */
            require '../_includes/header.php';
?>
                <br>
                <section>
                    <div id=formalign>
                        <h1>Edit Game</h1>
                        <form action="edit_game.php" method="post">
                            <input type="hidden" name="schedId" value="<?= $schedId ?>">
                            <p> 
                                <label>Year:</label>
                                <select name="year">
<?php
                                echo get_years($student, $year, true);
?>
                                </select>
                            </p>
                            <p>
                                <label>Month:</label>
                                <input class="dbscore" type="number" name="month" min="2" max="5"   value="<?= $month ?>">
                            </p>
                            <p>
                                <label>Day:</label>
                                <input class="dbscore" type="number" name="day" min="1" max="31"   value="<?= $day ?>">
                            </p>
                            <p>
<?php
                            if (isset($errors['location'])) {
?>
                                <label class="fielderror">Location:</label>
<?php
                            } else {
?>
                                <label>Location:</label>
<?php
                            }
?>
                                <input class="dbtext" type="text" name="location" list="locationList" maxlength="40" value="<?= $locationName ?>">
                                <datalist id="locationList">
<?php
                                $locationList = get_records_locations($connection);
                                while ($location = mysqli_fetch_assoc($locationList)) {
                                    $locationName = $location["location"];
?>
                                    <option value="<?= $locationName ?>"><?= $locationName ?></option>
<?php
                                }
                                mysqli_free_result($locationList);
?>
                                </datalist>
                            </p>
                            <p>
<?php
                            if (isset($errors['opponent'])) {
?>
                                <label class="fielderror">Opponent:</label>
<?php
                            } else {
?>
                                <label>Opponent:</label>
<?php
                            }
?>
                                <input class="dbtext" type="text" name="opponent" list="opponentList" maxlength="40" value="<?= $opponentName ?>">
                                <datalist id="opponentList">
<?php
                                $opponentList = get_vbstats_opponents($connection);
                                while ($opponent = mysqli_fetch_assoc($opponentList)) {
                                    $opponentName = $opponent["opponent"];
?>
                                    <option value="<?= $opponentName ?>"><?= $opponentName ?></option>
<?php
                                }
                                mysqli_free_result($opponentList);
?>
                                </datalist>
                            </p>
<?php
                            echo get_score_fields(true, $matchScores);
?>    
                            <br>
                            <input type="hidden" name="studentName" value="<?= $student ?>">
                            <input type="hidden" name="season" value="<?= $season ?>">
                            <input type="hidden" name="pIndex" value="<?= $pIndex ?>">
                            <input type="hidden" name="selection" value="<?= $selection ?>">
                            <input type="hidden" name="retPage" value="<?= $returnPage; ?>">
                            <input type="submit" name="submit" value="Edit Game">
                            <a href="<?= $returnPage ?>">Cancel</a>
                        </form>
                    </div>
                </section>
            </div>
        </body>
    </html>
<?php
    close_db($connection);
} else {
    /*
     * This is neither a request for a new object, or the completion
     * of the previous form. So let's go back to HOME.
     */
    close_db($connection);
    redirect_to("intro.php");
}
?>