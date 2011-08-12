<?php
require_once("config/config.inc.php");

$q="describe tbl_user"
$link=mysql_query($q);
if($link=='')
{
echo "fail";

}
else
{
echo $link[0];
echo "<Br>";
echo $link[0];
echo "<Br>";
echo $link[0];
}

?>