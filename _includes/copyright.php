<?php
/*
 * MHM: 2017-01-17
 * Comment:
 *  Compute the copyright years for all pages.
 *  Consider moving to functions.php to keep all functions
 *  in one file.
 */
function mhm_copyright($startYear) {
    $currentYear = date('Y');
    if ($startYear == $currentYear) {
        return "&copy; $currentYear";
    } else {
        $currentYear = date('y');
        return "&copy; $startYear&ndash;$currentYear";
    }
}