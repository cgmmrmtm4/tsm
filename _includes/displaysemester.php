<?php
/*
 * MHM: 2017-01-17
 * Comment:
 *  Do not allow direct access to include files.
 *  displaysemester.php:
 *      Display the semester grades on the page.
 *
 * MHM: 2017-02-06
 * Comment:
 *  Added class modify so that the edit delete buttons do not appear within a table border.
 *  Store Class Id so that we can call the edit and delete functions.
 *  Added edit and delete buttons to all rows.
 *
 * MHM: 2017-02-10
 * Comment:
 *  Some format changes so the code does not sprawl so far to the right.
 *
 * MHM: 2017-02-12
 * Comment:
 *  Build POST calls for edit and delete class.
 *
 * MHM: 2017-02-13
 * Comment:
 *  If rank doesn't exist, don't print the line.
 *
 * MHM: 2017-02-16
 * Comment:
 *  Modify cancel URL to include parameters.
 */
if (count(get_included_files()) == 1) {
    exit("direct access not allowed.");
}

/*
 * MHM: 2017-01-17
 * Comment:
 *  Get the students semester grades.
 */
$result = get_semester_academics($connection, $season, $year, $student);
?>
<div id="semestertab">
    <table class="semesterTable" cellspacing="3" cellpadding="3" summary="List of classes, teachers and grades">
        <caption>
            <h3><?= $season . " " . $year ?></h3>
        </caption>
        <tr>
            <th scope="col" class="period">Period </th>
            <th scope="col" class="className">Class </th>
            <th scope="col" class="teacher">Teacher </th>
            <th scope="col" class="grade">Grade </th>
            <th scope="col" class="modify"></th>
        </tr>
<?php
        // Use return data (if any)
        while ($course = mysqli_fetch_assoc($result)) {
            $classId = $course["id"];
            $period = $course["period"];
            $class = $course["className"];
            $teacher = $course["teacherName"];
            $grade = $course["grade"];
        // output data from each row
?>
            <tr>
                <td class="period"><?= $period ?></td>
                <td class="className"><?= $class ?></td>
                <td class="teacher"><i><?= $teacher ?></i></td>
                <td class="grade"><b><?= $grade ?></b></td>
                <td class="modify">
                    <div class="button-container">
                        <form method="post" action="edit_class.php">
                            <div>
                                <input type="hidden" name="classId" value="<?= $classId ?>">
                                <input type="hidden" name="studentName" value="<?= $student ?>">
                                <input type="hidden" name="season" value="<?= $season ?>">
                                <input type="hidden" name="year" value="<?= $year ?>">
                                <input type="hidden" name="selection" value="<?= $selection ?>">
                                <input type="hidden" name="retPage" value="<?= $_SERVER['PHP_SELF'] ?>?studentName=<?= $student ?>&season=<?= $season ?>&year=<?= $year ?>">
                                <input type="submit" name="edit" value="EDIT">
                            </div>
                        </form>
                            
                        <form method="post" action="delete_class.php">
                            <div>
                                <input type="hidden" name="classId" value="<?= $classId ?>">
                                <input type="hidden" name="studentName" value="<?= $student ?>">
                                <input type="hidden" name="season" value="<?= $season ?>">
                                <input type="hidden" name="year" value="<?= $year ?>">
                                <input type="hidden" name="selection" value="<?= $selection ?>">
                                <input type="hidden" name="retPage" value="<?= $_SERVER['PHP_SELF'] ?>">
                                <input type="submit" name="delete" value="DELETE">
                            </div>
                        </form>
                    </div>
                </td>
            </tr>
<?php
        }
?>
    </table>
<?php
    /*
     * MHM: 2017-01-17
     *
     * Comment:
     *  Free results from database query
     */
    mysqli_free_result($result);
?>
    
    <br>
<?php
    /*
     * MHM: 2017-01-17
     * Comment:
     *  Get the semesters unweighted and weighted GPA. May want to consider using
     *  javascript to compute this information instead of another
     *  database query.
     */
    $gpa=0.000;
    $wgpa = 0.000;
    $result = get_semester_gpa($connection, $season, $year, $student);
    while ($ogpa = mysqli_fetch_assoc($result)) {
        $gpa = $ogpa["GPA"];
        $wgpa = $ogpa["WGPA"];
    }
    
    /*
     * MHM: 2017-01-17
     * Comment:
     *  Free results from database query
     */
    mysqli_free_result($result);
?>
    <pre><?= "\t   " ?>Semester GPA: <?= $gpa ?> <?= "\t" ?> Semester Weighted GPA: <?= $wgpa ?></pre>
<?php
    /*
     * MHM: 2017-01-17
     * Comment:
     *  Get the students weighted and unweighted GPA from their first
     *  semester until the selected semester.
     */
    //get running normal and weighted GPA, free results;
    $gpa = 0.000;
    $wgpa = 0.000;
    $result = get_running_gpa($connection, $season, $year, $student);
    while ($ogpa = mysqli_fetch_assoc($result)) {
        $gpa = $ogpa["GPA"];
        $wgpa = $ogpa["WGPA"];
    }

    /*
     * MHM: 2017-01-17
     * Comment:
     *  Free results from database query
     */
    mysqli_free_result($result);
?>
    <pre><?= "\t   " ?>Overall GPA: <?= $gpa ?> <?= "\t" ?> Overall Weighted GPA: <?= $wgpa ?></pre>
    <br>
<?php
    /*
     * MHM: 2017-01-17
     * Comment:
     *  Get the students class ranking.
     */
    $rank = null;
    $result = get_top_of_class($connection, $season, $year);
    while ($theoRank = mysqli_fetch_assoc($result)) {
        $rank = $theoRank["rank"];
        $totStudents = $theoRank["totalStudents"];
        $pct = $theoRank["pct"];
        }

    /*
     * MHM: 2017-01-17
     * Comment:
     *  Free results from database query
     */
    mysqli_free_result($result);
    if ($rank != null) {
?>
        <pre><?= "\t   "?>Rank: <?= $rank ?> <?= "   " ?> Class Size: <?= $totStudents ?> <?= "   "?> Top <?= $pct ?>%</pre>
<?php
    }
?>
</div>