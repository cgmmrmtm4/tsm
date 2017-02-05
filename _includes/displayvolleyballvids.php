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
    ?>    
                <td>
                    <video class="thumbvideo" preload="metadata" controls poster="<?= $photopath . $vids['thumbName']; ?>">
                                        <source src="<?= $videopath . $vids['avName']; ?>" type="video/mp4"></video>
                    <p><b><?= ltrim($vids['avName'], "/") ?></b></p>
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
        /*
         * MHM: 2017-01-71
         * Comment:
         *  Free results from database query
         */
        mysqli_free_result($result);
    ?>
    </table>
</div>