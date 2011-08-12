
<table style="border-spacing:4px;font-family: Verdana, Arial, Helvetica, sans-serif;font-size:12px;">
   <tr>
<td valign=top>
<div style="width:130px;background-color:#D6EAF3;border: 1px #999999 solid;color:#5C6A72;margin-bottom:0px;font-size:12px;font-weight:bold;padding:2px;"><center>Featured Essays</center></div>
<?php $feature=mysql_query("select id,doc_title from tbl_document where id not in ($imp) and status=1 and feature=1 order by doc_title asc limit 0,10 ");
while($line_feature=mysql_fetch_array($feature))
{
?>
<div style="border-bottom:1px #CCCCCC solid;width:130px;line-height:18px;margin-top:4px;padding-bottom:2px;">
<a href="document_detail.php?doc_id=<?=$line_feature['id']?>" style="font-size:12px;font-weight:normal;text-decoration:none;"><?php echo nl2br($line_feature['doc_title']);?></a>
</div>
<?php }?>
      </td>
   </tr>
</table>
