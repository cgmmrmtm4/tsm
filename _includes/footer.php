<?php
/*
 * MHM: 2017-01-17
 * Comment:
 *  Do not allow direct access to include files.
 *  footer.php:
 *      Display the page footer for all HTML pages.
 *      Computes the copyright date range.
 *
 * MHM: 2017-02-10
 * Comment:
 *  Some format changes so the code does not sprawl so far to the right.
 *
 * MHM: 2017-02-12
 * Comment:
 *  Use CSS to control the height and width of the brand image.
 */
if (count(get_included_files()) == 1) {
    exit("direct access not allowed.");
}
?>
<footer>
    <div class="branding"> <img src="<?= FOOTERPIC; ?>" alt="Logo"> </div>
    <div class="description"><?= mhm_copyright(2015) ;?> Mark Mackey</div>
</footer>