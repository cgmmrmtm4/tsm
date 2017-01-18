<?php
    /*
     * MHM: 2017-01-16
     *
     * Comment:
     *  Student selection, site, home page.
     *  Include constants and set up global variables.
     *
     * MHM: 2017-01-18
     *
     * Comment:
     *  Added $selection variable to be consistant with all pages.
     *
     */
    require '../_includes/constants.php';
    $siteroot = HOMEROOT;
    $imagepath = IMGROOT;
    $pagelogo = "$imagepath" . PHOTOMISC . "/logo.jpg";
    $selection = HOME;

    /*
     * MHM: 2017-01-16
     *
     * Comment:
     *  Set picture path based on year.
     */
    $photopath = "$imagepath" . PHOTOACADEMICS;
    $student=null;
?>
<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Our kids high school page page 2009-2018</title>
        <link href="../_css/styles.css" rel="stylesheet" type="text/css">
    </head>
    <body id="page_home">
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
                    <a href="<?= $siteroot; ?>/_src/khp.php?studentName=<?= RACHEL ?>">
                        <img src="<?= $photopath . "/2013"; ?>/S7300662.jpg"  width="310" height="375" class="floatLeft">
                    </a>
                    <a href="<?= $siteroot; ?>/_src/khp.php?studentName=<?= THEO ?>">
                        <img src="<?= $photopath . "/2015"; ?>/Theo.jpg"  width="310" height="375" class="floatLeft">
                    </a>
                </div>
                <br>
                <p id="demo"></p>
            </section>
            <aside id="sidebar" class="clearfix">
                <article id="gradyr">
                    <h1>Our</h1>
                    <h1>Morro Bay</h1>
                    <h1>High School</h1>
                    <h1>Students</h1>
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