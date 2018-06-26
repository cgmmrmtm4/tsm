<?php
/*
 * MHM: 2017-02-20
 * Comment:
 *  Add new functions to validate a match score against the games submitted and whether or not
 *  the game values look to be correct.
 *
 * MHM: 2017-02-21
 * Comment:
 *  Additonal error checking and better error location identification.
 * 
 * MHM: 2018-06-25
 * Comment:
 *  Code cleanup.
 */

if (count(get_included_files()) == 1) {
    exit("direct access not allowed.");
}

$errors = array();

function fieldname_as_text($fieldname) {
    $fieldname = str_replace("_", " ", $fieldname);
    $fieldname = ucfirst($fieldname);
    return $fieldname;
}

// * presence
// use trim() so empty spaces don't count
// use === to avoid false positives
// empty() would consider "0" to be empty
function has_presence($value) {
	return isset($value) && $value !== "";
}

function validate_presences($required_fields) {
    global $errors;
    foreach($required_fields as $field) {
        $value = trim($_POST[$field]);
        if (!has_presence($value)) {
  		    $errors[$field] = fieldname_as_text($field) . " can't be blank";
  	    }
    }
}

// * string length
// max length
function has_max_length($value, $max) {
	return strlen($value) <= $max;
}

function validate_max_lengths($fields_with_max_lengths) {
	global $errors;
	// Expects an assoc. array
	foreach($fields_with_max_lengths as $field => $max) {
		$value = trim($_POST[$field]);
	    if (!has_max_length($value, $max)) {
	        $errors[$field] = fieldname_as_text($field) . " is too long";
	    }
	}
}

function validate_match_score($matchScores=array()) {
    global $errors;
    
    $totGames = $matchScores['matchmb'] + $matchScores['matchopp'];
    if (($totGames >5) || ($totGames < 1)) {
        $errors['matchScore'] = "Match Score total must be between 0 and 6 games ";
    } else {
        $gamesMBArray = array("mbs1", "mbs2", "mbs3", "mbs4", "mbs5");
        $gamesOppArray = array("opps1", "opps2", "opps3", "opps4", "opps5");
    
        for ($count = 0; $count < $totGames; $count++) {
            if (($matchScores[$gamesMBArray[$count]] == 0) && ($matchScores[$gamesOppArray[$count]] == 0)) {
                $errors['matchScore'] = "Total games for match does not equal the game data provided";
                break;
            }
        }
        for ($count = $totGames; $count < 5; $count++) {
            if (($matchScores[$gamesMBArray[$count]] !=0) || ($matchScores[$gamesOppArray[$count]] != 0)) {
                $errors[$gamesMBArray[$count]] = "The total games is greater than the match score.";
            }
        }
    }
}


function validate_game_scores($matchScores=array()) {
    global $errors;
    
    $gamesMBArray = array("mbs1", "mbs2", "mbs3", "mbs4", "mbs5");
    $gamesOppArray = array("opps1", "opps2", "opps3", "opps4", "opps5");
    
    $totGames = $matchScores['matchmb'] + $matchScores['matchopp'];
    for ($count = 0; $count < $totGames; $count++) {
        $mbScore = $matchScores[$gamesMBArray[$count]];
        $oppScore = $matchScores[$gamesOppArray[$count]];
        if ((abs($mbScore - $oppScore)) < 2) {
            $gameNumber = $count+1;
            $errors[$gamesMBArray[$count]
            ] = "Must win game {$gameNumber} by at least two points.";
        }
    }
}

// * inclusion in a set
function has_inclusion_in($value, $set) {
	return in_array($value, $set);
}

?>