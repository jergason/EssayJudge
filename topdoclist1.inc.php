<div id="sidebar">
<div id="topdoc">Recent Essays</div>
<?php 
$h=array();
$sp=mysql_query("select * from tbl_flag where ifnull(flag,0)=0 or flag=0");
while($doc=mysql_fetch_array($sp))
{
$h[]=$doc['document_id'];
}
$imp=implode(",",$h);
if($imp=='')
$imp='0';
?>

<?php 
//following uses  ''and posted_by!=3'' to exclude admin from new essays
$res_new_doc=mysql_query("select id,doc_title,posted_by,date_format(post_date,'%M %e') as post_date from tbl_document where id not in ($imp) and status=1 and posted_by!=3 order by id desc limit 0,10 ");					
while($line_new_doc=mysql_fetch_array($res_new_doc))
{
?>
<div id="essaytitle"><a href="document_detail.php?doc_id=<?=$line_new_doc[id]?>"<?php echo ucwords($line_new_doc[doc_title]);?></a>
<br>
<div id="date"><?php echo $line_new_doc[post_date];?></div>
<?php }
?>
</div>