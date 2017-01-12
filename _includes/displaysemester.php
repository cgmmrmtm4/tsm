<?php
    if (count(get_included_files()) == 1) {
            exit("direct access not allowed.");
    }
    // get semester academics, free results
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
        </tr>
        <?php
            // Use return data (if any)
            while ($course = mysqli_fetch_assoc($result)) {
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
                </tr>
        <?php
            }
            mysqli_free_result($result);
        ?>
    </table>
    <br>
    <?php
        //get semester normal and weighted GPA, free results
        $gpa=0.000;
        $wgpa = 0.000;
        $result = get_semester_gpa($connection, $season, $year, $student);
        while ($ogpa = mysqli_fetch_assoc($result)) {
            $gpa = $ogpa["GPA"];
            $wgpa = $ogpa["WGPA"];
        }
        mysqli_free_result($result);
    ?>
    <pre><?= "\t   " ?>Semester GPA: <?= $gpa ?> <?= "\t" ?> Semester Weighted GPA: <?= $wgpa ?></pre>
    <?php
        //get running normal and weighted GPA, free results;
        $gpa = 0.000;
        $wgpa = 0.000;
        $result = get_running_gpa($connection, $season, $year, $student);
        while ($ogpa = mysqli_fetch_assoc($result)) {
            $gpa = $ogpa["GPA"];
            $wgpa = $ogpa["WGPA"];
        }
        mysqli_free_result($result);
    ?>
    <pre><?= "\t   " ?>Overall GPA: <?= $gpa ?> <?= "\t" ?> Overall Weighted GPA: <?= $wgpa ?></pre>
    <br>
    <?php
        // get student ranking, free results
        $result = get_top_of_class($connection, $season, $year);
        while ($theoRank = mysqli_fetch_assoc($result)) {
            $rank = $theoRank["rank"];
            $totStudents = $theoRank["totalStudents"];
            $pct = $theoRank["pct"];
    ?>
    <pre><?= "\t   "?>Rank: <?= $rank ?> <?= "   " ?> Class Size: <?= $totStudents ?> <?= "   "?> Top <?= $pct ?>%</pre>
    <?php
        }
        mysqli_free_result($result);
    ?>
</div>