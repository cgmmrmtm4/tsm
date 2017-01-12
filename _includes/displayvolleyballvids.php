<?php
    if (count(get_included_files()) == 1) {
            exit("direct access not allowed.");
    }
    // Get number of pictures
    $cnt = get_number_of_vids($connection, "Volleyball", $season, $year);
    // Get pictures
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
        mysqli_free_result($result);
    ?>
    </table>
</div>