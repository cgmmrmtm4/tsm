<?php
/*
 * MHM: 2017-01-17
 * Comment:
 *  Constants used by all pages
 *
 * MHM: 2017-01-18
 * Comment:
 *  Added defines for home pages and additional non-sport activities.
 *
 * MHM: 2017-01-19
 * Comment:
 *  Added PICS constant.
 */

if (count(get_included_files()) == 1) {
    exit("direct access not allowed.");
}

// File directory Constants
define ("HOMEROOT", "/MBHSSQL");
define ("IMGROOT", "../../img/mbhs");
define ("PHOTOSPORTS", "/Photos/Sports");
define ("PHOTOACADEMICS", "/Photos/Academics");
define ("PHOTOMISC", "/Photos/Misc");
define ("PHOTOTRAVEL", "/Photos/Travel");
define ("VIDEOSPORTS", "/Videos/Sports");
define ("FOOTERPIC", "../../img/mbhs/Photos/Misc/logo.jpg");

// Intro and home pages
define ("HOME", "Home");

// Student Constants
define ("THEO", "Theodore");
define ("RACHEL", "Rachel");

// Sports
define ("VB", "Volleyball");
define ("SB", "Softball");
define ("TENNIS", "Tennis");
define ("SOC", "Soccer");
define ("FROSH", "Frosh");
define ("JV", "JV");
define ("VARSITY", "Varsity");

// Non-sport activities
define ("ACADEMIC", "Academic");
define ("TRAVEL", "Travel");

// Seasons
define ("SUMMER", "SUMMER");
define ("FALL", "FALL");
define ("WINTER", "WINTER");
define ("SPRING", "SPRING");

// Pictures
define ("NOPICS", "nopics");
define ("PICS", "pics");

// Videos
define ("NOVIDS", "novideos");

// stats
define ("NOSTATS", "nostats");

?>