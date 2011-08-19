<?php session_start();
require_once("config/config.inc.php");
require_once("config/functions.inc.php");
@extract($_POST);
if($_GET[plus_score]==1)
{
	if($_SESSION[uid])
	{
		
		$chk_user_id=mysql_fetch_array(executeQuery("select comment_by_id from tbl_comment where id=".$_GET[comment_id]));
		if($chk_user_id[0]==$_SESSION[uid])
		{
			$_SESSION['sess_msg']='You Cannot Rate Your Own Comments';
			header("Location: user_latest_comment.php?comment_id=".$_GET[comment_id]);
			exit();
		}
		$get_score=mysql_fetch_array(mysql_query("select score from tbl_comment where id=".$_GET[comment_id]));
		$scr=$get_score[0]+1;
		executeUpdate("update tbl_comment set score='".$scr."'where id=".$_GET[comment_id]);
		$_SESSION['sess_msg']='Comment Score Updated Sucessfully';
		header("Location: user_latest_comment.php?comment_id=".$_GET[comment_id]);
		exit();
	}
	else
	{
		$_SESSION['sess_msg']='You must be login to rate a Comment';
		header("Location: login.php?doc_detail=1");
		exit();
	}
}
if($_GET[minus_score]==1)
{
	if($_SESSION[uid])
	{
		$chk_user_id=mysql_fetch_array(executeQuery("select comment_by_id from tbl_comment where id=".$_GET[comment_id]));
		if($chk_user_id[0]==$_SESSION[uid])
		{
			$_SESSION['sess_msg']='You Cannot Rate Your Own Comments';
			header("Location: user_latest_comment.php?comment_id=".$_GET[comment_id]);
			exit();
		}
		$get_score=mysql_fetch_array(mysql_query("select score from tbl_comment where id=".$_GET[comment_id]));
		$scr=$get_score[0]-1;
		executeUpdate("update tbl_comment set score='".$scr."'where id=".$_GET[comment_id]);
		$_SESSION['sess_msg']='Comment Score Updated Sucessfully';
		header("Location: user_latest_comment.php?comment_id=".$_GET[comment_id]);
		exit();
	}
	else
	{
		$_SESSION['sess_msg']='You must be login to rate a Comment';
		header("Location: login.php?doc_detail=1");
		exit();
	}
}
?>


<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>EssayJudge</title>
<link href="style.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript">
function open_post_form()
{
	document.getElementById("post_comment").style.display=document.getElementById("post_comment").style.display=="none"?"":"none";
}
function close_form()
{
	document.getElementById("post_comment").style.display="none";
}
</script>
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
				   <table style="padding:10px;width:600px;border-spacing:0px;">
						<tr><td align="left" valign=top>
                  <div id="subheading"><?php $get_user_name=mysql_fetch_array(mysql_query("select username from tbl_user where id=".$_SESSION[uid]));?>Comments on your<?php /*echo $get_user_name[0];*/?> Essays</div></td><td align="right" class="blue_txt"></td>
                  </tr>
						


<?php 
$start=0;
if(isset($_GET['start'])) $start=$_GET['start'];
$pagesize=15;
if(isset($_GET['order_by'])) $order_by=$_GET['order_by'];
$order_by='tbl_comment.comment_date';
if(isset($_GET['order_by2'])) $order_by2=$_GET['order_by2'];
$order_by2='desc';
//$where=" and tbl_comment.id=".$_GET[comment_id];
$sql=executeQuery("select
tbl_comment.id,tbl_comment.comment,date_format(tbl_comment.comment_date,'%M %e, %Y') as comment_date,tbl_comment.score,tbl_document.doc_title,tbl_document.id as doc_id,tbl_user.username,tbl_user.id as user_id,count(distinct tbl_document.id) as total_document ,count( tbl_comment.id) as total_comment,sum(distinct tbl_comment.score) as comment_score from tbl_comment inner join tbl_user on (tbl_comment.comment_by_id=tbl_user.id ) inner join tbl_document on (tbl_comment.doc_id=tbl_document.id and tbl_document.posted_by='$_SESSION[uid]' and tbl_document.status=1) where 1=1   group by tbl_comment.id order by $order_by $order_by2 limit $start,$pagesize");
$reccnt=mysql_num_rows(executeQuery("select
tbl_comment.id,tbl_comment.comment,date_format(tbl_comment.comment_date,'%M %e, %Y') as comment_date,tbl_comment.score,tbl_document.doc_title,tbl_document.id as doc_id,tbl_user.username,tbl_user.id as user_id,count(distinct tbl_document.id) as total_document ,count( tbl_comment.id) as total_comment,sum(distinct tbl_comment.score) as comment_score from tbl_comment inner join tbl_user on (tbl_comment.comment_by_id=tbl_user.id ) inner join tbl_document on (tbl_comment.doc_id=tbl_document.id and tbl_document.posted_by='$_SESSION[uid]' and tbl_document.status=1) where 1=1   group by tbl_comment.id"));
?>
						<?php if($reccnt>0)
							{
								while($line=mysql_fetch_array($sql))
								{
                        $bgcolor=="#D6EAF3"?$bgcolor="#ffffff":$bgcolor="#D6EAF3";
						?>
                     <tr>
							<td colspan=2 style="padding:10px" class="black_txt">
                        <div style="float:left;width:250px">
                           <span class="bold">Essay:</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="document_detail.php?doc_id=<?php echo $line[doc_id]?>" style="font-size:12px"><?php echo $line[doc_title];?></a><br />
									<span class="bold">Comment By:</span>&nbsp;&nbsp;<a href="user_profile.php?user_id=<?=$line[user_id]?>" style="font-size:12px"><?php echo ucwords($line[username]);?></a>
                        </div>
                        <div style="float:left;">
                           <span class="bold">Posted:</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $line[comment_date];?><br />
                           <span class="bold">Comment Rating:</span>&nbsp;&nbsp;<?php if($line[comment_score]>0) {echo "+".$line[comment_score];}else{echo $line[comment_score];} ?>
                        </div>
                        <div style="clear:left">
                        <span class="bold">Comment:</span>
									<p style="text-indent:20px;margin:0"><?php echo ucfirst(nl2br($line[comment]));?>
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
						<td class="warning">no comments yet!</td>
						</tr>
						<?php }?>
						
						</table>
				  </div>
      <?php include("footer.inc.php")?>
   </div>
</body>
</html>

