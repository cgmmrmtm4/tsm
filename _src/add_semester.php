<?php
/*
 * MHM: 2017-02-05
 * Comment:
 *  Future support for add semester.
 *
 * MHM: 2017-02-10
 * Comment:
 *  Chnaged layout of include directories. Also included logic for the add form.
 */
require("../_includes/req_includes.php");

$siteroot = HOMEROOT;
$imagepath = IMGROOT;
$pagelogo = "$imagepath" . PHOTOMISC . "/spft.jpg";
$selection = ACADEMIC;
$pictures = NOPICS;
$videos = NOVIDS;
$stats = NOSTATS;
        
if ((isset($_POST['submit'])) || (isset($_POST['add']))) {
    $student = $_POST['studentName'];
    if (isset($_POST['submit'])) {
        /*
         * Process the form
         */
        redirect_to("khp.php?studentName=$student");
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
        echo message();
        echo form_errors($errors);
?>
            <br>
            <section id=main>
                <h1>Add Class</h1>
                <div id=formalign>
                    <form action="add_semester.php?studentName=<?php echo $student; ?>" method="post">
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
                                <option value=2016>2017</option>
                                <option value=2017>2018</option>
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
                            <input id="d" type="text" name="className" value="">
                        </p>
                        <p> 
                            <label for="e">Teacher Name:</label>
                            <input id="e" type="text" name="teacherName" value="">
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
                        <input type="submit" name="submit" value="Create Class">
                        <a href="academics.php?studentName=<?php echo $student; ?>">Cancel</a>
                    </form>
                </div>
            </section>
        </div>
    </body>
</html>
<?php
} else {
    /*
     * This is neither a request for a new object, or the completion
     * of the previous form. So let's go back to HOME.
     */
    redirect_to("intro.php");
}
?>
