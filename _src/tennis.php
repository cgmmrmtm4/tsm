<?php
    require("../_includes/constants.php");
    $siteroot = HOMEROOT;
    $imagepath = IMGROOT;
    $pagelogo = "$imagepath" . PHOTOMISC . "/tennis.png";
    $selection = TENNIS;
    if (isset($_GET['studentName'])) {
        $student = $_GET['studentName'];
    } else {
        $student = RACHEL;
    }
    if (isset($_GET['season'])) {
        $season = $_GET['season'];
    } else {
        $season = FALL;
    }
    if (isset($_GET['pictures'])) {
        $pictures = $_GET['pictures'];
    } else {
        $pictures = NOPICS;
    }
    if (isset($_GET['year'])) {
        $year = $_GET['year'];
    } else {
        $year = 2012;
    }
    $photopath = "$imagepath" . PHOTOSPORTS . "/" . TENNIS . "/" . $year;
    if ($year == 2013) {
        $lbanner = "/P6260009-5.JPG";
        $rbanner = "/P6260014-5.JPG";
    } else { 
        $lbanner = "/P6260009-5.JPG";
        $rbanner = "/P6260014-5.JPG";
    }
    require_once("../_includes/db_connection.php");
    require_once("../_includes/functions.php");
?>
<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Tennis 2012-2013</title>
        <link href="../_css/styles.css" rel="stylesheet" type="text/css">
    </head>
    <body id="page_volleyball">
        <div class="wrapper">
            <?php require '../_includes/header.php'; ?>
            <main role="main">
                <br>
                <section id="main">
                    <div class=vbpics>
                        <img src="<?= $photopath . $lbanner; ?>" class="sportLeft">
                        <img src="<?= $photopath . $rbanner; ?>" class="sportRight">
                    </div>
                    <?php 
                    if ($pictures == "nopics") {
                        require '../_includes/sched_res.php';
                    } ?>
                    <?php 
                    if ($pictures == "pics") {
                        require '../_includes/displaytennispics.php';
                    } ?>
                </section>
                <aside id="sidebar" class="clearfix">
                    <?php require '../_includes/selection_menu.php'; ?>
                    <!-- Select a school year -->
                    <article id="awards">
                        <h2>Awards</h2>
                        <ul>
                        <?php
                            $result = get_awards_by_catagory($connection, SB, $student);
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
                        <p id="demo"></p>
                    </article>
                </aside>
                <article>
                    <br>
                    <p id="demo"></p>
                </article>
            </main>
            <?php require '../_includes/copyright.php'; ?>
            <?php require '../_includes/footer.php'; ?>
        </div>
    </body>
</html>