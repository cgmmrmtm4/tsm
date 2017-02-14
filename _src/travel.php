<?php
/*
 * MHM: 2017-01-16
 * Comment:
 *  Travel main page.
 *  Include constants and set up global variables.
 *
 * MHM: 2017-01-18
 * Comment:
 *  Added $selection variable to be consistant with all pages.
 *  Also added check for $year so page will load properly while
 *  under construction.
 * 
 *  Added default values for video, picture and stat variables.
 *
 * MHM: 2017-01-19
 * Comment:
 *  Restructure page to match other pages.
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
 * MHM: 2017-02-13
 * Comment:
 *  Forgot to declare pIndex.
 */
require("../_includes/req_includes.php");
$siteroot = HOMEROOT;
$imagepath = IMGROOT;
$pagelogo = "$imagepath" . PHOTOMISC . "/logo.jpg";
$selection = TRAVEL;
$year = 2016;
$season = SUMMER;
$pIndex = PICS;

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

/*
 * MHM: 2017-01-16
 * Comment:
 *  Set picture path based on year.
 */
$photopath = "$imagepath" . PHOTOTRAVEL. "/" . $year;

/*
 * MHM: 2017-01-19
 * Comment:
 *  Assign banner pictures based on year.
 */

$lbanner = "/Theo-5.JPG";
$rbanner = "/IMG_3561-5.JPG";

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
        <title>Morro Bay Academic Travel</title>
        <link href="../_css/styles.css" rel="stylesheet" type="text/css">
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
                 *  Sidebar navigation will only be pictures.
                 */
                    
                require '../_includes/display_pics.php';
?>
                </section>
                <aside id="sidebar" class="clearfix">
<?php
                /*
                 * MHM: 2017-01-16
                 * Comment:
                 *  Include sidebar navigational menu. Only pictures for travel by year.
                 */
                require '../_includes/selection_menu.php'; 
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