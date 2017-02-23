<?php
/*
 * A file used to just test php logic behavior
 */
$keywords = preg_split("/[\s-,\)(]+/", "25 - 17, 25 - 18 (2 - 0)");
$myDate = preg_split("/-/", "2017-02-03");
$count = count($keywords);
$str = "2:6(2:5)(2:6)";
$humm = explode(')(', trim($str, '()'));
echo date('d');
echo date('Y');
print_r($keywords);
print_r($count);
print_r($myDate);
print_r($humm);
?>
<input type="submit" name="delete" value="DELETE" onclick="return confirm('Are you sure?')">