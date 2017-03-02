<?php
/*
 * MHM: 2017-01-17
 * Comment:
 *  Do not allow direct access to include files.
 *  displayvolleyballvids.php:
 *      Display the volleyball videos on the page.
 *      Not a sports generic php file. If we add videos for other
 *      we will need to redo this file to be more generic to allow
 *      multiple sports.
 *
 * MHM: 2017-02-06
 * Comment:
 *  Store the video ID so that we can call the edit and delete functions.
 *  Add the edit and delete buttons below the video.
 *
 * MHM: 2017-02-10
 * Comment:
 *  Some format changes so the code does not sprawl so far to the right.
 *
 * MHM: 2017-02-12
 * Comment:
 *  Build POST calls for edit and delete videos. Also no longer load video meta-data.
 *  This greatly improves the load time of the page.
 *
 * MHM: 2017-02-13
 * Comment:
 *  Removed variables pictures, videos and stats and now just use pIndex to
 *  reference the different panels.
 *
 * MHM: 2017-02-23
 * Comment:
 *  Remove need for leading / in database entry.
 *  Fix return page for edit and delete buttons. Removed extraneous parameters on delete form.
 *
 * MHM: 2017-03-02
 * Comment:
 *  Add support for icons.
 */
if (count(get_included_files()) == 1) {
    exit("direct access not allowed.");
}
    
/*
 * MHM: 2017-01-17
 * Comment:
 *  Get the number of volleyball videos stored in the av database.
 *
 *  The string constant "Volleyball should be replaced with the constant
 *  VB, or we should consider using the global $sport to be more generic.
 */
$cnt = get_number_of_vids($connection, "Volleyball", $season, $year);
    
/*
 * MHM: 2017-01-17
 * Comment:
 *  Get the list of videos from the av database.
 *
 *  The string constant "Volleyball should be replaced with the constant
 *  VB, or we should consider using the global $sport to be more generic.
 */
$result = get_vids($connection, "Volleyball", $season, $year);
?>
<div id="vbpictab">
    <h1><?= $year ?> Volleyball Videos</h1>
    <br>
    <table class="centered-table" border="0" cellspacing="0" cellpadding="2" summary="Videos">
        <caption>
            <h3>Videos </h3>
        </caption>
        <br>
<?php
    /*
     * MHM: 2017-01-17
     * Comment:
     *  Layout the table with two videos per line.
     */
        if ($cnt != 0) {
?>
            <tr>
<?php 
            for ($i=0; $i<$cnt; $i++) {
                $vids = mysqli_fetch_assoc($result);
                $videoId = $vids["id"];
?>    
                <td class="delpics">
                    <div class="button-container">
                        <video class="thumbvideo" preload="none" controls poster="<?= $photopath . $vids['thumbName']; ?>">
                                        <source src="<?= $videopath . $vids['avName']; ?>" type="video/mp4"></video>
                        <p><b><?= $vids['avName'] ?></b></p>
                        <form method="post" action="edit_video.php">
                            <div>
                                <input type="hidden" name="videoId" value="<?= $videoId ?>">
                                <input type="hidden" name="studentName" value="<?= $student ?>">
                                <input type="hidden" name="season" value="<?= $season ?>">
                                <input type="hidden" name="year" value="<?= $year ?>">
                                <input type="hidden" name="pIndex" value="<?= $pIndex ?>">
                                <input type="hidden" name="selection" value="<?= $selection ?>">
                                <input type="hidden" name="retPage" value="<?= $_SERVER['PHP_SELF'] ?>?studentName=<?= $student ?>&season=<?= $season ?>&year=<?= $year ?>&pIndex=<?= $pIndex ?>">
                                <input type="submit" name="edit" value="&#xE3C9;">
                            </div>
                        </form>
                        <form method="post" action="delete_video.php">
                            <div>
                                <input type="hidden" name="videoId" value="<?= $videoId ?>">
                                <input type="hidden" name="retPage" value="<?= $_SERVER['PHP_SELF'] ?>?studentName=<?= $student ?>&season=<?= $season ?>&year=<?= $year ?>&pIndex=<?= $pIndex ?>">
                                <input type="submit" name="delete" value="&#xE872;" onclick="return confirm('Are you sure?')">
                            </div>
                        </form>
                    </div>
                </td>
<?php
                /*
                 * MHM: 2017-01-17
                 * Comment:
                 *  Need a closing /tr after placing the 2nd video on a row,
                 *  unless this is the last row.
                 */
                $needtr = ($i + 1) % 2;
                if (($needtr == 0) && ($i != ($cnt-1))) {
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
<?php
    /*
     * MHM: 2017-01-71
     * Comment:
     *  Free results from database query
     */
    mysqli_free_result($result);
?>
</div>