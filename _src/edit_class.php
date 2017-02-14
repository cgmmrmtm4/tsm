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
 */
require("../_includes/req_includes.php");
$siteroot = HOMEROOT;
$imagepath = IMGROOT;
$pagelogo = "$imagepath" . PHOTOMISC . "/spft.jpg";

$connection = open_db();
if (isset($_POST['submit'])) {
    $classId = $_POST[classId];
    $student = $_POST['studentName'];
    $season = $_POST['season'];
    $year = $_POST['year'];
    $selection = $_POST['selection'];
    /*
     * validate data
     */
    
    if (empty($errors)) {
        /*
         * MHM: 17-02-12
         * Comment:
         *  Perform create.
         */
        $result = false;
        if ($result) {
            $_SESSION["message"] = "Class successfully changed in database.";
            close_db($connection);
            redirect_to("academics.php?studentName=$student&season=$season&year=$year");
        } else {
            $_SESSION["message"] = "Failed to change class in database.";
        }
    }
}

if ((isset($_POST['edit'])) || (isset($_POST['submit']))) {
    $classId = $_POST[classId];
    $student = $_POST['studentName'];
    $season = $_POST['season'];
    $year = $_POST['year'];
    $selection = $_POST['selection'];
    
    $classList = get_class_by_id($connection, $classId);
    $classInfo = mysqli_fetch_assoc($classList)
    
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
                                <label for="a">Period:</label>
                                <select id="a" name="period">
<?php
                                for ($count=0; $count <= 7; $count++) {
                                    if ($count == $classInfo['period']) {
                                        echo "<option selected=\"selected\" value=\"{$count}\">{$count}</option>";
                                    } else {
                                        echo "<option value=\"{$count}\">{$count}</option>";
                                    }
                                }
?>
                                </select>
                            </p>
                            <p> 
                                <label for="b">Class Name:</label>
                                <input class="dbtext" maxlength="30" id="b" type="text" list="studentClasses" name="className" value="<?= $classInfo['className'] ?>">
                                <datalist id="studentClasses">
<?php
                                $studentClassList = get_classes_by_student($connection, $student);
                                while ($studentClass = mysqli_fetch_assoc($studentClassList)) {
                                    $studentClassName = $studentClass["className"];
?>
                                    <option value="<?= $studentClassName ?>"><?= $studentClassName ?></option>
<?php
                                }
                                mysqli_free_result($studentList);
?>
                                </datalist>
                            </p>
                            <p> 
                                <label for="c">Teacher Name:</label>
                                <input class="dbtext" maxlength="30" id="c" type="text" list="Teachers" name="teacherName" value="<?= $classInfo['teacherName'] ?>">
                                <datalist id="Teachers">
<?php
                                $teacherList = get_teachers_by_student($connection, $student);
                                while ($teacher = mysqli_fetch_assoc($teacherList)) {
                                    $teacherName = $teacher["teacherName"];
?>
                                    <option value="<?= $teacherName ?>"><?= $teacherName ?></option>
<?php
                                }
                                mysqli_free_result($teacherList);
?>
                                </datalist>
                            </p>
                            <p> 
                                <label for="d">Grade:</label>
                                <select id="d" name="grade">
<?php
                                $gradeArray = array("A+", "A", "A-", "B+", "B", "B-", "C+", "C", "C-", "D", "F");
                                $gradeArrayLength = count($gradeArray);
                                for ($count=0; $count < $gradeArrayLength; $count++) {
                                    if ($gradeArray[$count] == $classInfo['grade']) {
                                        echo "<option selected=\"selected\" value=\"{$gradeArray[$count]}\">{$gradeArray[$count]}</option>";
                                    } else {
                                        echo "<option value=\"{$gradeArray[$count]}\">{$gradeArray[$count]}</option>";
                                    }
                                }
?>
                                </select>
                            </p>
                            <br>
                            <input type="submit" name="submit" value="Edit Class">
                            <a href="academics.php?studentName=<?php echo $student; ?>&season=<?php echo $season; ?>&year=<?php echo $year; ?>">Cancel</a>
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