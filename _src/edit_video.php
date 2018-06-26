<?php
/*
 * MHM: 2017-02-12
 * Comment:
 *  Future support for edit videos.
 *
 * MHM: 2017-02-13
 * Comment:
 *  Removed variables pictures, videos and stats and now just use pIndex to
 *  reference the different panels.
 *
 * MHM: 2017-02-23
 * Comment:
 *  Support for updating a video in the av database.
 *
 * MHM: 2017-03-02
 * Comment:
 *  Add support for icons.
 *
 * MHM: 2017-03-20
 * Comment:
 *  Change form to allow selecting new file from a broswer. Also display the old name. Simplify validation.
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
    
    $videoId = $_POST['videoId'];
    $student = $_POST['studentName'];
    $season = $_POST['season'];
    $year = $_POST['year'];
    $pIndex = $_POST['pIndex'];
    $selection = $_POST['selection'];
    $thumbName = $_POST['thumbName'];
    $fileName = $_POST['fileName'];
    if ($thumbName == "") {
        $thumbName = $_POST['oldThumb'];
    } else {
        $fields_with_max_lengths = array("thumbName" => 30);
        validate_max_lengths($fields_with_max_lengths);
    }
    if ($fileName == "") {
        $fileName = $_POST['oldFileName'];
    } else {
        $fields_with_max_lengths = array("fileName" => 30);
        validate_max_lengths($fields_with_max_lengths);
    }
    $returnPage = $_POST['retPage'];
    
    if (empty($errors)) {
        /*
         * MHM: 17-02-12
         * Comment:
         *  Perform Edit.
         */
        $studentId = get_studentId($connection, $student);
        $seasonId = get_seasonId($connection, $season, $year);
        $dbVideo = 1;
        $result = update_av_into_av($connection, $videoId, $seasonId, $studentId, $dbVideo, $selection, $thumbName, $fileName);
        
        if ($result) {
            $_SESSION["message"] = "Video successfully updated in database.";
            close_db($connection);
            redirect_to("{$returnPage}");
        } else {
            $_SESSION["message"] = "Failed to edit video in database.";
            $errors["update"] = mysqli_error($connection);
        }
    }
}

if ((isset($_POST['submit'])) || (isset($_POST['edit']))) {
    if (isset($_POST['edit'])) {
        $videoId = $_POST['videoId'];
        $student = $_POST['studentName'];
        $season = $_POST['season'];
        $year = $_POST['year'];
        $pIndex = $_POST['pIndex'];
        $selection = $_POST['selection'];
        $returnPage = $_POST['retPage'];
        $pictureList = get_av_by_id($connection, $videoId);
        $pictureInfo = mysqli_fetch_assoc($pictureList);
        $fileName = $pictureInfo['avName'];
        $thumbName = $pictureInfo['thumbName'];
    }
    /*
     * Display the form
     */
?>
    <!DOCTYPE HTML>
    <html lang="en">
        <head>
            <meta charset="utf-8">
            <title>Edit a Picture</title>
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
                        <h1>Edit Video</h1>
                        <form action="edit_video.php" method="post">
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
                            </p>
                            <p>
                                <label>Current:</label>
                                <label class="dbfile"> <?= $thumbName ?></label>
                            </p>
                            <p>
                                <label>New:</label>
                                <input class="dbfile" type="file" name="thumbName">
                            </p>
                            <p>
                                <label>Picture:</label>
                            </p>
                            <p>
                                <label>Current:</label>
                                <label class="dbfile"> <?= $fileName ?></label>
                            </p>
                            <p>
                                <label>New:</label>
                                <input class="dbfile" type="file" name="fileName">
                            </p>
                            <br>
                            <input type="hidden" name="videoId" value="<?= $videoId ?>">
                            <input type="hidden" name="studentName" value="<?= $student ?>">
                            <input type="hidden" name="pIndex" value="<?= $pIndex ?>">
                            <input type="hidden" name="selection" value="<?= $selection ?>">
                            <input type="hidden" name="retPage" value="<?= $returnPage; ?>">
                            <input type="hidden" name="oldThumb" value="<?= $thumbName; ?>">
                            <input type="hidden" name="oldFileName" value="<?= $fileName; ?>">
                            <input type="submit" name="submit" value="Edit Video">
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