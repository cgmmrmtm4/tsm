<?php
    if (count(get_included_files()) == 1) {
            exit("direct access not allowed.");
    }
?>
<article id="select_menu">
<?php
    if ($selection == ACADEMIC) {
?>
    <h2 class="highlight">Select a Semester</h2>
<?php
    // get all academic years, free results;
    $result = get_academic_years($connection, $student);
} else {
?>
    <h2 class="highlight">Select a Season</h2>
<?php
    // Perfrom query to get nav buttons
    $result = get_sport_seasons($connection, $selection, $student);
}
?>
    <nav>
    <?php
        // Use return data (if any)
        while ($semester = mysqli_fetch_assoc($result)) {
            $get_season = $semester["season"];
            $get_year = $semester["year"];
            $getSubLabel = $get_season . " " . $get_year;
            // output data from each row
    ?>
            <form method="get" action="<?= $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" name="studentName" value="<?= $student ?>">
                <input type="hidden" name="season" value="<?= $get_season ?>">
                <input type="hidden" name="year" value="<?= $get_year ?>">
                <input type="submit" value="<?= $getSubLabel?>">
            </form>
    <?php
        }
        // Release returned data
        mysqli_free_result($result);
    ?>
    </nav>
    <br>
    <?php
        if ($selection != ACADEMIC) {
    ?>
    <h2 class="highlight">Picture Gallery</h2>
    <nav>
        <?php
            // get picture nav buttons
            $result = get_activity_av_seasons($connection, $selection, 0, $student);
        
            // Use return date (if any)
        
            while ($picform = mysqli_fetch_assoc($result)) {
                $get_season = $picform["season"];
                $get_year = $picform["year"];
                $getSubLabel = $get_season . " " . $get_year;
                // out data from each row
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
            // Release returned data
            mysqli_free_result($result);
        ?>
    </nav>
    <br>
    <?php
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