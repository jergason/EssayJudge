<?php session_start();
require_once("config/config.inc.php");
require_once("config/functions.inc.php");

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
						<tr><td align="left" valign=top><?php $get_user_name=mysql_fetch_array(mysql_query("select username from tbl_user where id=".$_GET[user_id]));?>
                  <h3 style="line-height: 18px;text-align:left;margin-left:20px;">Comments by <?php echo ucfirst($get_user_name[0]);?></h3></td><td align="right" class="blue_txt"></td>
                  </tr>

						<?php 
$start=0;
if(isset($_GET['start'])) $start=$_GET['start'];
$pagesize=15;
if(isset($_GET['order_by'])) $order_by=$_GET['order_by'];
$order_by='tbl_comment.comment_date';
if(isset($_GET['order_by2'])) $order_by2=$_GET['order_by2'];
$order_by2='desc';
$result=mysql_query("select tbl_comment.*,date_format(comment_date,'%M %e, %Y') as post_date,tbl_document.doc_title,tbl_document.id as doc_id,tbl_user.username from tbl_comment inner join tbl_document on (tbl_comment.doc_id=tbl_document.id and tbl_comment.comment_by_id=".$_GET['user_id'].") inner join tbl_user on (tbl_document.posted_by=tbl_user.id)  order by $order_by $order_by2 limit $start,$pagesize");
$reccnt=mysql_num_rows(mysql_query("select tbl_comment.*,date_format(comment_date,'%M %e, %Y') as post_date,tbl_document.doc_title,tbl_document.id as doc_id,tbl_user.username from tbl_comment inner join tbl_document on (tbl_comment.doc_id=tbl_document.id and tbl_comment.comment_by_id=".$_GET['user_id'].") inner join tbl_user on (tbl_document.posted_by=tbl_user.id)"));

							if($reccnt>0)
							{
							while($line=mysql_fetch_array($result))
							{
							$bgcolor=="#D6EAF3"?$bgcolor="#ffffff":$bgcolor="#D6EAF3";
							?>
							<tr style="background:<?=$bgcolor?>;">
							<td colspan=2 style="padding:10px">
                     <?php $sql_username=mysql_query("select username from tbl_user where id='".$line['comment_by_id']."'");
							$post_by=mysql_fetch_array($sql_username);?>
                     <div style="float:left;;width:270px"><span class="black_txt"><strong>Comment Posted:</strong></span><span class="black_txt"><?php echo 
							$line[post_date];?></span></div>
                     <div style="float:left;"><span class="black_txt"><strong>Essay:</strong></span><span class="black_txt"><a href="document_detail.php?doc_id=<?php echo $line[doc_id]?>" style="font-size:12px"><?php echo ucfirst(nl2br($line[doc_title]));?></a></span></div><br />
                     <div>
							<p style="text-indent:20px;margin:0"><span class="black_txt"><?php echo ucfirst(nl2br($line[comment]));?></span>
							</div>
							</td>
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
						<td class="warning">No Comments for this User</td>
						</tr>
						<?php }?>
						
						</table>
				  </div>
      <?php include("footer.inc.php")?>
   </div>
</body>
</html>
