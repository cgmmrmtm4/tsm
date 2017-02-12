<?php
/* 
 * MHM: 2017-02-09
 * Comment:
 *  Create new library file that contains all the miscellaneous routines.
 */

if (count(get_included_files()) == 1) {
    exit("direct access not allowed.");
}

/*
 * MHM: 2017-02-05
 * Comment:
 *  Redirect to a different URL.
 *  Input: New php file.
 */
function redirect_to($new_location) {
    header("Location: " . $new_location);
    exit;
}

function form_errors($errors=array()) {
	$output = "";
	if (!empty($errors)) {
        $output .= "<div class=\"error\">";
        $output .= "Please fix the following errors:";
        $output .= "<ul>";
        foreach ($errors as $key => $error) {
            $output .= "<li>";
            $output .= htmlentities($error);
            $output .= "</li>";
        }
        $output .= "</ul>";
        $output .= "</div>";
    }
    return $output;
}

function message() {
    if (isset($_SESSION["message"])) {
        $output = "<div class=\"message\">";
        $output .= htmlentities($_SESSION["message"]);
        $output .= "</div>";
			
        // clear message after use
        $_SESSION["message"] = null;
			
        return $output;
    }
}

function errors() {
    if (isset($_SESSION["errors"])) {
        $errors = $_SESSION["errors"];
			
        // clear message after use
        $_SESSION["errors"] = null;
			
        return $errors;
    }
}
?>