<?php
/*
 * MHM: 2017-01-17
 * Comment:
 *  Do not allow direct access to include files.
 *  displayvbstats.php:
 *      Display the volleyball statistics on the page.
 *      Not a sports generic php file. If we add statistics from other
 *      sports we will need to redo this file to be more generic.
 *
 * MHM: 2017-01-21
 * Comment:
 *  Remove Varsity and JV string from the header and add "Stats" to header.
 *  Remove caption in anticipation of scroll bar. Also it's redundant.
 *  Add new div tag so that we can add the scroll bar. Will need to rethink since
 *  this scrolls the whole table and we only want to scroll the body.
 *  Add tbody, thead and tfoot tags to the table.
 *
 * MHM: 2017-01-22
 * Comment:
 *  More scroll bar adjustments. Added css entries for thead, tfoot, tfoot.scrollable and 
 *  tbody.scrollable. Updated tbody to be of class scrollable. Also added class opponent
 *  to the thead and tfoot fields that didn't already assign that class to the appropriate
 *  field. Makes the columns almost line up correctly. Still an issue with the scroll bar
 *  making the table go out of alignment. Did some fudging with the width css attribute
 *  for tbody, thead and tfoot to help address that issue.
 *
 * MHM: 2017-02-06
 * Comment:
 *  Added class modify to support the edit delete buttons.
 *  Store Stat Id so that we can call the edit and delete functions.
 *  Added edit and delete buttons to all non-total rows.
 *
 * MHM: 2017-02-10
 * Comment:
 *  Some format changes so the code does not sprawl so far to the right.
 *
 * MHM: 2017-02-12
 * Comment:
 *  Build POST calls for edit and delete statistics.
 *
 * MHM: 2017-02-13
 * Comment:
 *  Removed variables pictures, videos and stats and now just use pIndex to
 *  reference the different panels.
 *
 * MHM: 2017-02-23
 * Comment:
 *  Support for delete a stats record and cleanup
 *  return page setting.
 * 
 * MHM: 2018-06-25
 * Comment:
 *  Tooltips and code cleanup.
 */
if (count(get_included_files()) == 1) {
    exit("direct access not allowed.");
}

/*
 * MHM: 2017-01-17
 * Comment:
 *  Get the volleyball statistics for the given year.
 *  Future consideration, a more generic function call or
 *  possible some additonal php logic so that only the correct
 *  sports statistical function call is invoked.
 */
$result = get_volleyball_stats($connection, $season, $year);
?>
<div id="vbstatstab">
    <h1><?= $year ?> Volleyball Stats</h1>
    <br>
    <table class="centered-table" border="1" cellspacing="0" cellpadding="0" summary="Stats">
        <caption>
            <h3> Statistics </h3>
        </caption>
        <tr>
            <th scope="col" class="opponent">Opponent </th>
            <th scope="col" class="assists">Assists </th>
            <th scope="col" class="blocks">Blocks </th>
            <th scope="col" class="kills">Kills </th>
            <th scope="col" class="digs">Digs</th>
            <th scope="col" class="serves">Serves</th>
            <th scope="col" class="aces">Aces</th>
            <th scope="col" class="sideOut">Side Out</th>
            <th score="col" class="modify"></th>
        </tr>
<?php
        while ($stat = mysqli_fetch_assoc($result)) {
            $statId = $stat["id"];
            $opponent = $stat["opponent"];
            $assists = $stat["assists"];
            $blocks = $stat["blocks"];
            $kills = $stat["kills"];
            $digs = $stat["digs"];
            $serves = $stat["serves"];
            $aces = $stat["aces"];
            $sideouts = $stat["sideouts"];
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
                <td class="modify">
                    <div class="button-container tooltip">
                        <span class="tooltiptext">Edit Row</span>
                        <form method="post" action="edit_stats.php">
                            <input type="hidden" name="statId" value="<?= $statId ?>">
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
                        <span class="tooltiptext">Delete Row</span>
                        <form method="post" action="delete_stat.php">
                            <input type="hidden" name="statId" value="<?= $statId ?>">
                            <input type="hidden" name="retPage" value="<?= $_SERVER['PHP_SELF'] ?>?studentName=<?= $student ?>&season=<?= $season ?>&year=<?= $year ?>&pIndex=<?= $pIndex ?>">
                            <input type="submit" name="delete" value="&#xE872;" onclick="return confirm('Are you sure?')">
                        </form>
                    </div>
                </td>
            </tr>
<?php
        }        
        /*
         * MHM: 2017-01-17
         * Comment:
         *  Free results from database query
         */
        mysqli_free_result($result);

        /*
         * MHM: 2017-01-17
         * Comment:
         *  Get totals and averages. May want to consider using
         *  javascript to compute this information instead of another
         *  database query.
         */
        $result = get_volleyball_season_totals($connection, $season, $year);
        while ($seasonStats = mysqli_fetch_assoc($result)) {
?>
            <!-- Give me a couple of empty rows -->
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td class="opponent"><?= "Totals" ?></td>
                <td class="assists"><?= $seasonStats["totassists"] ?></td>
                <td class="blocks"><?= $seasonStats["totblocks"] ?></td>
                <td class="kills"><?= $seasonStats["totkills"] ?></td>
                <td class="digs"><?= $seasonStats["totdigs"] ?></td>
                <td class="serves"><?= $seasonStats["totserves"] ?></td>
                <td class="aces"><?= $seasonStats["totaces"] ?></td>
                <td class="sideOut"><?= $seasonStats["totsideouts"] ?></td>
                <td class="modify"></td>
            </tr>
            <tr>
                <td class="opponent"><?= "Averages" ?></td>
                <td class="assists"><?= $seasonStats["avgassists"] ?></td>
                <td class="blocks"><?= $seasonStats["avgblocks"] ?></td>
                <td class="kills"><?= $seasonStats["avgkills"] ?></td>
                <td class="digs"><?= $seasonStats["avgdigs"] ?></td>
                <td class="serves"><?= $seasonStats["avgserves"] ?></td>
                <td class="aces"><?= $seasonStats["avgaces"] ?></td>
                <td class="sideOut"><?= $seasonStats["avgsideouts"] ?></td>
                <td class="modify"></td>
            </tr>
<?php
        }
        /*
         * MHM: 2017-01-17
         * Comment:
         *  Free results from database query.
         */
         mysqli_free_result($result);
?>
    </table>
</div>