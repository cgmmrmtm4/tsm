<?php
    require("../_includes/constants.php");
    $siteroot = HOMEROOT;
    $imagepath = IMGROOT;
    $pagelogo = "$imagepath" . PHOTOMISC . "/spft.jpg";
    $selection = ACADEMIC;
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
    require_once("../_includes/db_connection.php");
    require_once("../_includes/functions.php");
?>
<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Morro Bay Academics 2015-2016</title>
        <link href="../_css/styles.css" rel="stylesheet" type="text/css">
    </head>
    <body id="page_academics">
        <div class="wrapper">
            <?php require '../_includes/header.php'; ?>
            <main role="main">
                <br>
                <section id="main">
                    <?php require '../_includes/displaysemester.php'; ?>
                </section>
                <aside id="sidebar" class="clearfix">
                    <?php require '../_includes/selection_menu.php'; ?>
                    <!-- Select a school year -->
                    <article id="awards">
                        <h2>Awards</h2>
                        <ul>
                        <?php
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
<?php
    require_once("../_includes/db_close.php");
?>