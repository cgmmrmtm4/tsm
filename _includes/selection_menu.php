<?php
    /*
     * MHM: 2017-01-16
     *
     * Comment:
     *  Do not allow direct access to include files.
     *  selection_menu.php:
     *      Set up side navigation window.
     *      Depending on the page, the sidebar will allow you to select
     *      Semester, Result/Schedule, Pictures, Videos or Statistics by
     *      year.
     */
    if (count(get_included_files()) == 1) {
            exit("direct access not allowed.");
    }
?>
<article id="select_menu">
<?php
    /*
     * MHM: 2017-01-16
     *
     * Comment:
     *  Will either be an academic or a season selector
     */
    if ($selection == ACADEMIC) {
?>
    <h2 class="highlight">Select a Semester</h2>
<?php
    /*
     * MHM: 2017-01-16
     *
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
     *
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
         *
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
                <input type="submit" value="<?= $getSubLabel?>">
            </form>
    <?php
        }
        /*
         * MHM: 2017-01-16
         *
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
         *
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
             *
             * Comment:
             *  Figure out the number of navigation buttons we'll need for this picture gallery.
             */
            $result = get_activity_av_seasons($connection, $selection, 0, $student);
        
            /*
             * MHM: 2017-01-16
             *
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
                    <input type="hidden" name="pictures" value="pics">
                    <input type="hidden" name="year" value="<?= $get_year ?>">
                    <input type="submit" value="<?= $getSubLabel?>">
                </form>
        <?php
            }
            /*
             * MHM: 2017-01-16
             *
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
             *
             * Comment:
             *  If volleyball and Theodore we need a video and statistic navigation area.
             */
            if (($selection == VB) && ($student == THEO)) {
    ?>
    <h2 class="highlight">Video Gallary</h2>
    <nav>
        <form method="get" action="<?= $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" name="studentName" value="<?= $student ?>">
            <input type="hidden" name="videos" value="videos">
            <input type="hidden" name="year" value=2016>
            <input type="submit" value="Videos 2016">
        </form>
    </nav>
    <br>
    <h2 class="highlight">Statistics</h2>
    <nav>
        <form method="get" action="<?= $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" name="studentName" value="<?= $student ?>">
            <input type="hidden" name="stats" value="stats">
            <input type="hidden" name="year" value=2016>
            <input type="submit" value="Stats 2016">
        </form>
    </nav>
    <?php
            }
        }
    ?>
</article>