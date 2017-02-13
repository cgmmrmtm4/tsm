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
    $photopath .= "/" . $dynamic_heading;
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
                    <div class="button-container">
                        <a href="<?= $photopath . $pics['avName']; ?>" download> <img src="<?= $photopath . $pics['thumbName']; ?>" class="thumbnail"></a> 
                        <form method="post" action="edit_picture.php">
                            <div>
                                <input type="hidden" name="photoId" value="<?= $photoId ?>">
                                <input type="hidden" name="studentName" value="<?= $student ?>">
                                <input type="hidden" name="season" value="<?= $season ?>">
                                <input type="hidden" name="year" value="<?= $year ?>">
                                <input type="hidden" name="pictures" value="<?= $pictures ?>">
                                <input type="hidden" name="selection" value="<?= $selection ?>">
                                <input type="hidden" name="retPage" value="<?= $_SERVER['PHP_SELF'] ?>">
                                <input type="submit" name="edit" value="EDIT">
                            </div>
                        </form>
                        <form method="post" action="delete_picture.php">
                            <div>
                                <input type="hidden" name="photoId" value="<?= $photoId ?>">
                                <input type="hidden" name="studentName" value="<?= $student ?>">
                                <input type="hidden" name="season" value="<?= $season ?>">
                                <input type="hidden" name="year" value="<?= $year ?>">
                                <input type="hidden" name="pictures" value="<?= $pictures ?>">
                                <input type="hidden" name="selection" value="<?= $selection ?>">
                                <input type="hidden" name="retPage" value="<?= $_SERVER['PHP_SELF'] ?>">
                                <input type="submit" name="delete" value="DELETE">
                            </div>
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