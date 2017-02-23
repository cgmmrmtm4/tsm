<?php
/*
 * MHM: 2017-01-16
 * Comment:
 *  Do not allow direct access to include files.
 *  sched_res.php:
 *      Regardless of sport:
 *      Display overall and league records.
 *      Display game and result information.
 *
 * MHM: 2017-02-06
 * Comment:
 *  Added class modify so that the edit delete buttons can be added.
 *  Store Sched Id so that we can call the edit and delete functions.
 *
 * MHM: 2017-02-10
 * Comment:
 *  Included check for include and changes for include layout. Some
 *  format changes so the code does not sprawl so far to the right.
 *
 * MHM: 2017-02-12
 * Comment:
 *  Build POST calls for edit and delete game. Updated the POST parameters to
 *  sync up with the changes to the add operations.
 *
 * MHM: 2017-02-21
 * Comment:
 *  Support for edit a game record.
 *
 * MHM: 2017-02-23
 * Comment:
 *  Support for delete a game record.
 */
if (count(get_included_files()) == 1) {
    exit("direct access not allowed.");
}
/*
 * MHM: 2017-01-16
 * Comment:
 *  Determine if this is a JV or Varsity season.
 */
$headerLabel=get_varsity_or_jv_label($connection, $selection, $year);
$headerLabel = $headerLabel . " " . $selection;

/*
 * MHM: 2017-01-16
 * Comment:
 *  Get overall record
 */
$record = get_team_overall_record($connection, $selection, $season, $year);
$yearOverallLosses=$record['Losses'];
$yearOverallWins=$record['Wins'];
$yearOverallTies=$record['Ties'];

/*
 * MHM: 2017-01-16
 * Comment:
 *  Get league record
 */
$record=get_team_league_record($connection, $selection, $season, $year);
$yearLeagueLosses=$record['Losses'];
$yearLeagueWins=$record['Wins'];
$yearLeagueTies=$record['Ties'];
?>
<div id="volleyballtab">
    <h1><?= $year ?> <?= $headerLabel ?></h1>
    <br>
    <table id="record" class="centered-table" border="0" cellspacing="5" cellpadding="5" summary="Record">
        <caption>
            <h3>Record</h3>
        </caption>
        <tr>
            <th scope="col"></th>
            <th scope="col">Wins</th>
            <th scope="col">Loses</th>
            <th scope="col">Ties</th>
        </tr>
        <tr>
            <td>Overall</td>
            <td><?= $yearOverallWins ?></td>
            <td><?= $yearOverallLosses ?></td>
            <td><?= $yearOverallTies ?></td>
        </tr>
        <tr>
            <td>League</td>
            <td><?= $yearLeagueWins ?></td>
            <td><?= $yearLeagueLosses ?></td>
            <td><?= $yearLeagueTies ?></td>
        </tr>
    </table>
    <br>
    <br>
<?php
    /*
     * MHM: 2017-01-16
     * Comment:
     *  Get results for the selected season.
     */
    $result=get_schedule_and_results($connection, $selection, $season, $year);
?>
    <table id="schdres" class="centered-table" border="0" cellspacing="5" cellpadding="5" summary="Scores and Results">
        <caption>
            <h3>Schedule and Results </h3>
        </caption>
        <tr>
            <th scope="col" class="gameDate">Date </th>
            <th scope="col" class="location">Location </th>
            <th scope="col" class="league"></th>
            <th scope="col" class="opponent">Opponent </th>
            <th scope="col" class="matchScore">Score </th>
            <th scope="col" class="result">Result</th>
            <th scope="col" class="modify"></th>
        </tr>
<?php
        /*
         * MHM: 2017-01-16
         * Comment:
         *  Populate table with each game.
         */
        while ($game = mysqli_fetch_assoc($result)) {
            $schedId = $game["id"];
            $date = $game["date"];
            $location = $game["location"];
            $league = $game["league"];
            $opponent = $game["opponent"];
            $score = $game["score"];
            $gameResult = $game["result"];
            // output data from each row
?>
            <tr>
                <td class="gameData"><?= date("m-d", strtotime($date)) ?></td>
                <td class="location"><?= $location ?></td>
                <td class="league"><?= $league ?></td>
                <td class="opponent"><?= $opponent ?></td>
                <td class="matchScore"><?= $score ?></td>
                <td class=result><?= $gameResult ?></td>
                <td class="modify">
                    <div class="button-container">
                        <form method="post" action="edit_game.php">
                            <div>
                                <input type="hidden" name="schedId" value="<?= $schedId ?>">
                                <input type="hidden" name="studentName" value="<?= $student ?>">
                                <input type="hidden" name="season" value="<?= $season ?>">
                                <input type="hidden" name="year" value="<?= $year ?>">
                                <input type="hidden" name="selection" value="<?= $selection ?>">
                                <input type="hidden" name="pIndex" value="<?= $pIndex ?>">
                                <input type="hidden" name="retPage" value="<?= $_SERVER['PHP_SELF'] ?>?studentName=<?= $student ?>&season=<?= $season ?>&year=<?= $year ?>&pIndex=<?= $pIndex ?>">
                                <input type="submit" name="edit" value="EDIT">
                            </div>
                        </form>
                            
                        <form method="post" action="delete_game.php">
                            <div>
                                <input type="hidden" name="schedId" value="<?= $schedId ?>">
                                <input type="hidden" name="retPage" value="<?= $_SERVER['PHP_SELF'] ?>?studentName=<?= $student ?>&season=<?= $season ?>&year=<?= $year ?>&pIndex=<?= $pIndex ?>">
                                <input type="submit" name="delete" value="DELETE" onclick="return confirm('Are you sure?')">
                            </div>
                        </form>
                    </div>
                </td>
            </tr>
<?php
        }
?>
    </table>
    <h4>* League game</h4>
<?php
    /*
     * MHM: 2017-01-16
     * Comment:
     *  Free results from database query
     */
    mysqli_free_result($result);
?>
</div>