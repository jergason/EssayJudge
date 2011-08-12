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
			$_SESSION['sess_msg']='You Cannot Rate Your Own Comment';
			header("Location: comments.php?comment_id=".$_GET[comment_id]);
			exit();
		}
		$get_score=mysql_fetch_array(mysql_query("select score from tbl_comment where id=".$_GET[comment_id]));
		$scr=$get_score[0]+1;
		executeUpdate("update tbl_comment set score='".$scr."'where id=".$_GET[comment_id]);
		$_SESSION['sess_msg']='Comment Score Updated Sucessfully';
		header("Location: comments.php?comment_id=".$_GET[comment_id]);
		exit();
	}
	else
	{
		$_SESSION['sess_msg']='You must be login to point a Comment';
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
			$_SESSION['sess_msg']='You Cannot Rate Your Own Comment';
			header("Location: comments.php?comment_id=".$_GET[comment_id]);
			exit();
		}
		$get_score=mysql_fetch_array(mysql_query("select score from tbl_comment where id=".$_GET[comment_id]));
		$scr=$get_score[0]-1;
		executeUpdate("update tbl_comment set score='".$scr."'where id=".$_GET[comment_id]);
		$_SESSION['sess_msg']='Comment Score Updated Sucessfully';
		header("Location: comments.php?comment_id=".$_GET[comment_id]);
		exit();
	}
	else
	{
		$_SESSION['sess_msg']='You must be login to point a Comment';
		header("Location: login.php?doc_detail=1");
		exit();
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>EssayJudge</title>
<!--
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
<link href="css/style.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript">
-->
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
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
        <?php include("header.inc.php")?>
        </tr>
        <tr>
          <td align="center" valign="top"><?php include("left.inc.php")?></td>
          <td width="600" align="center" valign="top"><table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
              <tr align="left" valign="top">
                      <td colspan="3" align="left" class="blue_txt" height="30"><img src="images/welcome_txt.gif"></td>
              </tr>
				    <tr>
                      <td width="9" height="9" align="right" valign="top"><img src="images/box_left_upper.gif" width="9" height="9"></td>
                      <td width="577" align="left" valign="top" background="images/box_upper_bg.gif" style="background-repeat:repeat-x; background-position:top; "><img src="images/box_upper_bg.gif" width="9" height="9"></td>
                      <td width="14" height="9" align="left" valign="top"><img src="images/box_right_upper.gif" width="14" height="9"></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top" background="images/box_left_bg.gif" style="background-repeat:repeat-y; background-position:right; "><img src="images/box_left_bg.gif" width="9" height="2"></td>
                      <td align="center" valign="top">
				 		<table width="100%">
						<?php 
							if($_SESSION['sess_msg']!='')
							{
						?>
						<tr align="center">
						<td class="warning">
						<?php echo $_SESSION['sess_msg'];$_SESSION['sess_msg']='';?>
						</td>
						</tr>
						<?php }?>
<?php 
$start=0;
if(isset($_GET['start'])) $start=$_GET['start'];
$pagesize=50;
if(isset($_GET['order_by'])) $order_by=$_GET['order_by'];
$order_by='id';
if(isset($_GET['order_by2'])) $order_by2=$_GET['order_by2'];
$order_by2='asc';
$where=" and tbl_comment.id='.$_GET[comment_id]'";
$sql=executeQuery("select
tbl_comment.id,tbl_comment.comment,date_format(tbl_comment.comment_date,'%M,%d %Y') as comment_date,tbl_comment.score,tbl_user.username,tbl_user.id as user_id,count(distinct tbl_document.id) as total_document ,count( tbl_comment.id) as total_comment,sum(distinct tbl_comment.score) as comment_score from tbl_comment inner join tbl_user on (tbl_comment.comment_by_id=tbl_user.id ) left join tbl_document on (tbl_comment.comment_by_id=tbl_document.posted_by) where 1=1  $where group by tbl_comment.id ");
$reccnt=mysql_num_rows($sql);
?>
						<?php if($reccnt>0)
							{
								while($line=mysql_fetch_array($sql))
								{
						?>
						<tr>
							<td>
								<table width="100%" style="border:1px solid #000000; ">
									<tr class="greyrow">
									<td class="big_black_txt">
									Comment By:&nbsp;<a href="user_profile.php?user_id=<?=$line[user_id]?>" class="whitelink"><?php echo ucwords($line[username]);?></a>&nbsp;(&nbsp; <a href="user_documents.php?user_id=<?=$line[user_id]?>" class="whitelink"><?php echo $line[total_document]?>&nbsp;Documents</a>,&nbsp;<a href="user_comments.php?user_id=<?=$line[user_id]?>" class="whitelink"><?php /* echo $line[total_comment] */
									$count_comment=mysql_num_rows(executeQuery("select tbl_comment.id from tbl_comment inner join tbl_document on (tbl_comment.doc_id=tbl_document.id and tbl_document.posted_by=".$line[user_id].") "));
									echo $count_comment;
									?>&nbsp;Comments</a>,&nbsp;<?php echo $line[comment_score];?>&nbsp;Comment Points)<br>
									Posted&nbsp;<?php echo $line[comment_date];?>
									</td>
									</tr>
									<tr>
									<td><table width="100%"><tr>
									<td class="black_txt">
									<?php echo ucfirst(nl2br($line[comment]));?>
									</td>
									<td align="right">
									<span class="blue_txt">Rate this comment:</span>&nbsp;<span><a href="comments.php?plus_score=1&comment_id=<?=$line[id]?>"><img src="images/thumps_up.jpg" border="0"></a></span>&nbsp;<span><a href="comments.php?minus_score=1&comment_id=<?=$line[id]?>"><img src="images/thumps_down.jpg" border="0"></a></span>
									</td>
									</tr></table></td>
									</tr>
								</table>
							</td>
						</tr>
						<?php 
							}
						}
							else
							{
						?>
						<tr>
						<td class="warning">
						No Comments Received For This Document 
						</td>
						</tr>
						<?php }?>
						</table>
				  </td>
				<td align="left" valign="top" background="images/box_right_bg.gif"><img src="images/box_right_bg.gif" width="14" height="3"></td>
                    </tr>
					<tr>
                      <td width="9" height="16" align="right" valign="top"><img src="images/box_left_bottom.gif" width="9" height="16" vspace="0" hspace="0"></td>
                      <td align="left" valign="top" background="images/box_bottom_bg.gif"><img src="images/box_bottom_bg.gif" width="9" height="16"></td>
                      <td width="14" height="16" align="left" valign="top"><img src="images/box_right_bottom.gif" width="14" height="16"></td>
                    </tr>
           
          </table></td>
          <td width="250" align="right" valign="top" style="padding-right:16px; "></td>
        </tr>
    </table></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
     <?php include("footer.inc.php")?>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="top">&nbsp;</td>
   
  </tr>
</table>
</body>
</html>
