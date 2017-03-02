<?php
/*
 * MHM: 2017-02-05
 * Comment:
 *  Future support for add pictures.
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
 *  reference the different panels. Check student Name to determine years to display.
 *
 * MHM: 2017-02-13
 * Comment:
 *  Add form fields.
 *
 * MHM: 2017-02-23
 * Comment:
 *  Support add picture.
 *
 * MHM: 2017-03-02
 * Comment:
 *  Add support for icons and fixed return page.
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
    
    $required_fields = array("thumbName", "fileName");
    validate_presences($required_fields);
    
    $fields_with_max_lengths = array("thumbName" => 30, "fileName" => 30);
    validate_max_lengths($fields_with_max_lengths);
    
    $student = $_POST['studentName'];
    $season = $_POST['season'];
    $year = $_POST['year'];
    $pIndex = $_POST['pIndex'];
    $selection = $_POST['selection'];
    $thumbName = $_POST['thumbName'];
    $fileName = $_POST['fileName'];
    $returnPage = $_POST['retPage'];
    
    if (empty($errors)) {
        /*
         * MHM: 17-02-12
         * Comment:
         *  Perform create.
         */
        $studentId = get_studentId($connection, $student);
        $seasonId = get_seasonId($connection, $season, $year);
        $dbVideo = 0;
        $result = insert_av_into_av($connection, $seasonId, $studentId, $dbVideo, $selection, $thumbName, $fileName);
        
        if ($result) {
            $_SESSION["message"] = "Picture successfully added to database.";
            close_db($connection);
            redirect_to("volleyball.php?studentName=$student&season=$season&pIndex=$pIndex&year=$year");
        } else {
            $_SESSION["message"] = "Failed to picture to database.";
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
        $fileName = "";
        $thumbName = "";
    }
    /*
     * Display the form
     */
?>
    <!DOCTYPE HTML>
    <html lang="en">
        <head>
        <meta charset="utf-8">
        <title>Add a Picture</title>
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
                        <h1>Add Picture</h1>
                        <form action="add_picture.php" method="post">
                            <p> 
                                <label>Season:</label>
                                <select name="season">
<?php
                                echo get_seasons($season, true);
?>
                                </select>
                            </p>
                            <p> 
                                <label>Year:</label>
                                <select name="year">
<?php
                                echo get_years($student, $year, true);
?>
                                </select>
                            </p>
                            <p> 
                                <label>Thumbnail:</label>
                                <input class="dbtext" maxlength="30" type="text" name="thumbName" value="<?= $thumbName ?>">
                            </p>
                            <p> 
                                <label>File Name:</label>
                                <input class="dbtext" maxlength="30" type="text" name="fileName" value="<?= $fileName ?>">
                            </p>
                            <br>
                            <input type="hidden" name="studentName" value="<?= $student ?>">
                            <input type="hidden" name="pIndex" value="<?= $pIndex ?>">
                            <input type="hidden" name="selection" value="<?= $selection ?>">
                            <input type="hidden" name="retPage" value="<?= $returnPage; ?>">
                            <input type="submit" name="submit" value="Add Picture">
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
        