<?php
    require("../_includes/constants.php");
    $siteroot = HOMEROOT;
    $imagepath = IMGROOT;
    $pagelogo = "$imagepath" . PHOTOMISC . "/logo.jpg";
    if (isset($_GET['studentName'])) {
        $student = $_GET['studentName'];
    } else {
        $student = THEO;
    }
    $photopath = "$imagepath" . PHOTOACADEMICS;
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
            <?php require '../_includes/header.php'; ?>
            <section id="main">
                <div>
                    <img src="<?= $imagepath . PHOTOMISC; ?>/mbhs.jpg" height="200" class="floatLeft">
                    <img src="<?= $imagepath . PHOTOMISC; ?>/mrock.jpg" height="200" class="floatRight">
                </div>
                <div class="theoPic">
                    <img src="<?= $photopath . "/2015"; ?>/Theo.jpg" width="310" height="375" class="theoPic">
                </div>
            </section>
            <aside id="sidebar" class="clearfix">
                <article id="gradyr">
                    <h1>Work</h1>
                    <h2>in</h2>
                    <h1>Progress</h1>
                </article>
            </aside>
            <?php require '../_includes/copyright.php'; ?>
            <?php require '../_includes/footer.php'; ?>
        </div>
    </body>
</html>