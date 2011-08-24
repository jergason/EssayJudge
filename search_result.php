<?php session_start();
require_once("config/config.inc.php");
require_once("config/functions.inc.php");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
		<div id="main">
           <div id="subheading">All Essays</div>
<!-- DOESNT WORK<a href="search_result.php?or=a">Alphabatically</a> | <a href="search_result.php">Recent Essays</a> --><br /><br /></td></tr>
						<?php 
							if($_POST['search_text'])
							{ 
								$where=" and  keywords like '%".trim($_POST['search_text'])."%' or tbl_document.doc_title like '%".$_POST[search_text]."%' or tbl_user.username like '%".$_POST[search_text]."%'";
							}
							if($_REQUEST['or'])
							{
							$start=0;
							if(isset($_GET['start'])) $start=$_GET['start'];
							$pagesize=10;
							if(isset($_GET['order_by'])) $order_by=$_GET['order_by'];
							$result1=mysql_query("select tbl_document.id,tbl_document.doc_title,date_format(tbl_document.post_date,'%M %e, %Y') as post_date,tbl_user.username,count(tbl_comment.id) as comment_rec from tbl_document inner join tbl_user on (tbl_document.posted_by=tbl_user.id) inner join tbl_comment on (tbl_document.id=tbl_comment.doc_id) where tbl_document.status=1 $where group by tbl_document.id order by doc_title limit $start ,$pagesize");
							$result=mysql_query("select tbl_document.id,tbl_document.doc_title,date_format(tbl_document.post_date,'%M %e, %Y') as post_date,tbl_user.username,count(tbl_comment.id) as comment_rec from tbl_document inner join tbl_user on (tbl_document.posted_by=tbl_user.id) inner join tbl_comment on (tbl_document.id=tbl_comment.doc_id) where tbl_document.status=1 $where group by tbl_document.id order by doc_title");
							}
							else
							{
								$start=0;
								if(isset($_GET['start'])) $start=$_GET['start'];
								$pagesize=10;
								if(isset($_GET['order_by'])) $order_by=$_GET['order_by'];
	
//added"tbl_document.posted_by!=3 and" below to exclude essays by admin
//from "browse all" listing
							$result1=mysql_query("select tbl_document.id,tbl_document.doc_title, avg( distinct tbl_rating.score) as avg_score, date_format(tbl_document.post_date,'%M %e, %Y') as post_date,tbl_user.username,count(tbl_comment.id) as comment_rec from tbl_document inner join tbl_user on (tbl_document.posted_by=tbl_user.id) left join tbl_rating on (tbl_document.id=tbl_rating.document_id) left join tbl_comment on (tbl_document.id=tbl_comment.doc_id) where tbl_document.posted_by!=3 and tbl_document.status=1 $where group by tbl_document.id order by tbl_document.post_date desc limit $start ,$pagesize");
								$result=mysql_query("select tbl_document.id,tbl_document.doc_title,tbl_user.username from tbl_document inner join tbl_user on (tbl_document.posted_by=tbl_user.id) left join tbl_comment on (tbl_document.id=tbl_comment.doc_id) where tbl_document.status=1 $where group by tbl_document.id ");
							}
							$reccnt=mysql_num_rows($result);
							if($reccnt>0)
							{
								while($line=mysql_fetch_array($result1))
								{
								$bgcolor=="#D6EAF3"?$bgcolor="#ffffff":$bgcolor="#D6EAF3";
								?>

<a href="document_detail.php?doc_id=<?=$line[id]?>" style="font-size:12px"><?php echo $line[doc_title];?></a><br>
<strong>Posted By:</strong><?php echo ucwords($line[username]);?>
<br>
<strong>Posted On:</strong><?php echo ucwords($line[post_date]);?>
<br>
<strong>Comments:</strong><?php echo ucwords($line[comment_rec]);?>
<br>
<br>
<br>
							<?php 
								} ?>
							<tr><td colspan=2 width="50%"  align="center"><?php include("config/paging.inc.php"); ?></td></tr>
							<?php }
							else
							{
						?>
						<tr align="center">
						<td class="warning">no essays to show, yet</td>
						</tr>
						<?php }?>
						
						</table>
				  </div>

<br>
<br>
      <?php include("footer.inc.php")?>
   </div>
</body>
</html>