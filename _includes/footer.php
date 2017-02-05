<?php
    /*
     * MHM: 2017-01-17
     * Comment:
     *  Do not allow direct access to include files.
     *  footer.php:
     *      Display the page footer for all HTML pages.
     *      Computes the copyright date range.
     */
    if (count(get_included_files()) == 1) {
            exit("direct access not allowed.");
    }
?>
<footer>
    <div class="branding"> <img src="<?= FOOTERPIC; ?>" width="90" height="65" alt="Logo"> </div>
    <div class="description"><?= mhm_copyright(2015) ;?> Mark Mackey</div>
</footer>