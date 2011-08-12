<?php 
session_start();
require_once("../config/config.inc.php");
require_once("../config/functions.inc.php");
validate_admin();

$id=$_REQUEST['id'];
if (is_array($_POST) && count($_POST)>0) {
	@extract($_POST);
}
elseif (trim($id) != "") 
{
	$sql="select * from tbl_document where id='$id'";
	$result=executeQuery($sql);
	$num=mysql_num_rows($result);
	if($line=ms_stripslashes(mysql_fetch_array($result))){
		@extract($line);		
	}
}

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
	
	var msg='Incomplete data! Kindly give Required information.\n\n', flag=false;
	if(obj.title.value == '') msg+='- Please enter Document Title. \n';
	if(obj.keyword.value == '') msg+='- Please enter Document Title. \n';
	<?php
	if($id=='')
	{	
	?>	if(obj.doc_path.value =='')
		{
			if(obj.doc_content.value =='')
			{
				msg+='- Please Uplaod Document Or Copy and Paste It. \n';
			}
		}
	<?php } 
	else
	{
		if(!$doc_path)
	?>
		if(obj.doc_content.value =='')
		{
			//msg+='- Please Uplaod Document Or Copy and Paste It. \n';
		}
	<?php 
	}	
	?>
	if(msg == 'Incomplete data! Kindly give Required information.\n\n')
		return true;
	else{
		alert(msg);
		return false;
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
                  </table>
			</td>
          </tr>
          <tr>
            <td height="400" align="center" valign="top" bgcolor="#FFFFFF"><br>
              <form action="" method="post" enctype="multipart/form-data" name="regFrm">
			  <input type="hidden" name="id" class="txtfld" value="<?=$id?>">
			  <input type="hidden" name="user_id" value="<?=$_GET[user_id]?>" />
			<table width="98%" border="0" cellspacing="0" cellpadding="4" align=center  bgcolor="#FFFFFF">
				<TR bgcolor="#EDEDED" align="left"> 
					<TD height="25" colspan="2" bgcolor="#4096AF" class="bigWhite"><strong>
				    Document Details</strong></TD>
				</TR>
				<tr class="oddRow">
					<td width="33%" height="23" align="left" class="txt">&nbsp;&nbsp;&nbsp;&nbsp; Document Title :<span class="warning">*</span> </td>
					<td width="67%" align="left" class="title"><?=$doc_title?><div id="postid" class="txt"></div></td>
				</tr>
				<tr class="evenRow">
					<td height="23" align="left" class="txt">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Document Keywords:<span class="warning">*</span></td>
					<td align="left" class="txt"><?=$keywords?></td>
				</tr>
			  	<!--tr class="oddRow">
					<td height="23" align="left" class="txt">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Upload Document :</td>
					 
					<td align="left"><input type="file" name="doc_path" class="txtfld" />
					<?php if($doc_path){?><br />
					<a href="../uploaded_document/<?=$doc_path?>" class="orangetxt">Download document</a>
					<?php }?>
					</td>
			  	</tr-->
				<!--tr class="evenRow">
					<td height="23" align="center" class="txt" colspan="100%"><strong>OR</strong></td>
					</tr-->
			  	<tr class="oddRow">
					<td height="23" align="left" class="txt">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Copy & Paste Document Content :</td>
					 
					<td align="left"><textarea name="doc_content" rows="20" cols="55" class="txtfld" disabled><?=$doc_content?></textarea></td>
			  	</tr>
				<tr class="evenRow">
					<td height="23" colspan="2" align="center" ><a href="pending_document_list.php">Back</a></td>
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
