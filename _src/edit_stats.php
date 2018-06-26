<?php
/*
 * MHM: 2017-02-12
 * Comment:
 *  Future support for edit stats.
 *
 * MHM: 2017-02-13
 * Comment:
 *  Removed variables pictures, videos and stats and now just use pIndex to
 *  reference the different panels.
 *
 * MHM: 2017-02-23
 * Comment;
 *  Support the edit functionality.
 *
 * MHM: 2017-03-02
 * Comment:
 *  Add support for icons.
 * 
 * MHM: 2018-06-25
 * Comment:
 *  Code cleanup.
 */
require("../_includes/req_includes.php");
$siteroot = HOMEROOT;
$imagepath = IMGROOT;
$pagelogo = "$imagepath" . PHOTOMISC . "/spft.jpg";

$connection = open_db();
if (isset($_POST['submit'])) {
    /*
     * validate data
     */
    
    $required_fields = array("opponent");
    validate_presences($required_fields);
    
    $fields_with_max_lengths = array("opponent" => 40);
    validate_max_lengths($fields_with_max_lengths);
    
    $statId = $_POST['statId'];
    $student = $_POST['studentName'];
    $season = $_POST['season'];
    $year = $_POST['year'];
    $pIndex = $_POST['pIndex'];
    $selection = $_POST['selection'];
    $returnPage = $_POST['retPage'];
    $opponentName = $_POST['opponent'];
    $dbAssists = $_POST['assists'];
    $dbBlocks = $_POST['blocks'];
    $dbKills = $_POST['kills'];
    $dbDigs = $_POST['digs'];
    $dbServes = $_POST['serves'];
    $dbAces = $_POST['aces'];
    $dbSideOuts = $_POST['sideOuts'];
    
    if (empty($errors)) {
        /*
         * MHM: 17-02-20
         * Comment:
         *  Perform modify.
         */
        $seasonId = get_seasonId($connection, $season, $year);
        $result = update_stats_into_vbstats($connection, $statId, $seasonId, $opponentName, $dbAssists, $dbBlocks, $dbKills, $dbDigs, $dbServes, $dbAces, $dbSideOuts);
        $errors['statId'] = $statId;
        
        if ($result) {
            $_SESSION["message"] = "Stats successfully updated in database.";
            close_db($connection);
            redirect_to("volleyball.php?studentName=$student&season=$season&pIndex=$pIndex&year=$year");
        } else {
            $_SESSION["message"] = "Failed to update stats in database!";
            $errors["update"] = mysqli_error($connection); 
        }
    }
}

if ((isset($_POST['edit'])) || (isset($_POST['submit']))) {
    if (isset($_POST['edit'])) {
        $statId = $_POST['statId'];
        $student = $_POST['studentName'];
        $season = $_POST['season'];
        $year = $_POST['year'];
        $pIndex = $_POST['pIndex'];
        $selection = $_POST['selection'];
        $returnPage = $_POST['retPage'];
        $statList = get_stats_by_id($connection, $statId);
        $statInfo = mysqli_fetch_assoc($statList);
        $seasonId = $statInfo['seasonId'];
        $opponentName = $statInfo['opponent'];
        $dbAssists = $statInfo['assists'];
        $dbBlocks = $statInfo['blocks'];
        $dbKills = $statInfo['kills'];
        $dbDigs = $statInfo['digs'];
        $dbServes = $statInfo['serves'];
        $dbAces = $statInfo['aces'];
        $dbSideOuts = $statInfo['sideouts'];
    }
    /*
     * Display the form
     */
    
?>
    <!DOCTYPE HTML>
    <html lang="en">
        <head>
            <meta charset="utf-8">
            <title>Update a Statistic</title>
            <link href="../_css/styles.css" rel="stylesheet" type="text/css">
            <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
                        <h1>Update Statistics</h1>
                        <form action="edit_stats.php" method="post">
                            <p> 
                                <label>Year:</label>
                                <select name="year">
<?php
                                    echo get_years($student, $year, true);
?>
                                </select>
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
                            <p>
                                <label>Assists:</label>
                                <input class="dbnum" type="number" name="assists" min="0" value="<?= $dbAssists ?>">
                                <label>Blocks:</label>
                                <input class="dbnum" type="number" name="blocks" min="0" value="<?= $dbBlocks ?>">
                            </p>
                            <p>
                                <label>Kills:</label>
                                <input class="dbnum" type="number" name="kills" min="0" value="<?= $dbKills ?>">
                                <label>Digs:</label>
                                <input class="dbnum" type="number" name="digs" min="0" value="<?= $dbDigs ?>">
                            </p>
                            <p>
                                <label>Serves:</label>
                                <input class="dbnum" type="number" name="serves" min="0" value="<?= $dbServes ?>">
                                <label>Aces:</label>
                                <input class="dbnum" type="number" name="aces" min="0" value="<?= $dbAces ?>">
                            </p>
                            <p>
                                <label>Side Out:</label>
                                <input class="dbnum" type="number" name="sideOuts" min="0" value="<?= $dbSideOuts ?>">
                            </p>
                            <br>
                            <input type="hidden" name="statId" value="<?= $statId ?>">
                            <input type="hidden" name="studentName" value="<?= $student ?>">
                            <input type="hidden" name="season" value="<?= $season ?>">
                            <input type="hidden" name="pIndex" value="<?= $pIndex ?>">
                            <input type="hidden" name="selection" value="<?= $selection ?>">
                            <input type="hidden" name="retPage" value="<?= $returnPage; ?>">
                            <input type="submit" name="submit" value="Edit Stats">
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