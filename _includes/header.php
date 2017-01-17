<?php
    /*
     * MHM: 2017-01-16
     *
     * Comment:
     *  Do not allow direct access to include files.
     *  header.php:
     *      Display the header navigational field for the selected student.
     *      If not for a particular student, then the navigation is to each
     *      students main web page.
     */
    if (count(get_included_files()) == 1) {
            exit("direct access not allowed.");
    }
?>
<header>
    <div class="branding"> <img src="<?= $pagelogo; ?>" width="90" height="105" alt="Logo">
        <p>Morro Bay High School<br>
            Academics • Sports</p>
    </div>
    <div class="description">
        <?php
            if ($student == THEO) {
        ?>
                <h1>Theo's High School Web Page 2014-2018</h1>
                <p>Highlights of Theo's High School career</p>
        <?php
            } else {
                if ($student == RACHEL) {
        ?>
                    <h1> Rachel's High School Web Page 2009-2013</h1>
                    <p>Highlights of Rachel's High School career</p>
        <?php
                } else {
        ?>
                    <h1> Rachel and Theo's High School Web Pages</h1>
        <?php
                }
            }
        ?>
    </div>
    <nav>
        <ol>
            <li><a href="<?= $siteroot; ?>/_src/intro.php">HOME</a></li>
            <?php 
                if ($student == THEO) {
            ?>
                    <li><a href="<?= $siteroot; ?>/_src/academics.php?studentName=<?= THEO ?>">ACADEMICS</a></li>
                    <li><a href="<?= $siteroot; ?>/_src/soccer.php?studentName=<?= THEO ?>">SOCCER</a></li>
                    <li><a href="<?= $siteroot; ?>/_src/volleyball.php?studentName=<?= THEO ?>">VOLLEYBALL</a></li>
                    <li><a href="<?= $siteroot; ?>/_src/travel.php?studentName=<?= THEO ?>">TRAVEL</a></li>
            <?php
                } else {
                    if ($student == RACHEL) {
            ?>
                        <li><a href="<?= $siteroot; ?>/_src/academics.php?studentName=<?= RACHEL ?>">ACADEMICS</a></li>
                        <li><a href="<?= $siteroot; ?>/_src/volleyball.php?studentName=<?= RACHEL ?>">VOLLEYBALL</a></li>
                        <li><a href="<?= $siteroot; ?>/_src/softball.php?studentName=<?= RACHEL ?>">SOFTBALL</a></li>
                        <li><a href="<?= $siteroot; ?>/_src/tennis.php?studentName=<?= RACHEL ?>">TENNIS</a></li>
            <?php
                    } else {
            ?>
                        <li><a href="<?= $siteroot; ?>/_src/khp.php?studentName=<?= RACHEL ?>">RACHEL</a></li>
                        <li><a href="<?= $siteroot; ?>/_src/khp.php?studentName=<?= THEO ?>">THEO</a></li>
            <?php
                    }
                }
            ?>
            <li><a href="http://mbhs.slcusd.org" title="Morro Bay HS Homepage" target="_blank" class="flowRight">MBHS HOME</a></li>
        </ol>
    </nav>
</header>
<div id="rotator"><img src="<?= $imagepath . PHOTOMISC; ?>/mbhs.jpg" width="1000" height="220" alt="MBHS from land"></div>