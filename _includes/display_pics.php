<?php
    if (count(get_included_files()) == 1) {
            exit("direct access not allowed.");
    }
    // Get number of pictures
    $cnt = get_number_of_pictures($connection, $selection, $season, $year);
    // Get pictures
    $result = get_pictures($connection, $selection, $season, $year);
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
        mysqli_free_result($result);
    ?>
    </table>
</div>