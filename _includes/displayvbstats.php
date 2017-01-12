<?php
    if (count(get_included_files()) == 1) {
            exit("direct access not allowed.");
    }
    // Get table header label
    $headerLabel=get_varsity_or_jv_label($connection, "Volleyball", $year);

    // Get vollyball stats
    $result = get_volleyball_stats($connection, $season, $year);
?>
<div id="vbstatstab">
    <h1><?= $year ?> <?= $headerLabel ?> Volleyball</h1>
    <br>
    <table id="stattab" class="centered-table" border="1" cellspacing="0" cellpadding="0" summary="Stats">
        <caption>
            <h3>Statistics</h3>
        </caption>
        <tr>
            <th scope="col">Opponent </th>
            <th scope="col" class="assists">Assists </th>
            <th scope="col" class="blocks">Blocks </th>
            <th scope="col" class="kills">Kills </th>
            <th scope="col" class="digs">Digs</th>
            <th scope="col" class="serves">Serves</th>
            <th scope="col" class="aces">Aces</th>
            <th scope="col" class="sideOut">Side Out</th>
        </tr>
        <?php
            // Use return data (if any)
            while ($stat = mysqli_fetch_assoc($result)) {
                $opponent = $stat["opponent"];
                $assists = $stat["assists"];
                $blocks = $stat["blocks"];
                $kills = $stat["kills"];
                $digs = $stat["digs"];
                $serves = $stat["serves"];
                $aces = $stat["aces"];
                $sideouts = $stat["sideouts"];
            // output data from each row
        ?>
                <tr>
                    <td class="opponent"><?= $opponent ?></td>
                    <td class="assists"><?= $assists ?></td>
                    <td class="blocks"><?= $blocks ?></td>
                    <td class="kills"><?= $kills ?></td>
                    <td class="digs"><?= $digs ?></td>
                    <td class="serves"><?= $serves ?></td>
                    <td class="aces"><?= $aces ?></td>
                    <td class="sideOut"><?= $sideouts ?></td>
                </tr>
        <?php
            }
            mysqli_free_result($result);
            $result = get_volleyball_season_totals($connection, $season, $year);
            while ($seasonStats = mysqli_fetch_assoc($result)) {
        ?>
                <!-- Give me a couple of empty rows -->
                <tr>
                    <td></td>
                </tr>
                    <td></td>
                <tr>
                </tr>
                <tr>
                    <td><?= "Totals" ?></td>
                    <td class="assists"><?= $seasonStats["totassists"] ?></td>
                    <td class="blocks"><?= $seasonStats["totblocks"] ?></td>
                    <td class="kills"><?= $seasonStats["totkills"] ?></td>
                    <td class="digs"><?= $seasonStats["totdigs"] ?></td>
                    <td class="serves"><?= $seasonStats["totserves"] ?></td>
                    <td class="aces"><?= $seasonStats["totaces"] ?></td>
                    <td class="sideOut"><?= $seasonStats["totsideouts"] ?></td>
                </tr>
                <tr>
                    <td><?= "Averages" ?></td>
                    <td class="assists"><?= $seasonStats["avgassists"] ?></td>
                    <td class="blocks"><?= $seasonStats["avgblocks"] ?></td>
                    <td class="kills"><?= $seasonStats["avgkills"] ?></td>
                    <td class="digs"><?= $seasonStats["avgdigs"] ?></td>
                    <td class="serves"><?= $seasonStats["avgserves"] ?></td>
                    <td class="aces"><?= $seasonStats["avgaces"] ?></td>
                    <td class="sideOut"><?= $seasonStats["avgsideouts"] ?></td>   
                </tr>
        <?php
            }
            mysqli_free_result($result);
        ?>
        
    </table>
</div>