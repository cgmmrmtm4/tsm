<?php
    if (count(get_included_files()) == 1) {
            exit("direct access not allowed.");
    }
?>
<footer>
    <div class="branding"> <img src="<?= FOOTERPIC; ?>" width="90" height="65" alt="Logo"> </div>
    <div class="description"><?= mhm_copyright(2015) ;?> Mark Mackey</div>
</footer>