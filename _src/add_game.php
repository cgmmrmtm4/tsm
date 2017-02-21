<?php
/*
 * MHM: 2017-02-05
 * Comment:
 *  Future support for add game to season.
 *
 * MHM: 2017-02-10
 * Comment:
 *  Changes for include layout. Some format changes so the code 
 *  does not sprawl so far to the right.
 *
 * MHM: 2017-02-12
 * Comment:
 *  Initial layout to support add. Three parts, submit: called only from this file.
 *  Add and submit: Add called from external location, submit used to handle form error recovery.
 *  GET: return to intro page. Need to have a message for this case.
 *
 * MHM: 2017-02-13
 * Comment:
 *  Removed variables pictures, videos and stats and now just use pIndex to
 *  reference the different panels. Use student to determine years to display.
 *
 * MHM: 2017-02-13
 * Comment:
 *  Fix alignment issues and field lenghts.
 *
 * MHM: 2017-02-13
 * Comment:
 *  Assign ids to the input tags in the forms that match their label. Retrieve opponents and
 *  locatons from the record database to help autofill the form.
 *
 * MHM: 2017-02-20
 * Comment:
 *  Add full support for add game to the records database.
 */
require("../_includes/req_includes.php");
    
$siteroot = HOMEROOT;
$imagepath = IMGROOT;
$pagelogo = "$imagepath" . PHOTOMISC . "/spft.jpg";
$matchScores = array();

$_SESSION["message"] = "Not Implemented yet!";
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
         *  Perform create.
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
        $result = insert_game_into_records($connection, $sportId, $dbDate, $locationName, $dbLeague, $opponentName, $dbScore, $dbResult);
        
        if ($result) {
            $_SESSION["message"] = "Game successfully added to database.";
            close_db($connection);
            redirect_to("volleyball.php?studentName=$student&season=$season&pIndex=$pIndex&year=$year");
        } else {
            $_SESSION["message"] = "Failed to add game to database!";
            $errors["insert"] = mysqli_error($connection);
        }
    }
}
if ((isset($_POST['submit'])) || (isset($_POST['add']))) {
    if (isset($_POST['add'])) {
        $student = $_POST['studentName'];
        $season = $_POST['season'];
        $year = $_POST['year'];
        $pIndex = $_POST['pIndex'];
        $selection = $_POST['selection'];
        $returnPage = $_POST['retPage'];
        $locationName = "";
        $opponentName = "";
        $month = "";
        $day = "";
        $matchScores['matchmb'] = 0;
        $matchScores['matchopp'] = 0;
        $matchScores['mbs1'] = 0;
        $matchScores['mbs2'] = 0;
        $matchScores['mbs3'] = 0;
        $matchScores['mbs4'] = 0;
        $matchScores['mbs5'] = 0; 
        $matchScores['opps1'] = 0;
        $matchScores['opps2'] = 0;
        $matchScores['opps3'] = 0;
        $matchScores['opps4'] = 0;
        $matchScores['opps5'] = 0;
    }
    /*
     * Display the form
     */
    ?>
    <!DOCTYPE HTML>
    <html lang="en">
        <head>
        <meta charset="utf-8">
        <title>Add a Class</title>
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
                        <h1>Add Game</h1>
                        <form action="add_game.php" method="post">
                            <p> 
                                <label>Year:</label>
                                <select name="year">
<?php
                                echo get_years($student, $year, isset($_POST['submit']));
?>
                                </select>
                            </p>
                            <p>
<?php
                            if (isset($_POST['submit'])) {
                                $dvalue = $_POST['month'];
                            } else {
                                $dvalue = 2;
                            }
?>
                                <label>Month:</label>
                                <input class="dbscore" type="number" name="month" min="2" max="5"   value="<?= $dvalue ?>">
                            </p>
                            <p>
<?php
                            if (isset($_POST['submit'])) {
                                $dvalue = $_POST['day'];
                            } else {
                                $dvalue = 1;
                            }
?>
                                <label>Day:</label>
                                <input class="dbscore" type="number" name="day" min="1" max="31"   value="<?= $dvalue ?>">
                            </p>
                            <p>
                                <label>Location:</label>
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
                                <label>Opponent:</label>
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
                            echo get_score_fields(isset($_POST['submit']), $matchScores);
?>    
                            <br>
                            <input type="hidden" name="studentName" value="<?= $student ?>">
                            <input type="hidden" name="season" value="<?= $season ?>">
                            <input type="hidden" name="pIndex" value="<?= $pIndex ?>">
                            <input type="hidden" name="selection" value="<?= $selection ?>">
                            <input type="hidden" name="retPage" value="<?= $returnPage; ?>">
                            <input type="submit" name="submit" value="Add Game">
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
        