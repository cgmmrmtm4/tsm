<?php
/*
 * MHM: 2017-01-16
 * Comment:
 *  Volleyball main page.
 *  Include constants and set up global variables.
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
 * MHM: 2017-02-20
 * Comment:
 *  Replace if/else with case statement to control pictures below the navigation bar.
 *
 * MHM: 2017-02-23
 * Comment:
 *  Remove need for leading / in database entry.
 *
 * MHM: 2017-03-02
 * Comment:
 *  Add support for icons.
 *
 * MHM: 2017-03-20
 * Comment:
 *  Add banner pictures for 2017 and change defaults to be the 2017 values.
 *
 * MHM: 2017-10-26
 * Comment:
 *  Support to add additonal awards.
 *
 * MHM: 2018-04-25
 * Comment:
 *  Default Theo to 2018 information.
 *
 * MHM: 2018-06-24
 * Comment:
 *  Centralized the awards logic and cleaned up the title text.
 * 
 * MHM: 2018-06-25
 * Comment:
 *  Code cleanup.
 */
require("../_includes/req_includes.php");
$siteroot = HOMEROOT;
$imagepath = IMGROOT;
$pagelogo = "$imagepath" . PHOTOMISC . "/bvb.jpg";
$selection = VB;

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
        $season = SPRING;
    } else {
        $season = FALL;
    }
}
if (isset($_GET['pIndex'])) {
    $pIndex = $_GET['pIndex'];
} else {
    $pIndex = SCHED;
}
if (isset($_GET['year'])) {
    $year = $_GET['year'];
} else {
    if ($student == THEO) {
        $year = 2018;
    } else {
        $year = 2009;
    }
}

/*
 * MHM: 2017-01-16
 * Comment:
 *  Set picture and video paths based on year.
 */
$photopath = $imagepath . PHOTOSPORTS . "/" . VB . "/" . $year . "/";
$videopath = $imagepath . VIDEOSPORTS . "/" . VB . "/" . $year . "/";

/*
 * MHM: 2017-01-16
 * Comment:
 *  Assign banner pictures based on year.
 */
switch ($year) {
    case 2017:
        $lbanner = "IMGP6046-5.JPG";
        $rbanner = "IMGP6035-5.JPG";
        break;
    case 2016:
        $lbanner = "IMGP4463-5.JPG";
        $rbanner = "IMGP4466-5.JPG";
        break;
    case 2015:
        $lbanner = "IMGP3816-5.JPG";
        $rbanner = "IMGP3821-5.JPG";
        break;
    case 2009:
        $lbanner = "P6260009-5.jpg";
        $rbanner = "P6260014-5.jpg";
        break;
    default:
        $lbanner = "IMGP6046-5.JPG";
        $rbanner = "IMGP6035-5.JPG";
        break;
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
        <title>MBHS Volleyball <?= $pIndex ?> <?= $year ?> </title>
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
            <main role="main">
                <br>
                <section id="main">
                    <div class=vbpics>
                        <img src="<?= $photopath . $lbanner; ?>" class="sportLeft">
                        <img src="<?= $photopath . $rbanner; ?>" class="sportRight">
                    </div>
<?php
                    /*
                     * MHM: 2017-01-16
                     * Comment:
                     *  Sidebar navigation will either be for schedules/results, pictures, videos or stats
                     *  We can only have one of these choices. Will leave the area empty if more then one
                     *  choice is passed in.
                     */
                    if ($pIndex == SCHED) {
                        /*
                         * MHM: 2017-01-16
                         * Comment:
                         *  Include Schedule and result.
                         */
                        require '../_includes/sched_res.php';
                    }
                    if ($pIndex == PICS) {
                        /*
                         * MHM: 2017-01-16
                         * Comment:
                         *  Include pictures page.
                         */
                        require '../_includes/display_pics.php';
                    }
                    if ($pIndex == VIDS) {
                        /*
                         * MHM: 2017-01-16
                         * Comment:
                         *  Include videos only for Theodore.
                         */
                        if ($student == THEO) {
                            require '../_includes/displayvolleyballvids.php';
                        }
                    }
                    if ($pIndex == STATS) {
                        /*
                         * MHM: 2017-01-16
                         * Comment:
                         *  Include stats only for Theodore.
                         */
                        if ($student == THEO) {
                            require '../_includes/displayvbstats.php';
                        }
                    }
?>
                </section>
                <aside id="sidebar" class="clearfix">
<?php
                    /*
                     * MHM: 2017-01-16
                     * Comment:
                     *  Include sidebar navigational menu. Depending on sport,
                     *  this may include, schedule, picture, video and statistical
                     *  selections by year.
                     */
                    require '../_includes/selection_menu.php'; 
                    require '../_includes/awards_menu.php';
?>
                </aside>
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