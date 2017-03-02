<?php
/*
 * MHM: 2017-01-16
 * Comment:
 *  Do not allow direct access to include files.
 *  selection_menu.php:
 *      Set up side navigation window.
 *      Depending on the page, the sidebar will allow you to select
 *      Semester, Result/Schedule, Pictures, Videos or Statistics by
 *      year.
 *
 * MHM: 2017-01-18
 * Comment:
 *  Add class selected to the input[type=submit] line so that the seleccted tab can
 *  be highlighted in the sidebar menu area. Add logic to ensure that only one tab
 *  is highlighted when there are multiple tab sections in the sidebar navigation
 *  area.
 *
 * MHM: 2017-01-19
 * Comment:
 *  Changes needed to support the travel page, since that page only has a picture gallery.
 *  Need to refactor this file to simplify. Since the forms are almost equal, we may be able
 *  to use just one form definition instead of four.
 *
 * MHM: 2017-01-21
 * Comment:
 *  Simplify get_vb_stat_season(). We really only need the database handle.
 *
 * MHM: 2017-02-05
 * Comment:
 *  Add the Add button for all side panel navigation buttons. Also change the submit
 *  name from submit to add. This will allow us to use the add_*.php files in multiple
 *  ways.
 *
 * MHM: 2017-02-06
 * Comment:
 *  Remove test for number of rows to determine if the add semester button should be visible.
 *  It was not working correctly. For now, just check for Theo. Will need to add logic so the
 *  add semester button will not show up after June of 2018.
 *  Change Add Semester to Add Class, Change Add Season to Add Game.
 *
 * MHM: 2017-02-10
 * Comment:
 *  Some format changes so the code does not sprawl so far to the right.
 *
 * MHM: 2017-02-12
 * Comment:
 *  Pass the correct season and year to the add class form.
 *
 * MHM: 2017-02-13
 * Comment:
 *  Removed variables pictures, videos and stats and now just use pIndex to
 *  reference the different panels.
 *
 * MHM: 2017-02-16
 * Comment:
 *  Modified URLs in cancel links to take optional parameters
 *
 * MHM: 2017-02-23
 * Comment:
 *  Set return page correctly when adding a game or statistic.
 *  Also set stat year correctly to highlight the correct stat button.
 *  Provide the add buttons in the selection menu, only when your showing
 *  the selected subjects group. Fixed indentation issue.
 */
if (count(get_included_files()) == 1) {
    exit("direct access not allowed.");
}
?>
<article id="select_menu">
    <div id="topbar">
        <h2 class="highlight"><?= $selection ?> <i class="material-icons">menu</i></h2>
        <div id="tophiddenbar">
<?php
        /*
         * MHM: 2017-01-16
         * Comment:
         *  Will either be an academic or a season selector
         */
        if ($selection != TRAVEL) {
            if ($selection == ACADEMIC) {
?>
                <h2 class="highlight">Select a Semester</h2>
<?php
                /*
                 * MHM: 2017-01-16
                 * Comment:
                 *  Figure out the number of semester buttons we'll neeed.
                 */
                $result = get_academic_years($connection, $student);
            } else {
?>
                <h2 class="highlight">Select a Season</h2>
<?php
                /*
                 * MHM: 2017-01-16
                 * Comment:
                 *  Figure out the number of navigation buttons we'll need for this sport.
                 */
                $result = get_sport_seasons($connection, $selection, $student);
            }
?>
                <nav>
<?php
                /*
                 * MHM: 2017-01-16
                 * Comment:
                 *  Display all of the buttons and their GET actions when the button is selected.
                 */
                while ($semester = mysqli_fetch_assoc($result)) {
                    $get_season = $semester["season"];
                    $get_year = $semester["year"];
                    $getSubLabel = $get_season . " " . $get_year;
?>
                    <form method="get" action="<?= $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" name="studentName" value="<?= $student ?>">
                        <input type="hidden" name="season" value="<?= $get_season ?>">
                        <input type="hidden" name="year" value="<?= $get_year ?>">
<?php
                        /*
                         * MHM: 2017-01-18
                         * Comment:
                         *  Need to find a better way then this long if statement to ensure that only the select semester
                         *  tab is highlighted.
                         * 
                         */
                        if (($season == $get_season) && ($year == $get_year) && ($pIndex == SCHED)) {
                            echo "<input class=\"selected\" type=\"submit\" value=\"$getSubLabel\">";
                        } else {
                            echo "<input type=\"submit\" value=\"$getSubLabel\">";
                        }
?>
                    </form>
<?php
                }
                if ($selection == ACADEMIC) {
                    if ($student == THEO) {
?>
                        <form method="post" action="add_class.php">
                            <input type="hidden" name="studentName" value="<?= $student ?>">
                            <input type="hidden" name="season" value="<?= $season ?>">
                            <input type="hidden" name="year" value="<?= $year ?>">
                            <input type="hidden" name="pIndex" value="<?= $pIndex ?>">
                            <input type="hidden" name="selection" value="<?= $selection ?>">
                            <input type="hidden" name="retPage" value="<?= $_SERVER['PHP_SELF'] ?>?studentName=<?= $student ?>&season=<?= $season ?>&year=<?= $year ?>">
                            <input class="useicon" type="submit" name="add" value="&#xE145;">
                        </form>
<?php
                    }
                } else {
                    if ($pIndex == SCHED) {
?>
                        <form method="post" action="add_game.php">
                            <input type="hidden" name="studentName" value="<?= $student ?>">
                            <input type="hidden" name="season" value="<?= $season ?>">
                            <input type="hidden" name="year" value="<?= $year ?>">
                            <input type="hidden" name="pIndex" value="<?= $pIndex ?>">
                            <input type="hidden" name="selection" value="<?= $selection ?>">
                            <input type="hidden" name="retPage" value="<?= $_SERVER['PHP_SELF'] ?>?studentName=<?= $student ?>&season=<?= $season ?>&pIndex=<?= $pIndex ?>&year=<?= $year ?>">
                            <input class="useicon" type="submit" name="add" value="&#xE145;">
                        </form>
<?php
                    }
                }
                   
                /*
                 * MHM: 2017-01-16
                 * Comment:
                 *  Free results from database query
                 */
                mysqli_free_result($result);
?>
                </nav>
                <br>
<?php
        }
        /*
         * MHM: 2017-01-16
         * Comment:
         *  If not academic, we will always have a picture gallery.
         */
        if ($selection != ACADEMIC) {
?>
            <h2 class="highlight">Picture Gallery</h2>
            <nav>
<?php
            /*
             * MHM: 2017-01-16
             * Comment:
             *  Figure out the number of navigation buttons we'll need for this picture gallery.
             */
            $result = get_activity_av_seasons($connection, $selection, 0, $student);
        
            /*
             * MHM: 2017-01-16
             * Comment:
             *  Display all of the buttons and their GET actions when the button is selected.
             */
        
            while ($picform = mysqli_fetch_assoc($result)) {
                $get_season = $picform["season"];
                $get_year = $picform["year"];
                $getSubLabel = $get_season . " " . $get_year;
?>
                <form method="get" action="<?= $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="studentName" value="<?= $student ?>">
                    <input type="hidden" name="season" value="<?= $get_season ?>">
                    <input type="hidden" name="pIndex" value="<?= constant("PICS") ?>">
                    <input type="hidden" name="year" value="<?= $get_year ?>">
<?php
                    if (($season == $get_season) && ($year == $get_year) && ($pIndex == PICS)) {
                        echo "<input class=\"selected\" type=\"submit\" value=\"$getSubLabel\">";
                    } else {
                        echo "<input type=\"submit\" value=\"$getSubLabel\">";
                    }
?>
                </form>
<?php
            }
            if ($pIndex == PICS) {
?>
                <form method="post" action="add_picture.php">
                    <input type="hidden" name="studentName" value="<?= $student ?>">
                    <input type="hidden" name="season" value="<?= $season ?>">
                    <input type="hidden" name="year" value="<?= $year ?>">
                    <input type="hidden" name="pIndex" value="<?= $pIndex ?>">
                    <input type="hidden" name="selection" value="<?= $selection ?>">
                    <input type="hidden" name="retPage" value="<?= $_SERVER['PHP_SELF'] ?>?studentName=<?= $student ?>&season=<?= $season ?>&pIndex=<?= $pIndex ?>&year=<?= $year ?>">
                    <input class="useicon" type="submit" name="add" value="&#xE145;">
                </form>
<?php
            }
            /*
             * MHM: 2017-01-16
             * Comment:
             *  Free results from database query
             */
            mysqli_free_result($result);
?>
            </nav>
            <br>
<?php
            /*
             * MHM: 2017-01-16
             * Comment:
             *  If volleyball and Theodore we need a video and statistic navigation area.
             */
            if (($selection == VB) && ($student == THEO)) {
?>
                <h2 class="highlight">Video Gallary</h2>
                <nav>
<?php
                /*
                 * MHM: 2017-01-17
                 * Comment:
                 *  Figure out the number of navigation buttons we'll need for this video gallery.
                 */
                $result = get_activity_av_seasons($connection, $selection, 1, $student);
        
                /*
                 * MHM: 2017-01-17
                 * Comment:
                 *  Display all of the buttons and their GET actions when the button is selected.
                 */
        
                while ($picform = mysqli_fetch_assoc($result)) {
                    $get_season = $picform["season"];
                    $get_year = $picform["year"];
                    $getSubLabel = $get_season . " " . $get_year;
?>
        
                    <form method="get" action="<?= $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" name="studentName" value="<?= $student ?>">
                        <input type="hidden" name="season" value="<?= $get_season ?>">
                        <input type="hidden" name="pIndex" value="<?= constant("VIDS") ?>">
                        <input type="hidden" name="year" value="<?= $get_year ?>">
<?php
                        if (($season == $get_season) && ($year == $get_year) && ($pIndex == VIDS)) {
                            echo "<input class=\"selected\" type=\"submit\" value=\"$getSubLabel\">";
                        } else {
                            echo "<input type=\"submit\" value=\"$getSubLabel\">";
                        }
?>
                    </form>
<?php
                }
                if ($pIndex == VIDS) {
?>
                    <form method="post" action="add_video.php">
                        <input type="hidden" name="studentName" value="<?= $student ?>">
                        <input type="hidden" name="season" value="<?= $season ?>">
                        <input type="hidden" name="year" value="<?= $year ?>">
                        <input type="hidden" name="pIndex" value="<?= $pIndex ?>">
                        <input type="hidden" name="selection" value="<?= $selection ?>">
                        <input type="hidden" name="retPage" value="<?= $_SERVER['PHP_SELF'] ?>?studentName=<?= $student ?>&season=<?= $season ?>&pIndex=<?= $pIndex ?>&year=<?= $year ?>">
                        <input class="useicon" type="submit" name="add" value="&#xE145;">
                    </form>
<?php
                }
                /*
                 * MHM: 2017-01-17
                 * Comment:
                 *  Free results from database query
                 */
                mysqli_free_result($result);
?>
                </nav>
                <br>
                <h2 class="highlight">Statistics</h2>
                <nav>
<?php
                /*
                 * MHM: 2017-01-19
                 * Comment:
                 *  Figure out the number of navigation buttons we'll need for this statistics area.
                 */
                $result = get_vb_stat_seasons($connection);
        
                /*
                 * MHM: 2017-01-19
                 * Comment:
                 *  Display all of the buttons and their GET actions when the button is selected.
                 */
                
                while ($picform = mysqli_fetch_assoc($result)) {
                    $get_season = $picform["season"];
                    $get_year = $picform["year"];
                    $getSubLabel = $get_season . " " . $get_year;
?>
        
                    <form method="get" action="<?= $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" name="studentName" value="<?= $student ?>">
                        <input type="hidden" name="season" value="<?= $get_season ?>">
                        <input type="hidden" name="pIndex" value="<?= constant("STATS") ?>">
                        <input type="hidden" name="year" value="<?= $get_year ?>">
<?php
                        if (($season == $get_season) && ($year == $get_year) && ($pIndex == STATS)) {
                            echo "<input class=\"selected\" type=\"submit\" value=\"$getSubLabel\">";
                        } else {
                            echo "<input type=\"submit\" value=\"$getSubLabel\">";
                        }
?>
                    </form>
<?php
                }
                if ($pIndex == STATS) {
?>
                    <form method="post" action="add_stats.php">
                        <input type="hidden" name="studentName" value="<?= $student ?>">
                        <input type="hidden" name="season" value="<?= $season ?>">
                        <input type="hidden" name="year" value="<?= $year ?>">
                        <input type="hidden" name="pIndex" value="<?= $pIndex ?>">
                        <input type="hidden" name="selection" value="<?= $selection ?>">
                        <input type="hidden" name="retPage" value="<?= $_SERVER['PHP_SELF'] ?>?studentName=<?= $student ?>&season=<?= $season ?>&pIndex=<?= $pIndex ?>&year=<?= $year ?>">
                        <input class="useicon" type="submit" name="add" value="&#xE145;">
                    </form>
<?php
                }
                /*
                 * MHM: 2017-01-19
                 * Comment:
                 *  Free results from database query
                 */
                mysqli_free_result($result);
?>
                </nav>
<?php
            }
        }
?>
        </div>
    </div>
</article>