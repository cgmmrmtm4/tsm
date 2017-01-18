<?php
    /*
     * MHM: 2017-01-16
     *
     * Comment:
     *  Travel main page.
     *  Include constants and set up global variables.
     *
     * MHM: 2017-01-18
     *
     * Comment:
     *  Added $selection variable to be consistant with all pages.
     *  Also added check for $year so page will load properly while
     *  under construction.
     * 
     *  Added default values for video, picture and stat variables.
     *
     */
    require("../_includes/constants.php");
    $siteroot = HOMEROOT;
    $imagepath = IMGROOT;
    $pagelogo = "$imagepath" . PHOTOMISC . "/logo.jpg";
    $selection = TRAVEL;
    $pictures = NOPICS;
    $videos = NOVIDS;
    $stats = NOSTATS;

    /*
     * MHM: 2017-01-16
     *
     * Comment:
     *  Check which $_GET variables have been passed in via the URL.
     *  Set to default values if nothing was passed in.
     */
    if (isset($_GET['studentName'])) {
        $student = $_GET['studentName'];
    } else {
        $student = THEO;
    }
    if (isset($_GET['year'])) {
        $year = $_GET['year'];
    } else {
        $year = 2016;
    }
    /*
     * MHM: 2017-01-16
     *
     * Comment:
     *  Set picture path based on year.
     */
    $photopath = "$imagepath" . PHOTOTRAVEL. "/" . $year;
?>
<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Morro Bay 2015-2016</title>
        <link href="../_css/styles.css" rel="stylesheet" type="text/css">
    </head>
    <body id="page_travel">
        <div class="wrapper">
            <?php 
                /*
                 * MHM: 2017-01-16
                 *
                 * Comment:
                 *  Include common navigational header.
                 */
                require '../_includes/header.php'; 
            ?>
            <section id="main">
                <div>
                    <img src="<?= $imagepath . PHOTOMISC; ?>/mbhs.jpg" height="200" class="floatLeft">
                    <img src="<?= $imagepath . PHOTOMISC; ?>/mrock.jpg" height="200" class="floatRight">
                </div>
                <div class="theoPic">
                    <img src="<?= $photopath; ?>/Theo.jpg" width="310" height="375" class="theoPic">
                </div>
            </section>
            <aside id="sidebar" class="clearfix">
                <article id="gradyr">
                    <h1>Work</h1>
                    <h2>in</h2>
                    <h1>Progress</h1>
                </article>
            </aside>
            <?php 
                /*
                 * MHM: 2017-01-16
                 *
                 * Comment:
                 *  Include copyright and footer information.
                 */    
                require '../_includes/copyright.php';
                require '../_includes/footer.php'; 
            ?>
        </div>
    </body>
</html>