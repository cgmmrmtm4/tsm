<?php
/*
 * MHM: 2017-02-05
 * Comment:
 *  Future support for add semester.
 *
 * MHM: 2017-02-10
 * Comment:
 *  Changed layout of include directories. Also included logic for the add form.
 *
 * MHM: 2017-02-11
 * Comment:
 *  Have submit redirect to the season and year of the class being added.
 *  Have cancel return the the season and year that was shown when the add class button was selected.
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
 *  Fix alignment issues and field lengths.
 *
 * MHM: 2017-02-13
 * Comment:
 *  Free the correct SQL result.
 *
 * MHM: 2017-02-16
 * Comment:
 *  Full support for Add class.
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
    $required_fields = array("teacherName", "className");
    validate_presences($required_fields);
    
    $fields_with_max_lengths = array("teacherName" => 40, "className" => 40);
    validate_max_lengths($fields_with_max_lengths);
    
    $student = $_POST['studentName'];
    $season = $_POST['season'];
    $year = $_POST['year'];
    $selection = $_POST['selection'];
    $teacherName = mysql_prep($_POST['teacherName']);
    $className = mysql_prep($_POST['className']);
    $period = $_POST['period'];
    $grade = $_POST['grade'];
    $weighted = $_POST['weighted'];
    $honors = 0;
    $ap = 0;
    $returnPage = $_POST['retPage'];
    
    if (empty($errors)) {
        /*
         * MHM: 17-02-14
         * Comment:
         *  Marshal parameters for INSERT
         */
        
        $studentId = get_studentId($connection, $student);
        $seasonId = get_seasonId($connection, $season, $year);
        if ($weighted == HONORS) {
            $honors = 1;
        } else {
            if ($weighted == AP) {
                $ap = 1;
            }
        }
        
        $gp = convert_grade_to_gp($connection, $grade);
        if (($honors == 1) || ($ap == 1)) {
            $wgp = convert_grade_to_wgp($connection, $grade);
        } else {
            $wgp = $gp;
        }
        
        /*
         * MHM: 17-02-12
         * Comment:
         *  Perform create.
         */
        $result = insert_class_into_db($connection, $seasonId, $studentId, $period, $honors, $ap, $className, $teacherName, $grade, $gp, $wgp);
        
        if ($result) {
            $_SESSION["message"] = "Class successfully added to database.";
            close_db($connection);
            redirect_to("academics.php?studentName=$student&season=$season&year=$year");
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
        $teacherName = "";
        $className = "";
        $period = "";
        $grade = "";
        $weighted = "";
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
        <body id="page_academics">
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
                        <h1>Add Class</h1>
                        <form action="add_class.php" method="post">
                            <input type="hidden" name="studentName" value="<?= $student ?>">
                            <p> 
                                <label for="a">Season:</label>
                                <select id="a" name="season">
<?php
                                echo get_seasons($season, isset($_POST['submit']));
?>
                                </select>
                            </p>
                            <p> 
                                <label for="b">Year:</label>
                                <select id="b" name="year">
<?php
                                echo get_years($student, $year, isset($_POST['submit']));
?>
                                </select>
                            </p>
                            <p> 
                                <label for="c">Period:</label>
                                <select id="c" name="period">
<?php
                                echo get_periods($period, isset($_POST['submit']))
?>
                                </select>
                            </p>
                            <p>
<?php
                            if (isset($errors['className'])) {
?>
                                <label class="fielderror" for="d">Class Name:</label>
<?php                       
                            } else {
?>       
                                <label for="d">Class Name:</label>
<?php
                            }
?>
                                <input class="dbtext" maxlength="30" id="d" type="text" list="studentClasses" name="className" value="<?= htmlentities($className) ?>">
                                <datalist id="studentClasses">
<?php
                                $studentClassList = get_classes_by_student($connection, $student);
                                while ($studentClass = mysqli_fetch_assoc($studentClassList)) {
                                    $studentClassName = $studentClass["className"];
?>
                                    <option value="<?= $studentClassName ?>"><?= htmlentities($studentClassName) ?></option>
<?php
                                }
                                mysqli_free_result($studentClassList);
?>
                                </datalist>
                            </p>
                            <p>
                                <label>Class Weight:</label>
<?php
                                echo get_weighted($weighted, isset($_POST['submit']))
?>
                            </p>
                            <p>
<?php
                            if (isset($errors['teacherName'])) {
?>
                                <label class="fielderror" for="e">Teacher Name:</label>
<?php                       
                            } else {
?>
                                <label for="e">Teacher Name:</label>
<?php
                            }
?>
                                <input class="dbtext" maxlength="30" id="e" type="text" list="Teachers" name="teacherName" value="<?= htmlentities($teacherName) ?>">
                                <datalist id="Teachers">
<?php
                                $teacherList = get_teachers_by_student($connection, $student);
                                while ($teacher = mysqli_fetch_assoc($teacherList)) {
                                    $teacherName = $teacher["teacherName"];
?>
                                    <option value="<?= $teacherName ?>"><?= htmlentities($teacherName) ?></option>
<?php
                                }
                                mysqli_free_result($teacherList);
?>
                                </datalist>
                            </p>
                            <p> 
                                <label for="f">Grade:</label>
                                <select id="f" name="grade">
<?php
                                echo get_grade_letters($grade, isset($_POST['submit']))
?>
                                </select>
                            </p>
                            <br>
                            <input type="hidden" name="selection" value="<?= $selection ?>">
                            <input type="hidden" name="retPage" value="<?= $returnPage ?>">
                            <input type="submit" name="submit" value="Add Class">
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
