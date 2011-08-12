<?php session_start();
require_once("config/config.inc.php");
require_once("config/functions.inc.php");
if($_REQUEST['action']=="del"){
$sql_del=mysql_query("delete from tbl_document where id='".$_REQUEST['doc_id']."' ");
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>EssayJudge</title>
<link href="style.css" rel="stylesheet" type="text/css">
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-22923970-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body>
   <div class="container">
      <?php include("header.inc.php")?>

            <div style="border: 1px #999999 solid;margin-top:14px;margin-bottom:14px;width:602px">
				   <table style="padding:10px;width:600px;border-spacing:0px;color:#5C6A72;">
               <?php $get_user_name=mysql_fetch_array(mysql_query("select username from tbl_user where id=".$_GET[user_id]));?>
               <tr><td style="text-align:left" valign=top><h3 style="line-height:18px;margin-left:20px;text-align:left"><?php echo ucfirst($get_user_name[0]);?>: Essays</h3></td><td align="right" class="blue_txt"></td></tr>
												
						<?php 
$start=0;
if(isset($_GET['start'])) $start=$_GET['start'];
$pagesize=15;
if(isset($_GET['order_by'])) $order_by=$_GET['order_by'];
$order_by='tbl_document.post_date';
if(isset($_GET['order_by2'])) $order_by2=$_GET['order_by2'];
$order_by2='desc';
$result=mysql_query("select tbl_document.id,tbl_document.doc_title,date_format(tbl_document.post_date,'%M %e, %Y') as post_date,count(tbl_comment.id) as comment_rec from tbl_document  left join tbl_comment on (tbl_document.id=tbl_comment.doc_id) where tbl_document.status=1 and tbl_document.posted_by=".$_GET[user_id]." group by tbl_document.id order by $order_by $order_by2 limit $start,$pagesize" );
$reccnt=mysql_num_rows(mysql_query("select tbl_document.id,tbl_document.doc_title,date_format(tbl_document.post_date,'%M %e, %Y') as post_date,count(tbl_comment.id) as comment_rec from tbl_document  left join tbl_comment on (tbl_document.id=tbl_comment.doc_id) where tbl_document.status=1 and tbl_document.posted_by=".$_GET[user_id]." group by tbl_document.id"));
$myResult=mysql_query("select tbl_document.id,tbl_document.doc_title as doctitle, avg( distinct tbl_rating.score) as avg_score, tbl_user.username,count(tbl_comment.id) as comment_rec from tbl_document inner join tbl_user on (tbl_document.posted_by=tbl_user.id) left join tbl_rating on (tbl_document.id=tbl_rating.document_id) left join tbl_comment on (tbl_document.id=tbl_comment.doc_id) where tbl_document.status=1 and tbl_document.posted_by=".$_GET[user_id]." group by tbl_document.id order by $order_by $order_by2 limit $start ,$pagesize");
							if($reccnt>0)
							{
							while($line=mysql_fetch_array($result))
							{
							$bgcolor=="#D6EAF3"?$bgcolor="#ffffff":$bgcolor="#D6EAF3";
							?>
							
							<tr style="background:<?=$bgcolor?>;">
							<td colspan=2 style="padding:10px">
							<a href="document_detail.php?doc_id=<?=$line[id]?>" style="font-size:12px"><?php echo $line[doc_title];?></a><br>
                     <div style="float:left;width:220px;">
   								<span class="black_txt"><strong>Posted On:</strong></span>&nbsp;<span class="black_txt"><?php echo ucwords($line[post_date]);?></span><br>
							      <span class="black_txt"><strong>Comments:</strong></span>&nbsp;<span class="black_txt"><?php echo ucwords($line[comment_rec]);?></span>
                     </div>
<!-- The score count, edit button, and delete button code follows. The score system is not active on the document_detail page, so do not reactivate score count here without fixing that. Reactivate Edit and Delete buttons by removing comment code here
 
                     <div style="float:left;margin-left:20px;text-align:left;">
                        <? $myLine=mysql_fetch_array($myResult); ?>
   								<span class="black_txt"><strong>Score:</strong></span>&nbsp;<span class="black_txt"><?php if($myLine[avg_score]>0) { echo sprintf("%01.2f",ucwords($myLine[avg_score])); } else { echo sprintf("%01.2f","0");}?></span><br>
                     </div>
                     <div style="float:left;margin-left:20px;text-align:left">
                           <?php if($_SESSION['uid']==$_GET['user_id']){?><span class="black_txt"><a href="add_document.php?doc_id=<?=$line[id]?>">Edit</a></span>&nbsp;<br />
                           <span class="black_txt"><a href="user_documents.php?action=del&doc_id=<?=$line[id]?>&user_id=<?php echo $_GET[user_id]?>">Delete</a></span>&nbsp;<?php }?>
                     </div>

-->							</td>
							</tr>
							<?php 
							}
							?>
							<tr>
							<td>
								<?php include("config/paging.inc.php");?>
							</td>
							</tr>
							<?php
							}
							else
							{
						?>
						<tr align="center">
						<td class="warning">No essays for this User</td>
						</tr>
						<?php }?>
						
						</table>
				  </div>
      <?php include("footer.inc.php")?>
   </div>
</body>
</html>