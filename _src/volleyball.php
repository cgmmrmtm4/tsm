<?php 
    require("../_includes/constants.php");
    $siteroot = HOMEROOT;
    $imagepath = IMGROOT;
    $pagelogo = "$imagepath" . PHOTOMISC . "/bvb.jpg";
    $selection = VB;
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
    if (isset($_GET['pictures'])) {
        $pictures = $_GET['pictures'];
    } else {
        $pictures = NOPICS;
    }
    if (isset($_GET['videos'])) {
        $videos = $_GET['videos'];
    } else {
        $videos = NOVIDS;
    }
    if (isset($_GET['stats'])) {
        $stats = $_GET['stats'];
    } else {
        $stats = NOSTATS;
    }
    if (isset($_GET['year'])) {
        $year = $_GET['year'];
    } else {
        if ($student == THEO) {
            $year = 2016;
        } else {
            $year = 2009;
        }
    }
    $photopath = $imagepath . PHOTOSPORTS . "/" . VB . "/" . $year;
    $videopath = $imagepath . VIDEOSPORTS . "/" . VB . "/" . $year;
    if ($year == 2016) {
        $lbanner = "/IMGP4463-5.JPG";
        $rbanner = "/IMGP4466-5.JPG";
    } else {
        if ($year == 2015) {
            $lbanner = "/IMGP3816-5.JPG";
            $rbanner = "/IMGP3821-5.JPG";
        } else {
            $lbanner = "/P6260009-5.jpg";
            $rbanner = "/P6260014-5.jpg";
        }
    }
    require_once("../_includes/db_connection.php");
    require_once("../_includes/functions.php");
?>
<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <?php
            if ($student == THEO) {
        ?>
                <title>Morro Bay Volleyball 2015-2016</title>
        <?php
            } else {
        ?>
                <title>Morro Bay Volleyball 2009</title>
        <?php
            }
        ?>
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
                    if (($pictures == "nopics") && ($videos == "novideos") && ($stats == "nostats")) {
                        require '../_includes/sched_res.php';
                    } ?>
                    <?php
                    if (($pictures == "pics") && ($videos == "novideos") && ($stats == "nostats")) {
                        require '../_includes/display_pics.php';
                    } ?>
                    <?php
                    if (($pictures == "nopics") && ($videos == "videos") && ($stats == "nostats")) {
                        if ($student == THEO) {
                            require '../_includes/displayvolleyballvids.php';
                        }
                    }
                    ?>
                    <?php
                    if ($stats == "stats") {
                        if ($student == THEO) {
                            require '../_includes/displayvbstats.php';
                        }
                    }
                    ?>
                </section>
                <aside id="sidebar" class="clearfix">
                    <?php require '../_includes/selection_menu.php'; ?>
                    <!-- Select a school year -->
                    <article id="awards">
                        <h2>Awards</h2>
                        <ul>
                        <?php
                            $result = get_awards_by_catagory($connection, VB, $student);
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
            </main>
            <?php require '../_includes/copyright.php'; ?>
            <?php require '../_includes/footer.php'; ?>
        </div>
    </body>
</html>