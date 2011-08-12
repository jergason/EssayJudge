
<table style="border-spacing:4px;font-family: Verdana, Arial, Helvetica, sans-serif;font-size:12px;">
   <tr>
      <td valign=top>
<div style="width:130px;background-color:#D6EAF3;border: 1px #999999 solid;color:#5C6A72;margin-bottom:0px;font-size:12px;font-weight:bold;padding:2px;"><center>New Essays</center></div>
<?php 
$h=array();
$sp=mysql_query("select * from tbl_flag where ifnull(flag,0)=0 or flag=0");
while($doc=mysql_fetch_array($sp)) {
  $h[]=$doc['document_id'];
}
$imp=implode(",",$h);
if($imp=='') {
  $imp='0';
}
?>



<?php

//following uses  ''and posted_by!=3'' to exclude admin from new essays

$res_new_doc=mysql_query("select id,doc_title,posted_by,date_format(post_date,'%M %e') as post_date from tbl_document where id not in ($imp) and status=1 and posted_by!=3 order by id desc limit 0,10 ");
while($line_new_doc=mysql_fetch_array($res_new_doc))
{
?>
<div style="border-bottom:1px #CCCCCC solid;width:130px;line-height:18px;margin-top:4px;padding-bottom:2px;"><a href="document_detail.php?doc_id=<?=$line_new_doc['id']?>"  style="font-size:12px;font-weight:normal;text-decoration:none;"><?php echo htmlentities(ucwords($line_new_doc['doc_title']));?></a>
<br><center><i><?php echo $line_new_doc['post_date'];?></i></center></div>
<?php }

?>
      </td>
   </tr>
</table>
