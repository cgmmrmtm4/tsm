<?php
/*
 * MHM: 2017-01-16
 * Comment:
 *  Academic main page.
 *  Include constants and set up global variables.
 *
 * MHM: 2017-01-18
 * Comment:
 *  Added default values for video, picture and stat variables.
 *
 * MHM: 2017-02-10
 * Comment:
 *  Changes for include layout. Some format changes so the code 
 *  does not sprawl so far to the right.
 *
 * MHM: 2017-02-13
 * Comment:
 *  Removed variables pictures, videos and stats and now just use pIndex to
 *  reference the different panels.
 *
 * MHM: 2017-03-02
 * Comment:
 *  Add support for icons.
 */
require("../_includes/req_includes.php");
$siteroot = HOMEROOT;
$imagepath = IMGROOT;
$pagelogo = "$imagepath" . PHOTOMISC . "/spft.jpg";
$selection = ACADEMIC;
$pIndex = SCHED;

/*
 * MHM: 2017-01-16
 * Comment:
 *  Check which $_GET variables have been passed in via the URL.
 *  Set to default values if nothing was passed in.
 */
if (isset($_GET['studentName'])) {
    $student = $_GET['studentName'];
} else {
    $student = THEO;
}
if (isset($_GET['season'])) {
    $season = $_GET['season'];
} else {
    if ($student == THEO) {
        $season = FALL;
    } else {
        $season = SPRING;
    }
}
if (isset($_GET['year'])) {
    $year = $_GET['year'];
} else {
    if ($student == THEO) {
        $year = 2016;
    } else {
        $year = 2013;
    }
}

/*
 * MHM: 2017-01-16
 * Comment:
 *  Include database and CRUD function calls
 */
$connection = open_db();
?>
<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Morro Bay Academics 2015-2016</title>
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
            <main role="main">
                <br>
                <section id="main">
<?php 
                /*
                 * MHM: 2017-01-16
                 * Comment:
                 *  Include Semester results.
                 */
                require '../_includes/displaysemester.php'; 
?>
                </section>
                <aside id="sidebar" class="clearfix">
<?php
                /*
                 * MHM: 2017-01-16
                 * Comment:
                 *  Include sidebar navigational menu.
                 */
                require '../_includes/selection_menu.php'; 
?>
                    <article id="awards">
                        <h2>Awards</h2>
                        <ul>
<?php
                        /*
                         * MHM: 2017-01-16
                         * Comment:
                         *  If any exist, get the students awards for this sport
                         */
                        $result = get_awards_by_catagory($connection, ACADEMIC, $student);
                        while ($award = mysqli_fetch_assoc($result)) {
                            $awardYear = $award["year"];
                            $awardTitle = $award["title"];
                            $awardString = $awardYear . " " . $awardTitle;
?>
                            <li><?= $awardString ?></li>
<?php
                        }
?>
                        </ul>
                    </article>
                </aside>
                <article>
                    <br>
                    <p id="demo"></p>
                </article>
            </main>
<?php 
        /*
         * MHM: 2017-01-16
         * Comment:
         *  Include copyright and footer information.
         */
        require '../_includes/footer.php'; 
?>
        </div>
    </body>
</html>
<?php
/*
 * MHM: 2017-01-16
 * Comment:
 *  Close database files
 */
close_db($connection);
?>