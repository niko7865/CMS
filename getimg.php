<?php
require_once("functions.php");
$conn = connect();
$image = stripslashes($_REQUEST[img]);
$rs = mysql_query("select articleImage from articles where id=".$image."");
$row = mysql_fetch_assoc($rs);
$imagebytes = $row[articleImage];
header("Content-type: image/jpeg");
print $imagebytes;
closeconnection($conn);
?>
