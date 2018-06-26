<?php
/*
 * MHM: 2017-10-26
 * Comment:
 *  Initial file from add_class.
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
    $required_fields = array("awardTitle");
    validate_presences($required_fields);
    
    $fields_with_max_lengths = array("awardTitle" => 40);
    validate_max_lengths($fields_with_max_lengths);
    
    $student = $_POST['studentName'];
    $season = $_POST['season'];
    $year = $_POST['year'];
    $selection = $_POST['selection'];
    $awardTitle = mysql_prep($_POST['awardTitle']);
    $returnPage = $_POST['retPage'];
    
    if (empty($errors)) {
        /*
         * MHM: 17-02-14
         * Comment:
         *  Marshal parameters for INSERT
         */
        
        $studentId = get_studentId($connection, $student);
        
        $result = insert_award_into_db($connection, $studentId, $selection, $year, $awardTitle);
        
        if ($result) {
            $_SESSION["message"] = "Class successfully added to database.";
            close_db($connection);
            redirect_to($returnPage);
        } else {
            $_SESSION["message"] = "Failed to add class to database.";
            $errors["insert"] = mysqli_error($connection);
        }
    }
}

if ((isset($_POST['add'])) || (isset($_POST['submit']))) {
    if (isset($_POST['add'])) {
        $student = $_POST['studentName'];
        $season = $_POST['season'];
        $year = $_POST['year'];
        $selection = $_POST['selection'];
        $returnPage = $_POST['retPage'];
        $awardTitle = "";
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
            <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        </head>
        <body id="awards">
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
                        <h1>Add Award</h1>
                        <form action="add_award.php" method="post">
                            <input type="hidden" name="studentName" value="<?= $student ?>">
                            <p> 
                                <label for="a">Year:</label>
                                <select id="a" name="year">
<?php
                                    echo get_years($student, $year, isset($_POST['submit']));
?>
                                </select>
                            </p>
                            <p>
<?php
                                if (isset($errors['awardTitle'])) {
?>
                                    <label class="fielderror" for="b">Award Title:</label>
<?php                       
                                } else {
?>       
                                    <label for="b">Award Title:</label>
<?php
                                }
?>
                                <input class="dbtext" maxlength="40" id="b" type="text" name="awardTitle">
                            </p>
                            <br>
                            <input type="hidden" name="selection" value="<?= $selection ?>">
                            <input type="hidden" name="retPage" value="<?= $returnPage ?>">
                            <input type="submit" name="submit" value="Add Award">
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