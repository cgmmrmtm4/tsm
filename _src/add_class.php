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
 */
require("../_includes/req_includes.php");

$siteroot = HOMEROOT;
$imagepath = IMGROOT;
$pagelogo = "$imagepath" . PHOTOMISC . "/spft.jpg";
$pictures = NOPICS;
$videos = NOVIDS;
$stats = NOSTATS;

$connection = open_db();
if (isset($_POST['submit'])) {
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
            $_SESSION["message"] = "Class successfully added to database.";
            close_db($connection);
            redirect_to("academics.php?studentName=$student&season=$season&year=$year");
        } else {
            $_SESSION["message"] = "Failed to add class to database.";
        }
    }
}

if ((isset($_POST['add'])) || (isset($_POST['submit']))) {
    $student = $_POST['studentName'];
    $season = $_POST['season'];
    $year = $_POST['year'];
    $selection = $_POST['selection'];
    
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
                <section id=main>
                    <h1>Add Class</h1>
                    <div id=formalign>
                        <form action="add_class.php" method="post">
                            <input type="hidden" name="studentName" value="<?= $student ?>">
                            <p> 
                                <label for="a">Season:</label>
                                <select id="a" name="season">
                                    <option value="SUMMER">SUMMER</option>
                                    <option value="FALL">FALL</option>
                                    <option value="SPRING">SPRING</option>
                                </select>
                            </p>
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
                            <p> 
                                <label for="c">Period:</label>
                                <select id="c" name="period">
<?php
                                for ($count=0; $count <= 7; $count++) {
                                    echo "<option value=\"{$count}\">{$count}</option>";
                                }
?>
                                </select>
                            </p>
                            <p> 
                                <label for="d">Class Name:</label>
                                <input id="d" type="text" list="studentClasses" name="className" value="">
                                <datalist id="studentClasses">
<?php
                                $studentClassList = get_classes_by_student($connection, $student);
                                while ($studentClass = mysqli_fetch_assoc($studentClassList)) {
                                    $studentClassName = $studentClass["className"];
?>
                                    <option value="<?= $studentClassName ?>"><?= $studentClassName ?></option>
<?php
                                }
                                mysqli_free_result($teacherList);
?>
                                </datalist>
                            </p>
                            <p> 
                                <label for="e">Teacher Name:</label>
                                <input id="e" type="text" list="Teachers" name="teacherName" value="">
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
                                <label for="f">Grade:</label>
                                <select id="f" name="grade">
                                    <option value="A+">A+</option>
                                    <option value="A">A</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B">B</option>
                                    <option value="B-">B-</option>
                                    <option value="C+">C+</option>
                                    <option value="C">C</option>
                                    <option value="C-">C-</option>
                                    <option value="D">D</option>
                                    <option value="F">F</option>
                                </select>
                            </p>
                            <br>
                            <input type="submit" name="submit" value="Add Class">
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
