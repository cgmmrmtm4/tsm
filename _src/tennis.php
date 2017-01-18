<?php
    /*
     * MHM: 2017-01-16
     *
     * Comment:
     *  Tennis main page.
     *  Include constants and set up global variables.
     *
     * MHM: 2017-01-18
     *
     * Comment:
     *  Added default values for video and stat variables.
     *
     */
    require("../_includes/constants.php");
    $siteroot = HOMEROOT;
    $imagepath = IMGROOT;
    $pagelogo = "$imagepath" . PHOTOMISC . "/tennis.png";
    $selection = TENNIS;
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

    /*
     * MHM: 2017-01-16
     *
     * Comment:
     *  Set picture path based on year.
     */
    $photopath = "$imagepath" . PHOTOSPORTS . "/" . TENNIS . "/" . $year;

    /*
     * MHM: 2017-01-16
     *
     * Comment:
     *  Assign banner pictures based on year.
     */
    if ($year == 2013) {
        $lbanner = "/P6260009-5.JPG";
        $rbanner = "/P6260014-5.JPG";
    } else { 
        $lbanner = "/P6260009-5.JPG";
        $rbanner = "/P6260014-5.JPG";
    }

    /*
     * MHM: 2017-01-16
     *
     * Comment:
     *  Include database and CRUD function calls
     */
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
            <?php 
                /*
                 * MHM: 2017-01-16
                 *
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
                     *
                     * Comment:
                     *  Sidebar navigation will either be for schedules/results, or pictures.
                     *  We can only have one of these choices. Will leave the area empty if more then one
                     *  choice is passed in.
                     */
                    if ($pictures == "nopics") {
                        /*
                         * MHM: 2017-01-16
                         *
                         * Comment:
                         *  Include Schedule and result.
                         */
                        require '../_includes/sched_res.php';
                    } 
                    if ($pictures == "pics") {
                        /*
                         * MHM: 2017-01-16
                         *
                         * Comment:
                         *  Include pictures page.
                         */
                        require '../_includes/display_pics.php';
                    } 
                    ?>
                </section>
                <aside id="sidebar" class="clearfix">
                    <?php 
                        /*
                         * MHM: 2017-01-16
                         *
                         * Comment:
                         *  Include sidebar navigational menu. Depending on sport,
                         *  this may include, schedule, picture, video and statistical
                         *  selections by year.
                         */
                        require '../_includes/selection_menu.php'; 
                    ?>
                    <article id="awards">
                        <h2>Awards</h2>
                        <ul>
                        <?php
                            /*
                             * MHM: 2017-01-16
                             *
                             * Comment:
                             *  If any exist, get the students awards for this sport
                             */
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
                    </article>
                </aside>
                <article>
                    <br>
                    <p id="demo"></p>
                </article>
            </main>
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
<?php
    /*
     * MHM: 2017-01-16
     *
     * Comment:
     *  Close database files
     */
    require_once("../_includes/db_close.php");
?>