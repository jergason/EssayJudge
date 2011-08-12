<?php 
//Generates a security code image.
@session_start();
session_register("seccode");
$img_number = imagecreate(103,30);
$white = imagecolorallocate($img_number,255,255,255);
$black = imagecolorallocate($img_number,0,0,0);

//bgcolor
$grey_shade = imagecolorallocate($img_number,239,245,250);

imagefill($img_number,0,0,$grey_shade);
ImageRectangle($img_number,1,1,100,29,$black);
$number =  chr(rand(65,90)).rand(0,9).chr(rand(65,90)).rand(0,9).chr(rand(65,90));
$number1 ="Address: ".$_SERVER['REMOTE_ADDR'];
$number=substr($number,0,4);
$seccode=$number;
$_SESSION['seccode']=$seccode;
Imagestring($img_number,14,30,5,$number,$black);
//ImageRectangle($img_number,1,15,187,15,$black);
//Imagestring($img_number,2,5,15,$number1,$black);
header("Content-type: image/jpeg");
imagejpeg($img_number);

function get_random() {
   $r="Remote Port: ".$_SERVER['REMOTE_PORT'];
   $r.="\n";
   $r.="Remote Address: ".$_SERVER['REMOTE_ADDR'];
   return $r;
}

?>

