<?
session_start();
require_once("../config/config.inc.php");
require_once("../config/functions.inc.php");
validate_admin();
@extract($_POST);
if($_POST['submit']=="yes")
{	//print_r($user_id);die;
	$sql_update=mysql_query("update tbl_comment set comment='$comment' where id='$id' ");
	$_SESSION['sess_msg']="Comemnt has successfully been updated!";   	
    if($user_id>0){
	header("Location: comment_list.php?user_id=$user_id&document_id=$document_id");
	}else{
	header("Location: comment_document_list.php");
    }
	exit();
}
$mysql_edit=mysql_query("select tbl_comment.*,tbl_document.doc_title from tbl_comment inner join tbl_document on (tbl_comment.doc_id=tbl_document.id) where tbl_comment.id='".$_REQUEST['editid']."'");
$res=mysql_fetch_array($mysql_edit);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=SITE_ADMIN_TITLE?></title>
<link href="css/style.css" rel="stylesheet" type="text/css" />

<script src="popcalendar.js"></script>
<script src="ajax.js" type="text/javascript"></script>
<script language="javascript" runat="server">
function trim(s) {
  while (s.substring(0,1) == ' ') {
    s = s.substring(1,s.length);
  }
  while (s.substring(s.length-1,s.length) == ' ') {
    s = s.substring(0,s.length-1);
  }
  return s;
}
function check(fval)
{
	url = document.location.href;
	xend = url.lastIndexOf("/") + 1;
	var base_url = url.substring(0, xend);
	
	url="checkuser.php";
	 if (url.substring(0, 4) != 'http') {
		url = base_url + url;		
	}		

	var strSubmit="id1="+fval+"&selected=<?=$id?>";	
	var strURL = url;

	
	var strResultFunc = "displayResultuser";
	
	xmlhttpPost(strURL, strSubmit, strResultFunc)
	return true;
}
function displayResultuser(strIn) {
	if(strIn!='')
	{	
	//alert(strIn);
		document.getElementById('postid').innerHTML=strIn;
if(strIn=='This email is currently in use. Please choose another one.' || document.getElementById('email').value==''){
		document.getElementById('email').value='';
document.regFrm.email.focus();
}
	}
}
function checkpass(fval)
{
	url = document.location.href;
	xend = url.lastIndexOf("/") + 1;
	var base_url = url.substring(0, xend);
	
	url="checkpass.php";
	 if (url.substring(0, 4) != 'http') {
		url = base_url + url;		
	}		

	var strSubmit="id2="+fval+"&cat="+document.regFrm.password.value;		
	var strURL = url;

	
	var strResultFunc = "displayResultpass";
	
	xmlhttpPost(strURL, strSubmit, strResultFunc)
	return true;
}
function displayResultpass(strIn) {
	if(strIn!='')
	{	
		document.getElementById('cpass').innerHTML=strIn;
		if(strIn=='The confirm password is incorrect please try again.'){
		document.getElementById('cpassword').value='';
document.regFrm.cpassword.focus();
	}
	}
}


function changelanguage(id)
{
	location.href='user_addf.php?lang_id='+id;
}

</script>
</head>
<body >
<? include("header.inc.php");?>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="180" valign="top">
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center"><? include("left_menu.inc.php");?></td>
        </tr>
        <tr>
          <td width="23" style="padding-left:10px">&nbsp;</td>
        </tr>
      </table>
    <br />
    <br /></td>
    <td width="1" bgcolor="#045972"><img src="images/spacer.gif" width="1" height="1" /></td>
    <td width="1"><img src="images/spacer.gif" width="1" height="1" /></td>
    <td height="400" align="center" valign="top">
	<!-- Center Part Begins Here  -->
		<table width="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
          <tr>
            <td height="21" align="left" bgcolor="#EDEDED" class="txt">
				<table width="98%"  border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="76%"><span class="title"><img src="images/heading_icon.gif" width="16" height="16" hspace="5">Edit Comment</span></td>
                      
                    </tr>
                </table>
			</td>
          </tr>
          <tr>
            <td height="400" align="center" valign="top" bgcolor="#FFFFFF"><br>
              <form action="comment_addf.php" method="post" enctype="multipart/form-data" name="regFrm" >
			 <input type="hidden" name="submit" value="yes" />
			  <input type="hidden" name="id" class="txtfld" value="<?php echo $_REQUEST['editid']?>">
			  <input type="hidden" name="user_id" class="txtfld" value="<?php echo $_REQUEST['user_id']?>">
			  <input type="hidden" name="document_id" class="txtfld" value="<?php echo $_REQUEST['document_id']?>">
			<table width="98%" border="0" cellspacing="0" cellpadding="4" align=center  bgcolor="#FFFFFF">
				<TR bgcolor="#EDEDED" align="left"> 
					<TD height="25" colspan="2" bgcolor="#4096AF" class="bigWhite"><strong>
				         Edit
				     Comments </strong></TD>
				</TR>
				<?php if($_SESSION['sess_msg']!=''){?>
				<tr>
					<td colspan="2" align="center"  class="warning" bgcolor="#F6F6F6" ><?php print $_SESSION['sess_msg']; session_unregister('sess_msg'); $sess_msg='';?></td>
				</tr>
				<?php }?>
				<tr class="oddRow">
					<td height="23" align="left" class="txt">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Document Name :<span class="warning"></span></td>
					<td align="left"><input type="text" class="txtfld" name="doctitle" value="<?php echo ucwords($res['doc_title']); ?>" size="39" disabled><div id="pass" class="txt"></div></td>
				</tr>
				<tr class="evenRow">
					<td width="33%" height="23" align="left" class="txt">&nbsp;&nbsp;&nbsp;&nbsp;Comment : <span class="warning"></span> </td>
					<td class="txt" align="left"><textarea name="comment" rows="5" cols="30" class="txtfld"><?php echo $res['comment']; ?></textarea></td>
				</tr>
			  	
				<tr class="oddRow">
					<td height="23" colspan="2" align="center" ><input type="submit" value="Submit" class="button"/></td>
			  	</tr>
			  	</table>
			  </form>
		<br>
         </td>
       </tr>
     </table>
	<!-- Center Part Ends Here  -->
	</td>
    <td width="20" valign="top" bgcolor="#EDEDED">&nbsp;</td>
  </tr>
</table>
<? include("footer.inc.php");?>
</body>
</html>
