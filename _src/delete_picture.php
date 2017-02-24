<?php
/*
 * MHM: 2017-02-12
 * Comment:
 *  Future support for delete pictures.
 *
 * MHM: 2017-02-13
 * Comment:
 *  Removed variables pictures, videos and stats and now just use pIndex to
 *  reference the different panels.
 *
 * MHM: 2017-02-23
 * Comment:
 *  Support for delete picture.
 */
require("../_includes/req_includes.php");
$siteroot = HOMEROOT;
$imagepath = IMGROOT;
$pagelogo = "$imagepath" . PHOTOMISC . "/spft.jpg";

if (isset($_POST['delete'])) {
    
    $connection = open_db();
    $returnPage = $_POST['retPage'];
    $pictureId = $_POST['photoId'];
    $result = delete_av_from_av($connection, $pictureId);
    
    if ($result) {
        $_SESSION["message"] = "Picture successfully deleted from database.";
    } else {
        $_SESSION["message"] = "Failed to delete picture from database!"; 
    }
    close_db($connection);
    redirect_to("{$returnPage}");
} else {
    /*
     * This is must be a get request.
     */
    redirect_to("intro.php");
}
?>