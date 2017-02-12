<?php
/*
 * MHM: 2017-02-05
 * Comment:
 *  Future support for add season.
 *
 * MHM: 2017-02-10
 * Comment:
 *  Changes for include layout. Some format changes so the code 
 *  does not sprawl so far to the right.
 */
require("../_includes/req_includes.php");
    
if ((isset($_POST['submit'])) || (isset($_POST['add']))) {
    $studentName = $_POST['studentName'];
    if (isset($_POST['submit'])) {
        /*
         * Process the form
         */
        redirect_to("khp.php?studentName=$studentName");
    }
    /*
     * Display the form
     */
    redirect_to("academics.php?studentName=$studentName");
} else {
    /*
     * This is neither a request for a new object, or the completion
     * of the previous form. So let's go back to HOME.
     */
    redirect_to("intro.php");
}
?>
        