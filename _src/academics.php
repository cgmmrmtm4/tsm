<?php
    /*
     * MHM: 2017-01-16
     *
     * Comment:
     *  Academic main page.
     *  Include constants and set up global variables.
     *
     * MHM: 2017-01-18
     *
     * Comment:
     *  Added default values for video, picture and stat variables.
     *
     */
    require("../_includes/constants.php");
    $siteroot = HOMEROOT;
    $imagepath = IMGROOT;
    $pagelogo = "$imagepath" . PHOTOMISC . "/spft.jpg";
    $selection = ACADEMIC;
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
        <title>Morro Bay Academics 2015-2016</title>
        <link href="../_css/styles.css" rel="stylesheet" type="text/css">
    </head>
    <body id="page_academics">
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
                    <?php 
                        /*
                         * MHM: 2017-01-16
                         *
                         * Comment:
                         *  Include Semester results.
                         */
                        require '../_includes/displaysemester.php'; 
                    ?>
                </section>
                <aside id="sidebar" class="clearfix">
                    <?php
                        /*
                         * MHM: 2017-01-16
                         *
                         * Comment:
                         *  Include sidebar navigational menu.
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