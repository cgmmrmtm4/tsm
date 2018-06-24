<?php
/*
 * MHM: 2018-06-24
 * Comment:
 *  Do not allow direct access to include files.
 *  awards_menu.php:
 *      Set up side navigation awards menu.
 *      pull common code to show awards into a single file that
 *      is included by all academic and sport pages.
 *
 */
if (count(get_included_files()) == 1) {
    exit("direct access not allowed.");
}
?>
<article id="awards">
    <div>
        <table class="awardsTable" cellspacing="0" cellpadding="0" summary="Add an award">
            <tr>
                <th scope="col" class="addNewItem"></th>
                <th scope="col" class="modify"></th>
            </tr>
            <tr>
                <td class="addNewItem">Awards</td>
                <td class="modify">
                    <div class="button-container">
                        <form method="post" action="add_award.php">
                            <input type="hidden" name="studentName" value="<?= $student ?>">
                            <input type="hidden" name="season" value="<?= $season ?>">
                            <input type="hidden" name="year" value="<?= $year ?>">
                            <input type="hidden" name="pIndex" value="<?= $pIndex ?>">
                            <input type="hidden" name="selection" value="<?= $selection ?>">
                            <input type="hidden" name="retPage" value="<?= $_SERVER['PHP_SELF'] ?>?studentName=<?= $student ?>&season=<?= $season ?>&year=<?= $year ?>">
                            <input class="useicon" type="submit" name="add" value="&#xE145;">
                        </form>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <ul>
<?php
        /*
         * MHM: 2017-01-16
         * Comment:
         *  If any exist, get the students awards for this sport
         */
        $result = get_awards_by_catagory($connection, $selection, $student);
        while ($award = mysqli_fetch_assoc($result)) {
            $awardYear = $award["year"];
            $awardTitle = $award["title"];
            $awardString = $awardYear . " " . $awardTitle;
?>
            <li><?= $awardString ?></li>
<?php
        }
?>
    </ul>
</article>