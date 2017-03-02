<?php
/*
 * MHM: 2017-02-12
 * Comment:
 *  Future support for edit classess.
 *
 * MHM: 2017-02-13
 * Comment:
 *  Removed variables pictures, videos and stats and now just use pIndex to
 *  reference the different panels.
 *
 * MHM: 2017-02-13
 * Comment:
 *  Add functional to load the form with the database entry to update.
 *
 * MHM: 2017-02-16
 * Comment:
 *  Full support for edit class.
 *
 * MHM: 2017-02-21
 * Comment:
 *  Fixed incorrect comment.
 *
 * MHM: 2017-03-02
 * Comment:
 *  Add support for icons.
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
    
    $classId = $_POST['classId'];
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
         * MHM: 17-02-12
         * Comment:
         *  Perform create.
         */
        $result = false;
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
         *  Perform modify.
         */
        /*$errors["seasonId"] = $seasonId;
        $errors["studentId"] = $studentId;
        $errors["period"] = $period;
        $errors["honors"] = $honors;
        $errors["ap"] = $ap;
        $errors["className"] = $className;
        $errors["teacherName"] = $teacherName;
        $errors["grade"] = $grade;
        $errors["gp"] = $gp;
        $errors["wgp"] = $wgp;
        $result = false;*/
        $result = update_class_into_db($connection, $classId, $seasonId, $studentId, $period, $honors, $ap, $className, $teacherName, $grade, $gp, $wgp);
        
        if ($result) {
            $_SESSION["message"] = "Class successfully changed in database.";
            close_db($connection);
            redirect_to("academics.php?studentName=$student&season=$season&year=$year");
        } else {
            $_SESSION["message"] = "Failed to change class in database.";
            $errors["update"] = mysqli_error($connection);
        }
    }
}

if ((isset($_POST['edit'])) || (isset($_POST['submit']))) {
    if (isset($_POST['edit'])) {
        $classId = $_POST[classId];
        $student = $_POST['studentName'];
        $season = $_POST['season'];
        $year = $_POST['year'];
        $selection = $_POST['selection'];
        $returnPage = $_POST['retPage'];
        $classList = get_class_by_id($connection, $classId);
        $classInfo = mysqli_fetch_assoc($classList);
        $teacherName = $classInfo['teacherName'];
        $className = $classInfo['className'];
        $period = $classInfo['period'];
        $grade = $classInfo['grade'];
        $ap = $classInfo['AP'];
        $honors = $classInfo['honors'];
        $studentId = $classInfo['studentId'];
        $seasonId = $classInfo['seasonId'];
    }
    
    if ($ap == 1) {
        $weighted = AP;
    } else {
        if ($honors == 1) {
            $weighted = HONORS;
        } else {
            $weighted = NORMAL;
        }
    }
    
    /*
     * Display the form
     */
?>
    <!DOCTYPE HTML>
    <html lang="en">
        <head>
        <meta charset="utf-8">
        <title>Update a Class</title>
        <link href="../_css/styles.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
                        <h1>Edit Class</h1>
                        <form action="edit_class.php" method="post">
                            <input type="hidden" name="classId" value="<?= $classId ?>">
                            <input type="hidden" name="studentName" value="<?= $student ?>">
                            <p> 
                                <label for="a">Season:</label>
                                <select id="a" name="season">
<?php
                                echo get_seasons($season, true);
?>
                                </select>
                            </p>
                            <p> 
                                <label for="b">Year:</label>
                                <select id="b" name="year">
<?php
                                echo get_years($student, $year, true);
?>
                                </select>
                            </p>
                            <p> 
                                <label for="c">Period:</label>
                                <select id="c" name="period">
<?php
                                echo get_periods($period, true);
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
                                echo get_weighted($weighted, true);
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
                                echo get_grade_letters($grade, true);
?>
                                </select>
                            </p>
                            <br>
                            <input type="hidden" name="selection" value="<?= $selection ?>">
                            <input type="hidden" name="retPage" value="<?= $returnPage ?>">
                            <input type="submit" name="submit" value="Edit Class">
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