<?php
/*
 * MHM: 2017-02-12
 * Comment:
 *  Future support for edit videos.
 *
 * MHM: 2017-02-13
 * Comment:
 *  Removed variables pictures, videos and stats and now just use pIndex to
 *  reference the different panels.
 */
require("../_includes/req_includes.php");
$siteroot = HOMEROOT;
$imagepath = IMGROOT;
$pagelogo = "$imagepath" . PHOTOMISC . "/spft.jpg";

if (isset($_POST['edit'])) {
    $student = $_POST['studentName'];
    $season = $_POST['season'];
    $year = $_POST['year'];
    $pIndex = $_POST['pIndex'];
    $selection = $_POST['selection'];
    $returnPage = $_POST['retPage'];
    
    $_SESSION["message"] = "Action not implemented yet!";
    redirect_to("$returnPage?studentName=$student&season=$season&pIndex=$pIndex&year=$year");
} else {
    /*
     * This is neither a request for a new object, or the completion
     * of the previous form. So let's go back to HOME.
     */
    redirect_to("intro.php");
}
?>