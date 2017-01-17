<?php
    /*
     * MHM: 2017-01-17
     *
     * Comment:
     *  Do not allow direct access to include files.
     *  display_pics.php:
     *      Display the pictures associated with the activity on the page.
     */
    if (count(get_included_files()) == 1) {
            exit("direct access not allowed.");
    }

    /*
     * MHM: 2017-01-17
     *
     * Comment:
     *  Get the number of pictures associated with the pages activity.
     */
    $cnt = get_number_of_pictures($connection, $selection, $season, $year);

    /*
     * MHM: 2017-01-17
     *
     * Comment:
     *  Get the list of pictures from the av database.
     *
     */
    $result = get_pictures($connection, $selection, $season, $year);

    /*
     * MHM: 2017-01-17
     *
     * Comment:
     *  Consider using a constant instead of a string.
     */
    $headerLabel = $year . " " . $selection . " " . "Pictures";
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
         *
         * Comment:
         *  Layout out 4 pictures per row.
         */
        if ($cnt != 0) {
    ?>
            <tr>
    <?php 
            for ($i=0; $i<$cnt; $i++) {
                $pics = mysqli_fetch_assoc($result);
    ?>
                <td>
                    <a href="<?= $photopath . $pics['avName']; ?>" download> <img src="<?= $photopath . $pics['thumbName']; ?>" class="thumbnail"></a>    
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
        /*
         * MHM: 2017-01-17
         *
         * Comment:
         *  Free results from database query
         */
        mysqli_free_result($result);
    ?>
    </table>
</div>