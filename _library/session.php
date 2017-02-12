<?php
if (count(get_included_files()) == 1) {
    exit("direct access not allowed.");
}
session_start();
?>