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
 *
 * MHM: 2017-10-26
 * Comment:
 *  Change Theo's default academic list to be the fall of 2017.
 *  Support to add additional awards.
 *
 * MHM: 2018-01-17
 * Comment:
 *  Theo now defaults to spring of 2018.
 * 
 * MHM: 2018-06-24
 * Comment:
 *  Centralized the awards logic and cleaned up the title text.
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
    $season = SPRING;
}
if (isset($_GET['year'])) {
    $year = $_GET['year'];
} else {
    if ($student == THEO) {
        $year = 2018;
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
        <title>MBHS Academics <?= $season ?> <?= $year ?></title>
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
                require '../_includes/awards_menu.php';
?>                    
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