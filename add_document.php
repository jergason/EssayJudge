<?php 
session_start();
require_once("config/config.inc.php");
require_once("config/functions.inc.php");
@extract($_REQUEST);
if($_SESSION['uid'])
{
$id=$_SESSION['uid'];
}
else
{
$id='';
}
if ($_POST['SubmitForm'] == 'yes')
{	
		if($_FILES['doc_path']['size']>0)
		{
			$doc_path1=date('Ydms')."_".$_FILES['doc_path']['name'];
			move_uploaded_file($_FILES['doc_path']['tmp_name'],'uploaded_document/'.$doc_path1);
		}
		if($doc_id==''){
		$sql = "insert into tbl_document set doc_title='$title',keywords='$keyword',doc_path='$doc_path1',posted_by=".$_SESSION[uid].",post_date=now(),doc_content='$doc_content',status=1";	
		executeUpdate($sql);
		$_SESSION['sess_msg']='Your essay has been added sucessfully.';
		}else{
		$sql_update="update tbl_document set doc_title='$title',keywords='$keyword',doc_content='$doc_content' where id=$doc_id ";	
		executeUpdate($sql_update);
		$_SESSION['sess_msg']='Your essay has been updated sucessfully.';
		}
		header("Location: my_account.php");
		exit();
}
if($doc_id){
$sql_document=mysql_query("select * from tbl_document where id=$doc_id");
$result_document=mysql_fetch_array($sql_document);
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>EssayJudge</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<script language="javascript" type="text/javascript">
function trim(s) {
  while (s.substring(0,1) == ' ') {
    s = s.substring(1,s.length);
  }
  while (s.substring(s.length-1,s.length) == ' ') {
    s = s.substring(0,s.length-1);
  }
  return s;
}
function validEmailAddress(email)
{
		invalidChars = " /:,;~"
		if (email == "") 
		{
			return (false);
		}
		for (i=0; i<invalidChars.length; i++) 
		{
			badChar = invalidChars.charAt(i)
			if (email.indexOf(badChar,0) != -1) 
			{
				return (false);
			}
		}
		atPos = email.indexOf("@",1)
		if (atPos == -1) 
		{
			return (false);
		}
		if (email.indexOf("@",atPos+1) != -1) 
		{
			return (false);
		}
		periodPos = email.indexOf(".",atPos)
		if (periodPos == -1) 
		{
			return (false);
		}
		if (periodPos+3 > email.length)	
		{
			return (false);
		}
			
		return (true);
}

function validForm(obj)
{
	
	var msg='Incomplete data!\n\n';
	if(obj.title.value == '') msg+='- Please enter Essay Title. \n';
	if(obj.doc_content.value == '')	msg+='- Please Copy & Paste Essay Content. \n';
	if(msg == 'Incomplete data!\n\n')
		return true;
	else{
		alert(msg);
		return false;
	}
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

				 <form action="add_document.php" method="post" enctype="multipart/form-data" name="frm" onsubmit="return validForm(this)">
				<input type="hidden" name="SubmitForm" value="yes">
				<input type="hidden" name="doc_id" value="<?php echo $_REQUEST['doc_id']?>">	
            
<div style="border: 1px #999999 solid;margin-top:14px;margin-bottom:25px;width:560px;">
				<table cellpadding="4" style="padding:10px;width:540px;border-spacing:0px;color:#5C6A72;">
				<tr>
<?

					$line=mysql_fetch_array(mysql_query("select tbl_user.id as id,tbl_user.city,tbl_user.zip,date_format(tbl_user.join_date,'%M, %D %Y') as join_date,tbl_user.about_me,date_format(tbl_user.last_activity,'%M, %D %Y') as last_activity,tbl_user.birthday,count(distinct tbl_document.id) as total_document,count(distinct tbl_comment.id) as total_comment,sum(distinct tbl_comment.score) as comment_points,state.name from tbl_user left join tbl_document on (tbl_document.posted_by=tbl_user.id and tbl_document.status=1) left join tbl_comment on (tbl_user.id=tbl_comment.comment_by_id) inner join state on (tbl_user.state=state.id)  where tbl_user.id=".$id." group by tbl_user.id"));
							

   $sql_comment=mysql_query("select count(tbl_comment.id) as cnt,sum(score) as score from tbl_comment inner join tbl_document on (tbl_comment.doc_id=tbl_document.id and tbl_comment.comment_by_id='".$id."') inner join tbl_user on (tbl_document.posted_by=tbl_user.id)");
								$rs_comment=mysql_fetch_array($sql_comment);





$essays=$line[total_document];
$comments=$rs_comment[cnt];
$required=0;
/*
Set the value of $required to determine the number of comments
user must submit per essay prior to submitting an essay. If $required is greater than zero, and the user has not submitted the required number of comments, the user will get a warning notice
*/
$tessays=$essays*$required;

$allow=$comments-$tessays;

$left=$required-$allow;

if($allow<$required){
?>


<td style="padding-bottom:15px;background: url(/images/menubot.jpg) 0 100% no-repeat;"><img src="images/noadd.gif" style="margin-left:10px;float:left;margin-right:20px;"><h3 style="float:left;color: #5C6A72;font-size:18px;font-weight:normal;">Submit Essay</h3><?php /*print $_SESSION['sess_msg']; session_unregister('sess_msg');*/ $sess_msg='';?></td>
				</tr>

				<tr>
				<td>
				<h3>Please contribute to the community before posting your essay</h3>
<br><BR>
You must <b>comment on <? echo $required ?> essays for every essay that you post</b>
<br><BR>
Please go comment on <? echo $required ?> of the <a href="search_result.php">recently submitted essays</a> and then come back.
<br><br><br><br>
You have <? echo $comments ?> comment(s) and <? echo $essays ?> essay(s), so you will want to post comments on <? echo $left ?> more essay(s).


				</td>
				</tr>
				



<? }else{ ?>
            <td colspan=2 style="padding-bottom:15px;background: url(/images/menubot.jpg) 0 100% no-repeat;"><img src="images/adddoc.gif" style="margin-left:10px;float:left;margin-right:20px;"><h3 style="float:left;color: #5C6A72;font-size:18px;font-weight:normal;">Submit Essay</h3><?php /*print $_SESSION['sess_msg']; session_unregister('sess_msg');*/ $sess_msg='';?></td>
				</tr>




				<tr>
				<td width="200px"  align="right" class="black_txt" style="padding-top:25px;background-color:#D6EAF3;">Your Essay Title <span class="orange_txt"></span></td>
				<td  align="left" style="padding-top:25px"><input type="text" name="title" value="<?php echo ucwords($result_document['doc_title']);?>" size="58"   class="input_box">
				</td>
				</tr>
				
				<tr>
				<td width="200px"  align="right" class="black_txt" style="background-color:#D6EAF3;">Copy &amp; Paste Essay<span class="orange_txt"></span></td>
				<td  align="left"><textarea name="doc_content" rows="20" cols="60" class="input_box"><?php echo $result_document['doc_content'];?></textarea>
				</td>
				</tr><br><br>

<!-- The following code produces a keyword box in the submit form. It is currently disabled.

<tr>
				<td width="200px"  align="right" class="black_txt" style="background-color:#D6EAF3;">Optional: Enter Keywords separated by comma<span class="orange_txt"></span></td>
				<td  align="left"><input type="text" class="input_box" name="keyword" value="<?php echo ucwords($result_document['keywords']);?>" size="50"><br>
				</td>
</tr>				
-->
<?php 
					if(!$_SESSION['uid'])
					{
				?>
				<?php }?>
				<tr><td style="background-color:#D6EAF3;">&nbsp;</td><td align="left"><input type="submit" value="Submit"></td></tr>
<? } ?>
				</table>
         </div>

				 </form>
				  
      <?php include("footer.inc.php")?>
   </div>
</body>
</html>
