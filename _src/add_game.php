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
 */
require("../_includes/req_includes.php");
    
$siteroot = HOMEROOT;
$imagepath = IMGROOT;
$pagelogo = "$imagepath" . PHOTOMISC . "/spft.jpg";

$_SESSION["message"] = "Not Implemented yet!";
$connection = open_db();
if (isset($_POST['submit'])) {
    $student = $_POST['studentName'];
    $season = $_POST['season'];
    $year = $_POST['year'];
    $pIndex = $_POST['pIndex'];
    $selection = $_POST['selection'];
    $returnPage = $_POST['retPage'];
    /*
     * validate data
     */
    
    if (empty($errors)) {
        /*
         * MHM: 17-02-12
         * Comment:
         *  Perform create.
         */
        $_SESSION["message"] = "Not Implemented yet!";
        close_db($connection);
        redirect_to("$returnPage?studentName=$student&season=$season&pIndex=$pIndex&year=$year");
    }
}
if ((isset($_POST['submit'])) || (isset($_POST['add']))) {
    $student = $_POST['studentName'];
    $season = $_POST['season'];
    $year = $_POST['year'];
    $pIndex = $_POST['pIndex'];
    $selection = $_POST['selection'];
    $returnPage = $_POST['retPage'];
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
                <section id=main>
                    <h1>Add Game</h1>
                    <div id=formalign>
                        <form action="add_game.php" method="post">
<?php
                        if ($student == THEO) {
?>
                            <p> 
                                <label for="b">Year:</label>
                                <select id="b" name="year">
                                    <option value=2014>2014</option>
                                    <option value=2015>2015</option>
                                    <option value=2016>2016</option>
                                    <option value=2017>2017</option>
                                    <option value=2018>2018</option>
                                </select>
                            </p>
<?php
                        } else {
?>
                            <p> 
                                <label for="b">Year:</label>
                                <select id="b" name="year">
                                    <option value=2009>2009</option>
                                    <option value=2010>2010</option>
                                    <option value=2011>2011</option>
                                    <option value=2012>2012</option>
                                    <option value=2013>2013</option>
                                </select>
                            </p>
<?php
                        }
?>
                            <br>
                            <input type="hidden" name="studentName" value="<?= $student ?>">
                            <input type="hidden" name="season" value="<?= $season ?>">
                            <input type="hidden" name="year" value="<?= $year ?>">
                            <input type="hidden" name="pIndex" value="<?= $pIndex ?>">
                            <input type="hidden" name="selection" value="<?= $selection ?>">
                            <input type="hidden" name="retPage" value="<?= $returnPage; ?>">
                            <input type="submit" name="submit" value="Add Game">
                            <a href="<?= $returnPage ?>?studentName=<?= $student; ?>&season=<?= $season; ?>&pIndex=<?= $pIndex ?>&year=<?= $year; ?>">Cancel</a>
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
        