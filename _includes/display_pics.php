<?php
/*
 * MHM: 2017-01-17
 * Comment:
 *  Do not allow direct access to include files.
 *  display_pics.php:
 *      Display the pictures associated with the activity on the page.
 *
 * MHM: 2017-01-19
 * Comment:
 *  Add support for the TRAVEL page. Requires additonal logic to display
 *  the header above the pictures.
 *
 * MHM: 2017-02-06
 * Comment:
 *  Store the picture ID so that we can call the edit and delete functions.
 *  Add the edit and delete buttons below the picture.
 *
 * MHM: 2017-02-10
 * Comment:
 *  Some format changes so the code does not sprawl so far to the right.
 *
 * MHM: 2017-02-12
 * Comment:
 *  Build POST calls for edit and delete pictures.
 *
 * MHM: 2017-02-13
 * Comment:
 *  Removed variables pictures, videos and stats and now just use pIndex to
 *  reference the different panels.
 *
 * MHM: 2017-02-23
 * Comment:
 *  Remove need for leading / in database entry.
 *  Fix return page for edit button, remove extraneous parameters in delete form.
 *
 * MHM: 2017-03-02
 * Comment:
 *  Add support for icons.
 * 
 * MHM: 2018-06-25
 * Comment:
 *  Add tool tips and code cleanup.
 */
if (count(get_included_files()) == 1) {
    exit("direct access not allowed.");
}

/*
 * MHM: 2017-01-17
 * Comment:
 *  Get the number of pictures associated with the pages activity.
 */
$cnt = get_number_of_pictures($connection, $selection, $season, $year);

/*
 * MHM: 2017-01-19
 * Comment:
 *  Get the travel location for the given year. Also set the value
 *  to be displayed in the heading.
 *  Append location to $photopath if Travel.
 */
if ($selection == TRAVEL) {
    $dynamic_heading = get_travel_location($connection, $season, $year);
    $photopath .= $dynamic_heading . "/";
} else {
    $dynamic_heading = $selection;
}

/*
 * MHM: 2017-01-17
 * Comment:
 *  Get the list of pictures from the av database.
 *
 */
$result = get_pictures($connection, $selection, $season, $year);

/*
 * MHM: 2017-01-17
 * Comment:
 *  Consider using a constant instead of a string.
 */
$headerLabel = $year . " " . $dynamic_heading . " " . "Pictures";
?>
<div id="vbpictab">
    <h1><?= $headerLabel ?></h1>
    <br>
    <table class="centered-table" border="0" cellspacing="0" cellpadding="2" summary="Pictures">
        <caption>
            <h3>Thumbnails </h3>
        </caption>
        <br>
<?php
        /*
         * MHM: 2017-01-17
         * Comment:
         *  Layout out 4 pictures per row.
         */
        if ($cnt != 0) {
?>
            <tr>
<?php 
                for ($i=0; $i<$cnt; $i++) {
                    $pics = mysqli_fetch_assoc($result);
                    $photoId = $pics["id"];
?>
                    <td class="delpics">
                        <div class="tooltip">
                            <span class="tooltiptext">Download Picture</span>
                            <a href="<?= $photopath . $pics['avName']; ?>" download> <img src="<?= $photopath . $pics['thumbName']; ?>" class="thumbnail"></a> 
                        </div>
                        <div class="button-container tooltip">
                            <span class="tooltiptext">Edit Picture Location</span>
                            <form method="post" action="edit_picture.php">
                                <input type="hidden" name="photoId" value="<?= $photoId ?>">
                                <input type="hidden" name="studentName" value="<?= $student ?>">
                                <input type="hidden" name="season" value="<?= $season ?>">
                                <input type="hidden" name="year" value="<?= $year ?>">
                                <input type="hidden" name="pIndex" value="<?= $pIndex ?>">
                                <input type="hidden" name="selection" value="<?= $selection ?>">
                                <input type="hidden" name="retPage" value="<?= $_SERVER['PHP_SELF'] ?>?studentName=<?= $student ?>&season=<?= $season ?>&year=<?= $year ?>&pIndex=<?= $pIndex ?>">
                                <input type="submit" name="edit" value="&#xE3C9;">
                            </form>
                        </div>
                        <div class="button-container tooltip">
                            <span class="tooltiptext">Delete Picture</span>
                            <form method="post" action="delete_picture.php">
                                <input type="hidden" name="photoId" value="<?= $photoId ?>">
                                <input type="hidden" name="retPage" value="<?= $_SERVER['PHP_SELF'] ?>?studentName=<?= $student ?>&season=<?= $season ?>&year=<?= $year ?>&pIndex=<?= $pIndex ?>">
                                <input type="submit" name="delete" value="&#xE872;" onclick="return confirm('Are you sure?')">
                            </form>
                        </div>
                    </td>
<?php
                    $needtr = ($i + 1) % 4;
                    if ($needtr == 0) {
?>
                        </tr>
                        <tr>
<?php            
                    }
                }
?>
            </tr>
<?php
        }
?>
    </table>
</div>
<?php
    /*
     * MHM: 2017-01-17
     * Comment:
     *  Free results from database query
     */
    mysqli_free_result($result);
?>