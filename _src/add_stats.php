<?php
/*
 * MHM: 2017-02-05
 * Comment:
 *  Future support for add stats.
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
 *  reference the different panels.
 *
 * MHM: 2017-02-13
 * Comment:
 *  Populate the form.
 *
 * MHM: 2013-02-23
 * Comment:
 *  Support the add functionality.
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
         * MHM: 17-02-12
         * Comment:
         *  Perform create.
         */
        $seasonId = get_seasonId($connection, $season, $year);
        $result = insert_stats_into_vbstats($connection, $seasonId, $opponentName, $dbAssists, $dbBlocks, $dbKills, $dbDigs, $dbServes, $dbAces, $dbSideOuts);
        
        if ($result) {
            $_SESSION["message"] = "Stats successfully added to database.";
            close_db($connection);
            redirect_to("volleyball.php?studentName=$student&season=$season&pIndex=$pIndex&year=$year");
        } else {
            $_SESSION["message"] = "Failed to add stats to database!";
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
        $opponentName = "";
        $dbAssists = 0;
        $dbBlocks = 0;
        $dbKills = 0;
        $dbDigs = 0;
        $dbServes = 0;
        $dbAces = 0;
        $dbSideOuts = 0;
    }
    /*
     * Display the form
     */
    
?>
    <!DOCTYPE HTML>
    <html lang="en">
        <head>
            <meta charset="utf-8">
            <title>Add a Statistic</title>
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
                        <h1>Add Statistics</h1>
                        <form action="add_stats.php" method="post">
                            <p> 
                                <label>Year:</label>
                                <select name="year">
<?php
                                    $dbYear = date('Y');
                                    echo get_years($student, $dbYear, true);
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
                            <input type="hidden" name="studentName" value="<?= $student ?>">
                            <input type="hidden" name="season" value="<?= $season ?>">
                            <input type="hidden" name="pIndex" value="<?= $pIndex ?>">
                            <input type="hidden" name="selection" value="<?= $selection ?>">
                            <input type="hidden" name="retPage" value="<?= $returnPage; ?>">
                            <input type="submit" name="submit" value="Add Stats">
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