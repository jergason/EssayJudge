<?php session_start();
require_once("config/config.inc.php");
require_once("config/functions.inc.php");
// @extract($_POST);
$where=" and tbl_document.id=".$_GET['doc_id'];
$line=mysql_fetch_array(mysql_query("select tbl_document.id,tbl_document.doc_title,tbl_document.keywords,tbl_document.doc_title,tbl_document.post_date,tbl_document.doc_path,tbl_document.doc_content,tbl_user.username,tbl_user.id as user_id,count(distinct tbl_comment.id) as total_comment,sum( distinct tbl_comment.score) as comment_point,avg( distinct tbl_rating.score) as avg_score from tbl_document inner join tbl_user on (tbl_document.posted_by=tbl_user.id) left join tbl_comment on (tbl_document.id=tbl_comment.doc_id) left join tbl_rating on (tbl_document.id=tbl_rating.document_id) where 1=1 and tbl_document.id='$_GET[doc_id]'  group by tbl_document.id"));


function update_score($up_or_down) {
  if($_SESSION['uid']) {
    $sql = sprintf("select comment_by_id from tbl_comment where id=%s", mysql_real_escape_string($_GET['comment_id']));
    $chk_user_id=mysql_fetch_array(executeQuery($sql));
    if($chk_user_id[0]==$_SESSION['uid']) {
      //$_SESSION['sess_msg']='You Cannot Rate Your Own Comment';
      header("Location: document_detail.php?doc_id=".$_GET['doc_id']);
      exit();
    }

    $sql = sprintf("select id from tbl_comment_chk where comment_id=%s and user_id=%s",
      mysql_real_escape_string($_GET['comment_id']), mysql_real_escape_string($_SESSION['uid']));
    $chk_comment_posted=mysql_num_rows(mysql_query($sql));
    if($chk_comment_posted>0) {
      //$_SESSION['sess_msg']='Already rated comment';
      header("Location: document_detail.php?doc_id=".$_GET['doc_id']);
      exit();
    }

    $sql = sprintf("select score from tbl_comment where id=%s", mysql_real_escape_string($_GET['comment_id']));
    $get_score=mysql_fetch_array(mysql_query($sql));
    if ($up_or_down == "up") {
      $scr=$get_score[0] + 1;
    }
    elseif ($up_or_down == "down") {
      $scr=$get_score[0] - 1;
    }
    else {
      $scr = $get_score[0];
    }

    $sql = sprintf("update tbl_comment set score='%s' where id=%s",
      mysql_real_escape_string($scr), mysql_real_escape_string($_GET['comment_id']));
    executeUpdate($sql);

    $sql = sprintf("insert into tbl_comment_chk set comment_id=%s, user_id=%s",
      mysql_real_escape_string($_GET['comment_id']), mysql_real_escape_string($_SESSION['uid']));
    executeUpdate($sql);
    //$_SESSION['sess_msg']='Comment Score Updated Sucessfully';
    header("Location: document_detail.php?doc_id=".$_GET['doc_id']);
    exit();
  }
  else {
    //$_SESSION['sess_msg']='You must login to post a comment';
    header("Location: login.php?doc_detail=1");
    exit();
  }

}

if($_GET['plus_score']==1) {
  update_score("up");
}
elseif($_GET['minus_score']==1) {
  update_score("down");
}

if($_POST[post_comment]=='yes') {


  if($_SESSION[uid]) {
    $get_user_id=mysql_fetch_array(mysql_query("select posted_by from tbl_document where id=".$doc_id));
    if (preg_match("/([\<])([^\>]{1,})*([\>])/i", $comment)) {
      //$_SESSION['sess_msg']='You Cannot Post Html In Your Comment';
      header("Location: document_detail.php?doc_id=".$doc_id);
      exit();
    }
    executeQuery("insert into tbl_comment set comment='$comment',doc_id='$doc_id',comment_by_id=".$_SESSION['uid'].",comment_date=now(),score=0");
    //$_SESSION['sess_msg']='Your Comment Added Successfully';
    header("Location: document_detail.php?doc_id=".$doc_id);
    exit();
  }
  else {
    //$_SESSION['ses_msg']='You must be login to post a comment';
    header("Location: login.php?doc_detail=1");
    exit();
  }
}

if($_POST[rpt_flag]=='yes') {
  if($_SESSION[uid]) {
    $get_user_id=mysql_fetch_array(mysql_query("select posted_by from tbl_document where id=".$doc_id));

    if($get_user_id[0]==$_SESSION['uid']) {
      //$_SESSION['sess_msg']='You are reporting your own document';
      header("Location: document_detail.php?doc_id=".$doc_id);
      exit();
    }
    if (preg_match("/([\<])([^\>]{1,})*([\>])/i", $comment)) {
      //$_SESSION['sess_msg']='You Cannot Post Html here';
      header("Location: document_detail.php?doc_id=".$doc_id);
      exit();
    }
    executeQuery("insert into tbl_flag set reason='$reason',document_id='$doc_id',user_id=".$_SESSION['uid'].",flag_date=now()");
    //$_SESSION['sess_msg']='Your Flag Added Successfully';
    header("Location: document_detail.php?doc_id=".$doc_id);
    exit();
  }
  else {
    //$_SESSION['ses_msg']='You must login to Flag a Document';
    header("Location: login.php?doc_detail=1");
    exit();
  }
}

$doc_id=$_REQUEST['doc_id'];
$rating_query1=mysql_query("select * from tbl_rating where document_id='$doc_id' and user_id='".$_SESSION['uid']."' ");
$result_rating1=mysql_num_rows($rating_query1);

if($result_rating1>0) {
  $_SESSION['sess_msg']="You have already rated this document.";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?=ucwords($line[doc_title])?> - EssayJudge</title>
<META NAME="Keywords" CONTENT="<?php echo $line[keywords]?>">
<META NAME="Description" CONTENT="<?=ucwords($line[doc_title])?> - Free Essay Reviews.">
<script language="javascript" type="text/javascript">
function open_post_form(val)
{
  document.getElementById(val).style.display=document.getElementById(val).style.display=="none"?"":"none";
}
function close_form(val)
{
  document.getElementById(val).style.display="none";
}
function validate_flag_form(obj)
{
  var msg='Incomplete!\n\n', flag=false;
  if(obj.reason.value == '') msg+='- Please enter reason for flag. \n';
  if(msg == 'Incomplete!\n\n')
    return true;
  else{
    alert(msg);
    return false;
  }	
}
function validate_postcmt_form(obj)
{
  var msg='Incomplete!\n\n', flag=false;
  if(obj.comment.value.length<20) msg+='Your comment is too short. \n';
  if(obj.comment.value.substr(1,6)=='Please') msg+='Please enter a comment. \n';
  if(msg == 'Incomplete!\n\n')
    return true;
  else{
    alert(msg);
    return false;
  }	
}
</script>
<link rel="stylesheet" type="text/css" href="style.css" />
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
</center>

<center><div style="width:720px;background-color:#D6EAF3;border: 1px #999999 solid;color:#5C6A72;margin-bottom:0px;font-size:15px;font-weight:bold;padding:2px;">

<br><big>New: Have Your Essay Reviewed by an Expert for Free</big>
<br> <br>
<a href="http://www.essayjudge.com"><font size="4">Click Here to Get Started!</font></a>
<br>
<br>
Please click Like to share with other students <br><br> <iframe src="http://www.facebook.com/plugins/like.php?href=www.essayjudge.com&amp;send=true&amp;layout=standard&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=verdana&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:35px;" allowTransparency="true"></iframe><br>
</div></center>
<br>
      <table class="content">
         <tr>
            <td></center>

<br>
<br>   
<center>
<span class="essayTitle"><?php echo htmlentities(ucwords($line[doc_title]));?></span></center>
<br />

<br>
<br>
            <div class="essaydisp"><div class="essaycont"><?php echo nl2br(htmlentities(($line['doc_content'])));?>

<br><br><center><small>Submitted by:</small><span class="essayAuthor"><?php echo htmlentities($line['username']);?></span></center>
               <?php $authorname = $line['username']; $authorid = $line['user_id']; ?>
              </div></div>
                  <br /><div style="margin-left:20px"><a href="javascript:void(0);" style="text-decoration:none;text-style:oblique" onClick="open_post_form('k_list');">&lt;Keywords&gt;</a><span id="k_list" style="display:none">&nbsp;&nbsp;&nbsp;<?php echo htmlentities($line['keywords']);?></span></div>
                  <br />

<iframe src="http://www.facebook.com/plugins/like.php?href=www.essayjudge.com&amp;send=true&amp;layout=standard&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=verdana&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:35px;" allowTransparency="true"></iframe>

<br>
<!--COMMENTS BOX START-->
<?php 
$start=0;
if(isset($_GET['start'])) $start=$_GET['start'];
$pagesize=50;
if(isset($_GET['order_by'])) $order_by=$_GET['order_by'];
$order_by='comment_score';
if(isset($_GET['order_by2'])) $order_by2=$_GET['order_by2'];
$order_by2='desc';
$where=" and doc_id='$_GET[document_id]'";
$sql=executeQuery("select
  tbl_comment.id,tbl_comment.comment,date_format(tbl_user.join_date,'%b %D, %Y') as join_date,date_format(tbl_comment.comment_date,'%M,%d %Y') as comment_date,tbl_comment.score,tbl_user.username,tbl_user.id as user_id,count(distinct tbl_document.id) as total_document ,count( tbl_comment.id) as total_comment,sum(distinct tbl_comment.score) as comment_score from tbl_comment inner join tbl_user on (tbl_comment.comment_by_id=tbl_user.id and tbl_comment.doc_id='$_GET[doc_id]') left join tbl_document on (tbl_comment.comment_by_id=tbl_document.posted_by and tbl_document.status=1) group by tbl_comment.id  order by $order_by $order_by2");
$reccnt=mysql_num_rows($sql);
?>
<a name="Comments"></a>
<?php if($reccnt<=0)
{?>
<h3>There are no comments for this Document.</h3>
<?php }
else
{?>
<h3>Comments</h3>
<table class="comments" style="border:1px solid #666666">
<?php for($k = 0; $line=mysql_fetch_array($sql); $k++)
{
?>
<!--ONE MSG BEGINS-->
                  <tr>
                     <td class="commentUser" style="text-align:center;background-color:<?php if($k%2==0){echo '#F2F2F2';}else{echo '#D2D2D2';}?>;padding-top:7px;border-bottom:1px solid #666666;border-right:1px solid #666666" rowspan=2>
<?php if ($authorid==$line[user_id]){ ?>
<i>Author:</i><br>
<?php } ?>
                        <a href="user_profile.php?user_id=<?php echo($line['user_id']); ?>" style="line-height:28px;font-size:12px"><?php echo ucwords($line['username']);?></a>
<br />

<?php  $sql_comment=mysql_query("select count(tbl_comment.id) as cnt,sum(score) as score from tbl_comment inner join tbl_document on (tbl_comment.doc_id=tbl_document.id and tbl_comment.comment_by_id='".$line['user_id']."') inner join tbl_user on (tbl_document.posted_by=tbl_user.id)");
$rs_comment=mysql_fetch_array($sql_comment);?>
                        <span style="font-size:10px;font-style:italic;line-height:15px"><?php if($rs_comment['score']>0) { echo "+".$rs_comment['score']; } else { echo "0";}?> <br />Reputation Points</span>



                        <br /><span style="font-weight:bolder;font-style:italic;margin-left:-25px;font-size:10px">Member Since</span><div class="bgstatspace nodec" style="font-size:10px;margin-left:5px;font-style:italic"><?php echo $line['join_date'] ?></div>
                     </td>
                     <td class="commentMsg" style="padding:5px;background-color:<?php if($k%2==0){echo '#F2F2F2';}else{echo '#D2D2D2';}?>;font-size:10px;">
                        <?php echo nl2br(htmlentities(ucfirst($line['comment'])));?>
                     </td>
                  </tr>
                  <tr>
                     <td style="padding:5px;vertical-align:bottom;background-color:<?php if($k%2==0){echo '#F2F2F2';}else{echo '#D2D2D2';}?>;font-size:10px;border-bottom:1px solid #666666">
                     <div style="float:right;font-style:italic"><?php echo $line['comment_date'];?></div><br/>
                     <div style="background-color:#666666;height:1px;width:99.999%;"></div>

<?php if ($authorid!=$line['user_id']){ ?>
<?php if ($line['user_id']!=$_SESSION['uid']){ ?>

                        <div style="float:right;font-style:italic;margin-top:7px;">
<?php if($_SESSION['uid']!=''){$comment_query1=mysql_query("select id from tbl_comment_chk where comment_id='".$line['id']."' and user_id=".$_SESSION['uid']);
$result_comment1=mysql_num_rows($comment_query1); }?>
                        <?php if($result_comment1==0){?>                        Rate Comment: <a href="document_detail.php?minus_score=1&comment_id=<?php echo($line['id']); ?>&doc_id=<?php echo($_GET['doc_id']);?>"><img src="images/minuscomment.gif" style="border:0;margin-left:2px"></a><a href="document_detail.php?plus_score=1&comment_id=<?php echo($line['id']); ?>&doc_id=<?php echo($_GET['doc_id']); ?>"><img src="images/pluscomment.gif" style="border:0;margin-left:4px"></a>
                        <?php }else{ ?>Already Rated Comment<?php }?>
</div>

<?php } ?>

                        <div style="font-style:italic;margin-top:7px">Comment Rating: <?php if($line['comment_score']>0) {echo "+".$line['comment_score'];}else{echo $line['comment_score'];} ?></div>
<?php } ?>
                     </td>
                  </tr>
<?php
}?>
</table>
<?php
}?>
<!--COMMENTS BOX END-->
<?php $sql_status=mysql_query("select status from tbl_user where id='".$_SESSION['uid']."'");
$result=mysql_fetch_array($sql_status);
if($result['status']==1){?>
<form name="postcmt" action="document_detail.php" method="post" onSubmit="return validate_postcmt_form(this)">
<input type="hidden" name="post_comment" value="yes">
<input type="hidden" name="doc_id" value="<?=$_GET[doc_id]?>">
<table style="margin-left:auto;margin-right:auto;margin-bottom:170px;width:535px">
   <tr>
      <td style="width:120px;margin-left:5px"><a href="javascript:void(0);" onClick="open_post_form('postC_form');" style="font-size:12px">Post Comment</a></td>
   </tr>
   <tr>
      <td style="width:425px;text-align:right;margin-left:5px;" valign=top><div id="postC_form" style="display:none;"><textarea name="comment" rows="4" cols="70" class="commentbox" onfocus="this.value=''; this.onfocus=null;">Please post helpful, specific comments here. (Min. length: 50 characters).
</textarea>
      <br />
      <input type="submit" value="Submit"></div>
      </td>
   </tr>
</table>
</form>


<?php }else{ ?>

<table style="margin-left:auto;margin-right:auto;margin-bottom:170px;width:535px">
   <tr>
      <td style="width:120px;margin-left:5px"><a href="http://www.essayjudge.com/login.php">Log In</a> to post a comment.</td>
   </tr>
</table>


<?php } ?>

</td>

<?php $line=mysql_fetch_array(mysql_query("select tbl_document.id,tbl_document.doc_title,tbl_document.keywords,date_format(tbl_user.join_date,'%b %D, %Y') as join_date,date_format(tbl_user.last_activity,'%b %D, %Y') as last_activity, tbl_document.doc_title,date_format(tbl_document.post_date,'%b %D, %Y') as postDate, tbl_document.post_date,tbl_document.doc_path,tbl_document.doc_content,tbl_user.username,tbl_user.id as user_id,count(distinct tbl_comment.id) as total_comment,sum( distinct tbl_comment.score) as comment_point,count( distinct tbl_rating.score) as numVotes,avg( distinct tbl_rating.score) as avg_score from tbl_document inner join tbl_user on (tbl_document.posted_by=tbl_user.id) left join tbl_comment on (tbl_document.id=tbl_comment.doc_id) left join tbl_rating on (tbl_document.id=tbl_rating.document_id) where 1=1 and tbl_document.id='$_GET[doc_id]'  group by tbl_document.id"));?>
<td>
<br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br>


<div style="width:160px;background-color:#D6EAF3;border: 1px #999999 solid;color:#5C6A72;margin-bottom:0px;font-size:18px;font-weight:bold;padding:2px;">
<center>
<br>Post Your Essay<br><br>on<br><br><br>
<a href="http://www.essayjudge.com"><font size="3">EssayJudge.Com</font></a> <br><br><br><br>And get a<br><br>Free Essay Review<br><br>
from an expert<br><br>
<a href="http://www.essayjudge.com/register.php"><font size="4">Get Started Now!</font></a> <br><br><br>
It's Free. <br><br>It's Easy. <br><br>It Helps.
<br><br>
<br>
</center>
</div> 


<br><br><br><br><br><br><br><br>

<!--
               <div class="essayinfo">
                  <span class="essayrating"><?php echo sprintf("%01.2f",$line['avg_score']);?></span>
                  <div class="essaystats"><div class="smstatspace"><? echo $line['numVotes']; ?> Votes</div><img src="images/statsbar.gif"><div class="smstatspace">Posted on</div><div class="bgstatspace"><? echo $line[postDate]; ?></div><img src="images/statsbar.gif"><center><span class="statslink"><a href="#Comments"><?php echo $line[total_comment];?> Comments</a></span></center>
                  </div>
               </div>
               <br />
-->

               <div class="authorinfo"><a href="user_profile.php?user_id=<?php echo $authorid;?>" class="authorTitlelink"><?php echo $authorname;?></a>

<?php
  $sql = sprintf("select tbl_user.id as id,tbl_user.city,tbl_user.zip,
    date_format(tbl_user.join_date,'%M, %D %Y') as join_date,
    tbl_user.about_me,date_format(tbl_user.last_activity,'%M, %D %Y') as last_activity,
    tbl_user.birthday,count(distinct tbl_document.id) as total_document,
    count(distinct tbl_comment.id) as total_comment,sum(distinct tbl_comment.score) as comment_points, state.name
    from tbl_user
    left join tbl_document on (tbl_document.posted_by=tbl_user.id and tbl_document.status=1)
    left join tbl_comment on (tbl_user.id=tbl_comment.comment_by_id)
    inner join state on (tbl_user.state=state.id)
    where tbl_user.id='%s' group by tbl_user.id",
    mysql_real_escape_string($authorid));
  $line=mysql_fetch_array(mysql_query($sql));
?>

<?php
$sql = sprintf("select count(tbl_comment.id) as cnt,sum(score) as score
  from tbl_comment
  inner join tbl_document on (tbl_comment.doc_id=tbl_document.id and tbl_comment.comment_by_id='%s')
  inner join tbl_user on (tbl_document.posted_by=tbl_user.id)",
  mysql_real_escape_string($authorid));

$sql_comment=mysql_query($sql);
$rs_comment=mysql_fetch_array($sql_comment);?>

<div class="userstats" style="line-height:14px"><center>Comments Posted:<br /><?php echo htmlentities($rs_comment['cnt']);?> </center><br>

<center>Essays Posted:<br /><?php echo htmlentities($line['total_document']);?> </center><br>



<center>Reputation Points:<br /><?php /*$get_user_comment_point=mysql_fetch_array(mysql_query("select sum(score) from tbl_comment where doc_id=".$_GET[doc_id]));*/
$sql_comment=mysql_query("select count(tbl_comment.id) as cnt,sum(score) as score from tbl_comment inner join tbl_document on (tbl_comment.doc_id=tbl_document.id and tbl_comment.comment_by_id='".$authorid."') inner join tbl_user on (tbl_document.posted_by=tbl_user.id)");
$rs_comment=mysql_fetch_array($sql_comment);
if($rs_comment['score']>0) { echo "+".htmlentities($rs_comment['score']); } else { echo "0";}
                /*if($get_user_comment_point[0]>0){echo $get_user_comment_point[0]; } else
                {
                  echo "0";
                }
                 */?> </center><br><span class="underline">Member Since</span><div class="bgstatspace nodec" style="line-height:14px"><? echo $line['join_date']; ?></div><br><span class="underline">Recent Activity</span><br /><div class="bgstatspace nodec" style="line-height:14px"><? echo htmlentities($line['last_activity']); ?></div><br><a href="user_profile.php?user_id=<?php echo htmlentities($authorid);?>">About <?php echo htmlentities($authorname);?></a><br /><br />
                   </div>
                   </div>
                   <div class="rightetc" style="background-color:white"><br />
                   <?php if($_SESSION['uid']){?>
                   <a href="javascript:void(0);" onClick="open_post_form('rep_flag');"><?php }else{?><a href="login.php?back=<?php echo $_SERVER['PHP_SELF'];?>?<?php echo $_SERVER['QUERY_STRING'];?>"><?php }?><img src="images/flagdoc.gif"></a></div>
                   <div id="rep_flag" style="display:none">
                   <form name="rptflag" action="document_detail.php" method="post" onSubmit="return validate_flag_form(this)">
                   <input type="hidden" name="rpt_flag" value="yes">
                   <input type="hidden" name="doc_id" value="<?=$_GET['doc_id']?>">
                   Reason:<br />
                   <textarea name="reason" rows="10" cols="15" class="input_box"></textarea>
                   <br clear=all>
                   <input type="submit" value="Submit">

                   </form>
                   </div>

                   <br>
                   </div>
                   </td>
                   </tr>
                   </table>
                   <iframe src="http://www.facebook.com/plugins/like.php?href=www.essayjudge.com&amp;send=true&amp;layout=standard&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=verdana&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:35px;" allowTransparency="true"></iframe>

                   <br>
                   <?php include("footer.inc.php")?>
                   </div>
                   </body>
                   </html>
