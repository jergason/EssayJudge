<?php session_start();
require_once("config/config.inc.php");
require_once("config/functions.inc.php");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="style.css" />
<title>Essay Judge - Writing Community for Peer Editing</title>
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

						<?php 
							$line=mysql_fetch_array(mysql_query("select tbl_user.id as id,tbl_user.city,tbl_user.zip,date_format(tbl_user.join_date,'%M, %D %Y') as join_date,tbl_user.about_me,date_format(tbl_user.last_activity,'%M, %D %Y') as last_activity,tbl_user.birthday,count(distinct tbl_document.id) as total_document,count(distinct tbl_comment.id) as total_comment,sum(distinct tbl_comment.score) as comment_points,state.name from tbl_user left join tbl_document on (tbl_document.posted_by=tbl_user.id and tbl_document.status=1) left join tbl_comment on (tbl_user.id=tbl_comment.comment_by_id) inner join state on (tbl_user.state=state.id)  where tbl_user.id=".$_GET[user_id]." group by tbl_user.id"));
							?>
      <div style="margin-top:15px;">
            <div style="border: 1px #999999 solid;margin-top:14px;margin-left:10px;width:212px;float:left;">
				<table style="padding:10px;width:210px;height:100%;border-spacing:0px;">
               <tr><td style="background-color:#D6EAF3;" class="black_txt">
				   <h3 style="color: #5C6A72;font-size:18px;font-weight:normal;padding-top:5px;text-align:left;margin-bottom:0px"><?php $get_user_name=mysql_fetch_array(mysql_query("select username from tbl_user where id=".$_GET[user_id]));?><?php echo ucfirst($get_user_name[0]);?></h3>
<br /><br />
               <?php echo ucfirst(nl2br($line[about_me]));?>
               </td></tr>
            </table>
            </div>
         <div style="margin-top:30px;margin-left:50px;text-align:left;float:left;" class="black_txt">
            <span class="bold">Member Since:</span><br />
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $line[join_date];?><br />
            <span class="bold">Last Login:</span><br />
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $line[last_activity];?>
         </div>
         <div style="float:left;margin-top:30px;margin-left:40px;" class="black_txt">
         <?php  $sql_comment=mysql_query("select count(tbl_comment.id) as cnt,sum(score) as score from tbl_comment inner join tbl_document on (tbl_comment.doc_id=tbl_document.id and tbl_comment.comment_by_id='".$_GET[user_id]."') inner join tbl_user on (tbl_document.posted_by=tbl_user.id)");
								$rs_comment=mysql_fetch_array($sql_comment);?>
            <div style="float:left;text-align:left">
               <span class="bold">Reputation Points:</span><br /><br>
               <span class="bold">Essays Posted:</span><br />
               <span class="bold">Comments Posted:</span><br />
            </div>
            <div style="float:left;margin-left:10px;text-align:right">
               <?php if($rs_comment[score]>0) { echo $rs_comment[score]; } else { echo "0";}?><br /><br>
               <?php echo $line[total_document];?><br />
               <?php echo $rs_comment[cnt];?><br />
            </div>
         </div>
         <div style="margin-top:30px;float:left;">
				<a href="user_documents.php?user_id=<?php echo $_GET[user_id]?>" alt="See User Documents" title="See User Documents"><img src="images/userdocs.jpg" style="clear:left;float:left;margin-left:50px;margin-right:10px;margin-bottom:10px;"></a>
				<a href="user_comments.php?user_id=<?php echo $_GET[user_id]?>" alt="See The User's Comments" title="See The User's Comments"><img src="images/usercomments.jpg" style="float:left;margin-right:10px;margin-bottom:10px;"></a>
         </div>
      </div>

<br clear=all>
<br><br>

      <?php include("footer.inc.php")?>
   </div>
</body>
</html>