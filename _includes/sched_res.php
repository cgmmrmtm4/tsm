<?php
    if (count(get_included_files()) == 1) {
            exit("direct access not allowed.");
    }
    // Get table header label
    $headerLabel=get_varsity_or_jv_label($connection, $selection, $year);
    $headerLabel = $headerLabel . " " . $selection;

    // Get overall team record
    $record = get_team_overall_record($connection, $selection, $season, $year);
    $yearOverallLosses=$record['Losses'];
    $yearOverallWins=$record['Wins'];
    $yearOverallTies=$record['Ties'];

    // get league team record
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
        // get schedule results, must free results
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
        </tr>
        <?php
            // Use return data (if any)
            while ($game = mysqli_fetch_assoc($result)) {
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
                </tr>
        <?php
            }
            mysqli_free_result($result);
        ?>
    </table>
        <h4>* League game</h4>
</div>