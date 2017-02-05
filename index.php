<?php
    /*
     * MHM: 2017-01-16
     * Comment:
     *  If someone attempts to access the base URL, redirect them to
     *  the intro page.
     */
	if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
		$uri = 'https://';
	} else {
		$uri = 'http://';
	}
	$uri .= $_SERVER['HTTP_HOST'];
	header('Location: '.$uri.'/MBHSSQL/_src/intro.php');
	exit;
?>
Something is wrong with the XAMPP installation :-(
