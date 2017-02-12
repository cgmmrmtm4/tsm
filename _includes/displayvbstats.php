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
    <div id="stattab">
        <table class="centered-table" border="1" cellspacing="0" cellpadding="0" summary="Stats">
            <tbody>
                <caption>
                <h3> Statistics </h3>
                </caption>
            </tbody>
            <thead>
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
            </thead>
            <tbody class="scrollable">
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
                            <div class="button-container">
                                <form method="post" action="edit_stats.php">
                                    <div>
                                        <input type="hidden" name="statId" value="<?= $statId ?>">
                                        <input type="submit" name="edit" value="EDIT">
                                    </div>
                                </form>
                            
                                <form method="post" action="delete_stats.php">
                                    <div>
                                        <input type="hidden" name="statId" value="<?= $statId ?>">
                                        <input type="submit" name="delete" value="DELETE">
                                    </div>
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
        
?>
            </tbody>
            <tfoot class="scrollable">
<?php
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
            </tfoot>
        </table>
    </div>
</div>