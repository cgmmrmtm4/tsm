<?php
/*
 * MHM: 2017-02-12
 * Comment:
 *  Future support for edit stats.
 *
 */
require("../_includes/req_includes.php");
$siteroot = HOMEROOT;
$imagepath = IMGROOT;
$pagelogo = "$imagepath" . PHOTOMISC . "/spft.jpg";
$pictures = NOPICS;
$videos = NOVIDS;

if (isset($_POST['edit'])) {
    $student = $_POST['studentName'];
    $season = $_POST['season'];
    $year = $_POST['year'];
    $stats = $_POST['stats'];
    $selection = $_POST['selection'];
    $returnPage = $_POST['retPage'];
    
    $_SESSION["message"] = "Action not implemented yet!";
    redirect_to("$returnPage?studentName=$student&season=$season&stats=$stats&year=$year");
} else {
    /*
     * This is neither a request for a new object, or the completion
     * of the previous form. So let's go back to HOME.
     */
    redirect_to("intro.php");
}
?>