<?php
/*
 * MHM: 2017-01-16
 * Comment:
 *  Do not allow direct access to include files.
 *  header.php:
 *      Display the header navigational field for the selected student.
 *      If not for a particular student, then the navigation is to each
 *      students main web page.
 *
 * MHM: 2017-01-18
 * Comment:
 *  Add class=selected to the navigation button of the page we are currently on.
 *  This will change the text to red highlighting the selected navigation tab.
 *
 * MHM: 2017-02-05
 * Comment:
 *  The intro navigational header should point to the students home page and not
 *  their academic page.
 *
 * MHM: 2017-02-10
 * Comment:
 *  Some format changes so the code does not sprawl so far to the right.
 *
 * MHM: 2017-02-12
 * Comment:
 *  Change branding height and width. Need to consider doing this in CSS only. Need to consider
 *  the same change for the rotator image. Added a div for messaging.
 */
if (count(get_included_files()) == 1) {
    exit("direct access not allowed.");
}
?>
<header>
    <div class="branding"> <img src="<?= $pagelogo; ?>" width="90" height="75" alt="Logo">
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
<?php
        /*
         * MHM: 2017-01-18
         *
         * Comment:
         *  On all pages, there is always a HOME tab.
         *
         */
        echo "<li";
        if ($selection == HOME) {
            echo " class=\"selected\"";
        }
        echo "><a href=\"$siteroot/_src/intro.php\">HOME</a></li>";
                
        /*
         * MHM: 2017-01-18
         * Comment:
         *  Common tabs that are available for each child. Luckily, they both played volleyball.
         *
         */
        if (($student == THEO) || ($student == RACHEL)) {
            echo "<li";
            if ($selection == ACADEMIC) {
                echo " class=\"selected\"";
            }
            echo "><a href=\"$siteroot/_src/academics.php?studentName=$student\">ACADEMICS</a></li>";
                    
            echo "<li";
            if ($selection == VB) {
                echo " class=\"selected\"";
            }
            echo "><a href=\"$siteroot/_src/volleyball.php?studentName=$student\">VOLLEYBALL</a></li>";
                    
            /*
             * MHM: 2017-01-18
             * Comment:
             *  Theo specific tabs
             *
             */
            if ($student == THEO) {
                echo "<li";
                if ($selection == SOC) {
                    echo " class=\"selected\"";
                }
                echo "><a href=\"$siteroot/_src/soccer.php?studentName=$student\">SOCCER</a></li>";
                    
                echo "<li";
                if ($selection == TRAVEL) {
                    echo " class=\"selected\"";
                }
                echo "><a href=\"$siteroot/_src/travel.php?studentName=$student\">TRAVEL</a></li>";
            }

            /*
             * MHM: 2017-01-18
             * Comment:
             *  Rachel specific tabs.
             *
             */
            if ($student == RACHEL) {
                echo "<li";
                if ($selection == SB) {
                    echo " class=\"selected\"";
                }
                echo "><a href=\"$siteroot/_src/softball.php?studentName=$student\">SOFTBALL</a></li>";
                    
                echo "<li";
                if ($selection == TENNIS) {
                    echo " class=\"selected\"";
                }
                echo "><a href=\"$siteroot/_src/tennis.php?studentName=$student\">TENNIS</a></li>";
            }
        } else {
                    
            /*
             * MHM: 2017-01-18
             * Comment:
             *  This is the home navigation page, so the tabs will just navigate us to
             *  the student's academic page.
             *
             *  In this case, student is either null or someone passed in an unspported student.
             *  Build the supported tabs and then set $student to null.
             *
             */
            $student=RACHEL;
            echo "<li><a href=\"$siteroot/_src/khp.php?studentName=$student\">RACHEL</a></li>";
            $student=THEO;
            echo "<li><a href=\"$siteroot/_src/khp.php?studentName=$student\">THEO</a></li>";
            $student=null;
        }
?>
            <li><a href="http://mbhs.slcusd.org" title="Morro Bay HS Homepage" target="_blank" class="flowRight">MBHS HOME</a></li>
        </ol>
    </nav>
</header>
<div id="rotator"><img src="<?= $imagepath . PHOTOMISC; ?>/mbhs.jpg" width=100% height="120" alt="MBHS from land"></div>
<?php
echo message();
echo form_errors($errors);
?>