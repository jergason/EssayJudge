<?
if($reccnt > $pagesize){
	
$num_pages=$reccnt/$pagesize;

$PHP_SELF=$_SERVER['PHP_SELF'];
$qry_str=$_SERVER['argv'][0];

$m=$_GET;
unset($m['start']);

$qry_str=qry_str($m);

//echo "$qry_str : $p<br>";

//$j=abs($num_pages/10)-1;
$j=$start/$pagesize-5;
//echo("<br>$j");
if($j<0) {
	$j=0;
}
$k=$j+10;
if($k>$num_pages)	{
	$k=$num_pages;
}
$j=intval($j);
?>
<?//="reccnt=$reccnt, start=$start, pagesize=$pagesize, num_pages=$num_pages : j=$j : k=$k"?>
<!-- Can't find this stylesheet, so commenting it out to avoid 404.
<link rel="stylesheet" href="css/algarve.css" type="text/css">
<! -->
<table border="0" cellspacing="0" cellpadding="0" align="center"> 
  <tr> 
    <td  align="left"><a href="<?=$PHP_SELF?><?=$qry_str?>&start=0" class="txt"> First</a>&nbsp; </td> 
    <td  align="center" height="20"> <a href="<?=$PHP_SELF?><?=$qry_str?>&start=<?=$start-$pagesize?>" class="txt" > 
      <?
		if($start!=0)
		{

?> 
&laquo; Previous
      <?=$pagesize?> 
      </a>&nbsp; 
      <?
		}
?> </td> 
<br><br><br><br>

    <td align="center" height="20"> <span > 
      <?
	if($start+$pagesize < $reccnt){
		?> 
&nbsp;&nbsp; <a href="<?=$PHP_SELF?><?=$qry_str?>&start=<?=$start+$pagesize?>" class="txt">Next
      <?=$pagesize?> 
&raquo;</a>&nbsp; 
      <?
		}
  ?> 
      </span>&nbsp;</td> 

<td align="center" height="20" ><?$mod=$reccnt%$pagesize; if($mod==0){$mod=$pagesize;}?> 
   &nbsp;&nbsp;<a href="<?=$PHP_SELF?><?=$qry_str?>&start=<?=$reccnt-$mod?>" class="txt">Last</a></td> 
    <td align="right" > &nbsp;&nbsp;&nbsp; 
      <?
			
			for($i=$j;$i<$k;$i++)
			{
				if($i==$j)echo "Page:";
			   if(($pagesize*($i))!=$start)
				  {
	  ?> 
      <a href="<?=$PHP_SELF?><?=$qry_str?>&start=<?=$pagesize*($i)?>" class="txt" style="text-decoration:none;" > 
      <?=$i+1?> 
      </a> 
      <?
				  }
	  else{
	  ?> 
      <b> 
      <?=$i+1?> 
      </b> 
      <?
	  }
 }?> </td> 
  </tr> 
</table> 
<?}
?> 
