<?php
/*
 * MHM: 2017-02-12
 * Comment:
 *  Future support for delete stats.
 *
 * MHM: 2017-02-13
 * Comment:
 *  Removed variables pictures, videos and stats and now just use pIndex to
 *  reference the different panels.
 *
 * MHM: 2013-02-23
 * Comment:
 *  Support the delete functionality.
 */
require("../_includes/req_includes.php");
$siteroot = HOMEROOT;
$imagepath = IMGROOT;
$pagelogo = "$imagepath" . PHOTOMISC . "/spft.jpg";

$connection = open_db();
if (isset($_POST['delete'])) {
    
    $returnPage = $_POST['retPage'];
    $statId = $_POST['statId'];
    $result = delete_stats_from_vbstats($connection, $statId);
    
    if ($result) {
        $_SESSION["message"] = "Stats successfully deleted from database.";
        close_db($connection);
        redirect_to("{$returnPage}");
    } else {
        $_SESSION["message"] = "Failed to delete stats from database!"; 
    }
} else {
    /*
     * This is must be a get request.
     */
    redirect_to("intro.php");
}
?>