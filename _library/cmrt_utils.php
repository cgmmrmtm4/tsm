<?php
/* 
 * MHM: 2017-02-09
 * Comment:
 *  Create new library file that contains all the miscellaneous routines.
 *
 * MHM: 2017-02-16
 * Comment:
 *  Added simple utility functions to retrieve grade point values, seasons, years and grades.
 *  Use these routines to build HTML form logic.
 */

if (count(get_included_files()) == 1) {
    exit("direct access not allowed.");
}

/*
 * MHM: 2017-02-13
 * Comment:
 *  Return the HTML option tag for the academic season
 *  Input: season, boolean to determine if submit and if error
 *  Output: The correct option tags
 */
function get_weighted($weighted, $isSubmit) {
    $weightedArray = array(NOWEIGHT, HONORS, AP);
    $weightedArrayLength = count($weightedArray);
    $output = "";
    for ($count=0; $count < $weightedArrayLength; $count++) {
        $output .= "<input class=\"dbradio\" type=\"radio\" name=\"weighted\" value=\"$weightedArray[$count]\" ";
        if (($isSubmit == true) && ($weighted == $weightedArray[$count])) {
            $output .= "checked";
        } else {
            if ($weightedArray[$count] == NOWEIGHT) {
                $output .= "checked";
            }
        }
        $output .= "> $weightedArray[$count]";
        $output .= "\n";
    }
    return $output;
}

/*
 * MHM: 2017-02-13
 * Comment:
 *  Return the HTML option tag for the academic season
 *  Input: season, boolean to determine if submit and if error
 *  Output: The correct option tags
 */
function get_seasons($season, $isSubmit) {
    $academicSeasonArray = array(SUMMER, FALL, SPRING);
    $academicSeasonLength = count($academicSeasonArray);
    $output = "";
    for ($count=0; $count < $academicSeasonLength; $count++) {
        $output .= "<option ";
        if (($isSubmit == true) && ($season == $academicSeasonArray[$count])) {
            $output .= "selected=selected ";
        }
        $output .= "value=\"$academicSeasonArray[$count]\">$academicSeasonArray[$count]</option>";
        $output .= "\n";
    }
    return $output;
}

/*
 * MHM: 2017-02-13
 * Comment:
 *  Return the HTML option tag for the academic year
 *  Input: student name, year, boolean to determine if submit and if error
 *  Output: The correct option tags
 */
function get_years($student, $year, $isSubmit) {
    $academicYearArray = array("2014", "2015", "2016", "2017", "2018");
    $academicYearLength = count($academicYearArray);
    $output = "";
    for ($count=0; $count < $academicYearLength; $count++) {
        $output .= "<option ";
        if (($isSubmit == true) && ($year == $academicYearArray[$count])) {
            $output .= "selected=selected ";
        }
        $output .= "value=\"$academicYearArray[$count]\">$academicYearArray[$count]</option>";
        $output .= "\n";
    }
    return $output;
}

/*
 * MHM: 2017-02-13
 * Comment:
 *  Return the HTML option tag for the academic year
 *  Input: student name, year, boolean to determine if submit and if error
 *  Output: The correct option tags
 */
function get_periods($period, $isSubmit) {
    $academicPeriodsArray = array("0", "1", "2", "3", "4", "5", "6", "7");
    $academicPeriodsLength = count($academicPeriodsArray);
    $output = "";
    for ($count=0; $count < $academicPeriodsLength; $count++) {
        $output .= "<option ";
        if (($isSubmit == true) && ($period == $academicPeriodsArray[$count])) {
            $output .= "selected=selected ";
        }
        $output .= "value=\"$academicPeriodsArray[$count]\">$academicPeriodsArray[$count]</option>";
        $output .= "\n";
    }
    return $output;
}

function get_grade_letters($grade, $isSubmit) {
    $academicGradesArray = array("A+", "A", "A-", "B+", "B", "B-", "C+", "C", "C-", "D", "F");
    $academicGradesLength = count($academicGradesArray);
    $output = "";
    for ($count=0; $count < $academicGradesLength; $count++) {
        $output .= "<option ";
        if (($isSubmit == true) && ($grade == $academicGradesArray[$count])) {
            $output .= "selected=selected ";
        }
        $output .= "value=\"$academicGradesArray[$count]\">$academicGradesArray[$count]</option>";
        $output .= "\n";
    }
    return $output;
}

/*
 * MHM: 2017-02-05
 * Comment:
 *  Redirect to a different URL.
 *  Input: New php file.
 */
function redirect_to($new_location) {
    header("Location: " . $new_location);
    exit;
}

function form_errors($errors=array()) {
	$output = "";
	if (!empty($errors)) {
        $output .= "<div class=\"error\">";
        $output .= "Please fix the following errors:";
        $output .= "<ul>";
        foreach ($errors as $key => $error) {
            $output .= "<li>";
            $output .= htmlentities($error);
            $output .= "</li>";
        }
        $output .= "</ul>";
        $output .= "</div>";
    }
    return $output;
}

function message() {
    if (isset($_SESSION["message"])) {
        $output = "<div class=\"message\">";
        $output .= htmlentities($_SESSION["message"]);
        $output .= "</div>";
			
        // clear message after use
        $_SESSION["message"] = null;
			
        return $output;
    }
}

function errors() {
    if (isset($_SESSION["errors"])) {
        $errors = $_SESSION["errors"];
			
        // clear message after use
        $_SESSION["errors"] = null;
			
        return $errors;
    }
}
?>