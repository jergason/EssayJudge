<?php
/******************************************************************************
*		File : functions.inc.php                                              *
*       Created By : ValueOnWeb Panel User                                    *
*       Organization  : ValueOnWeb                                            *
*       Date Created : Tuesday 27 March 2007, 1:05 PM                         *
*       Date Modified : Tuesday 27 March 2007, 1:05 PM                        *
*       File Comment : This file contain functions which will use in coding.  *
*                                                                             *
*******************************************************************************/

// For Executing Query. This function returns a argument which contain recordset 
// object through it user can retrieve values of table.
function executeQuery($sql)
{
	$result = mysql_query($sql) or die("<span style='FONT-SIZE:11px; FONT-COLOR: #000000; font-family=tahoma;'><center>An Internal Error has Occured. Please report following error to the webmaster.<br><br>".$sql."<br><br>".mysql_error()."'</center></FONT>");
	return $result;
} 

// This function returns a recordset object that contain first record data.
function getSingleResult($sql)
{
	$response = "";
	$result = mysql_query($sql) or die("<center>An Internal Error has Occured. Please report following error to the webmaster.<br><br>".$sql."<br><br>".mysql_error()."'</center>");
	if ($line = mysql_fetch_array($result)) {
		$response = $line['0'];
	} 
	return $response;
} 

// For Executing Query. This function update the table by desired data.
function executeUpdate($sql)
{
	mysql_query($sql) or die("<center>An Internal Error has Occured. Please report following error to the webmaster.<br><br>".$sql."<br><br>".mysql_error()."'</center>");
}

// It returns the path of current file.
function getCurrentPath()
{
	global $_SERVER;
	return "http://" . $_SERVER['HTTP_HOST'] . getFolder($_SERVER['PHP_SELF']);
}

// This function adjusts the decimal point of argumented parameter and return the adjusted value.
function adjustAfterDecimal($param)
{
	if(strpos($param,'.')== "")
	{
		$final_value=$param.".00";
		return  $final_value;
	}
	$after_decimal  = substr($param , strpos($param,'.')+1, strlen($param) );	
	$before_decimal = substr($param,0 ,  strpos($param,'.'));
	if(strlen($after_decimal)<2)
	{
		if(strlen($after_decimal)==1)
		{
			$final_value=$param."0";
		}
		if(strlen($after_decimal)==0)
		{
			$final_value.="$param.00";
		}
	}
	else
	{
		$trim_value = substr($after_decimal,0,2);
		$final_value.=$before_decimal.".".$trim_value;
	}
	return $final_value;
}	

// This funtion is used for validating the front side users that he is logged in or not.
function validate_user()
{
	if($_SESSION['uid']=='')
	{
		ms_redirect("login.php?back=$_SERVER[REQUEST_URI]");
	}
}

// This funtion is used for validating the admin side users that he is logged in or not.
function validate_admin()
{
	if($_SESSION['sess_uid']=='')
	{
		ms_redirect("index.php?back=$_SERVER[REQUEST_URI]");
	}
}

// This function is used for redirecting the file on desired file.
function ms_redirect($file, $exit=true, $sess_msg='')
{
	header("Location: $file");
	exit();
	
}

function get_qry_str($over_write_key = array(), $over_write_value= array())
{
	global $_GET;
	$m = $_GET;
	if(is_array($over_write_key)){
		$i=0;
		foreach($over_write_key as $key){
			$m[$key] = $over_write_value[$i];
			$i++;
		}
	}else{
		$m[$over_write_key] = $over_write_value;
	}
	$qry_str = qry_str($m);
	return $qry_str;
} 

function qry_str($arr, $skip = '')
{
	$s = "?";
	$i = 0;
	foreach($arr as $key => $value) {
		if ($key != $skip) {
			if(is_array($value)){
				foreach($value as $value2){
					if ($i == 0) {
						$s .= "$key%5B%5D=$value2";
					$i = 1;
					} else {
						$s .= "&$key%5B%5D=$value2";
					} 
				}		
			}else{
				if ($i == 0) {
					$s .= "$key=$value";
					$i = 1;
				} else {
					$s .= "&$key=$value";
				} 
			}
		} 
	} 
	return $s;
} 


function ms_print_r($var)
{
	global $local_mode;
	if ($local_mode || $debug) {
	echo "<pre>";
	print_r($var);
	echo "</pre>";
	}
} 

function add_slashes($param)
{
	$k_param = addslashes(stripslashes($param));
	return $k_param;
} 

function ms_stripslashes($text)
{
	if (is_array($text)) {
		$tmp_array = Array();
		foreach($text as $key => $value) {
			$tmp_array[$key] = ms_stripslashes($value);
			} 
		return $tmp_array;
	} else {
		return stripslashes($text);
	} 
} 

function ms_addslashes($text)
{
	if (is_array($text)) {
		$tmp_array = Array();
		foreach($text as $key => $value) {
			$tmp_array[$key] = ms_addslashes($value);
		} 
		return $tmp_array;
	} else {
		return addslashes(stripslashes($text));
	} 
} 

function html2text($html)
{
	$search = array ("'<head[^>]*?>.*?</head>'si", // Strip out javascript
		"'<script[^>]*?>.*?</script>'si", // Strip out javascript
		"'<[\/\!]*?[^<>]*?>'si", // Strip out html tags
		"'([\r\n])[\s]+'", // Strip out white space
		"'&(quot|#34);'i", // Replace html entities
		"'&(amp|#38);'i",
		"'&(lt|#60);'i",
		"'&(gt|#62);'i",
		"'&(nbsp|#160);'i",
		"'&(iexcl|#161);'i",
		"'&(cent|#162);'i",
		"'&(pound|#163);'i",
		"'&(copy|#169);'i",
		"'&#(\d+);'e"); // evaluate as php
	$replace = array ("",
		"",
		"",
		"\\1",
		"\"",
		"&",
		"<",
		">",
		" ",
		chr(161),
		chr(162),
		chr(163),
		chr(169),
		"chr(\\1)");
	$text = preg_replace ($search, $replace, $html); 
	return $text;
} 

function sort_arrows($column){
	global $_SERVER;
	return '<A HREF="'.$_SERVER['PHP_SELF'].get_qry_str(array('order_by','order_by2'), array($column,'asc')).'"><IMG SRC="images/white_up.gif" BORDER="0"></A> <A HREF="'.$_SERVER['PHP_SELF'].get_qry_str(array('order_by','order_by2'), array($column,'desc')).'"><IMG SRC="images/white_down.gif" BORDER="0"></A>';
}

function unlink_file( $file_name , $folder_name )
{
	$file_path = $folder_name."/".$file_name;
	@chmod ($foleder_name , 0777);
	@unlink($file_path);
	return true;	
}
function getUserName($id) {
	$query = "select * from user where userid=$id";
	$rs = executeQuery($query);
	$row = mysql_fetch_array($rs);
	return $row["username"];
}
function getUserEmail($id) {
	$query = "select * from user where userid=$id";
	$rs = executeQuery($query);
	$row = mysql_fetch_array($rs);
	return $row["email"];
}

function showImage($imageName) {
	if(is_file(SITE_FS_PATH."/property_pic/".$imageName)) {
		$rtVar = "<img src='property_pic/".$imageName."' width='107'>";
	} else {
		$rtVar ='<img src="images/no-image.jpg" width="107" height="105">';
	}
	return	$rtVar;
}
function getPropertyType($id) {
	$query = "select * from property_type where id=".$id;
	$rs = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_array($rs);
	return $row["title"];
}
function getName($id) {
	$query = "select * from user where userid=".$id;
	$rs = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_array($rs);
	return $row["fname"]." ".$row["lname"];
}
function getEmail($id) {
	$query = "select * from user where userid=".$id;
	$rs = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_array($rs);
	return $row["email"];
}


function resize_img($imgPath, $maxWidth, $maxHeight, $directOutput = true, $quality = 90, $verbose,$imageType)
{
   // get image size infos (0 width and 1 height,
   //     2 is (1 = GIF, 2 = JPG, 3 = PNG)
  
     $size = getimagesize($imgPath);
		$arr=explode(".",$imgPath);		
   // break and return false if failed to read image infos
     if(!$size){
       if($verbose && !$directOutput)echo "<br />Not able to read image infos.<br />";
       return false;
     }

   // relation: width/height
     $relation = $size[0]/$size[1];
	 
	 $relation_original = $relation;
   
   
   // maximal size (if parameter == false, no resizing will be made)
     $maxSize = array($maxWidth?$maxWidth:$size[0],$maxHeight?$maxHeight:$size[1]);
   // declaring array for new size (initial value = original size)
     $newSize = $size;
   // width/height relation
     $relation = array($size[1]/$size[0], $size[0]/$size[1]);


	if(($newSize[0] > $maxWidth))
	{
		$newSize[0]=$maxSize[0];
		$newSize[1]=$newSize[0]*$relation[0];
		/*if($newSize[1]>180)
		{
			$newSize[1]=180;
			$newSize[1]=$newSize[0]*$relation[0];
		}*/
		
	
		$newSize[0]=$maxWidth;
		$newSize[1]=$newSize[0]*$relation[0];		
		
	}
	
		$newSize[0]=$maxWidth;
		$newSize[1]=$newSize[0]*$relation[0];	
	
		 
	
	/*
	if(($newSize[1] > $maxHeight))
	{
		$newSize[1]=$maxSize[1];
		$newSize[0]=$newSize[1]*$relation[1];
	}
	*/
     // create image

       switch($size[2])
       {
         case 1:
           if(function_exists("imagecreatefromgif"))
           {
             $originalImage = imagecreatefromgif($imgPath);
           }else{
             if($verbose && !$directOutput)echo "<br />No GIF support in this php installation, sorry.<br />";
             return false;
           }
           break;
         case 2: $originalImage = imagecreatefromjpeg($imgPath); break;
         case 3: $originalImage = imagecreatefrompng($imgPath); break;
         default:
           if($verbose && !$directOutput)echo "<br />No valid image type.<br />";
           return false;
       }


     // create new image

       $resizedImage = imagecreatetruecolor($newSize[0], $newSize[1]); 

       imagecopyresampled($resizedImage, $originalImage,0, 0, 0, 0,$newSize[0], $newSize[1], $size[0], $size[1]);

	$rz=$imgPath;

     // output or save
       if($directOutput)
		{
         imagejpeg($resizedImage);
		 }
		 else
		{
			
			 $rz=preg_replace("/\.([a-zA-Z]{3,4})$/","".$imageType.".".$arr[count($arr)-1],$imgPath);
         		imagejpeg($resizedImage, $rz, $quality);
         }
     // return true if successfull
       return $rz;
}

function getvalue($var,$lang)
{
	$res_var=mysql_query("select value from tbl_translate where lang_id=$lang and variable='$var' and status=1");
	$line_var=mysql_fetch_array($res_var);
	echo $line_var['value'];
}

function getvalue1($var,$lang)
{
	$res_var1=mysql_query("select * from tbl_data where lang_id=$lang and id=$var and status=1" );
	$line_var1=mysql_fetch_array($res_var1);
	echo $line_var1['value'];
	 
}
?>