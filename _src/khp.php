<?php
    require '../_includes/constants.php';
    $siteroot = HOMEROOT;
    $imagepath = IMGROOT;
    $pagelogo = "$imagepath" . PHOTOMISC . "/logo.jpg";
    if (isset($_GET['studentName'])) {
        $student = $_GET['studentName'];
    } else {
        $student = THEO;
    }
    if (($student != RACHEL) && ($student != THEO)) {
        $student = THEO;
    }
?>
<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <?php
            if ($student == THEO) {
        ?>
                <title>Morro Bay Theo's page 2014-2018</title>
        <?php
            } else {
        ?>
                <title>Morro Bay Rachel's page 2009-2013</title>
        <?php
            }
        ?>
        <link href="../_css/styles.css" rel="stylesheet" type="text/css">
    </head>
    <body id="page_home">
        <div class="wrapper">
            <?php require '../_includes/header.php'; ?>
            <section id="main">
                <div>
                    <img src="<?= $imagepath . PHOTOMISC; ?>/mbhs.jpg" height="200" class="floatLeft">
                    <img src="<?= $imagepath . PHOTOMISC; ?>/mrock.jpg" height="200" class="floatRight">
                </div>
                <div class="theoPic">
                    <?php
                        if ($student == THEO) {
                    ?>
                            <img src="<?= $imagepath . PHOTOACADEMICS . "/2015"; ?>/Theo.jpg" width="310" height="375" class="theoPic">
                    <?php
                        } else {
                    ?>
                            <img src="<?= $imagepath . PHOTOACADEMICS . "/2013"; ?>/S7300662.jpg" width="310" height="375" class="theoPic">
                    <?php
                        }
                    ?>
                </div>
                <br>
                <p id="demo"></p>
            </section>
            <aside id="sidebar" class="clearfix">
                <article id="gradyr">
                    <?php
                        if ($student == THEO) {
                    ?>
                            <h1>Class</h1>
                            <h2>of</h2>
                            <h1>2018</h1>
                    <?php
                        } else {
                    ?>
                            <h1>Class</h1>
                            <h2>of</h2>
                            <h1>2013</h1>
                    <?php
                        }
                    ?>
                </article>
            </aside>
            <?php require '../_includes/copyright.php'; ?>
            <?php require '../_includes/footer.php'; ?>
        </div>
    </body>
</html>