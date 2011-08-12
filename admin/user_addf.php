<?
session_start();
require_once("../config/config.inc.php");
require_once("../config/functions.inc.php");
validate_admin();

@extract($_POST);
if ($_POST['submit'] == "Submit") {	
	
	$birthday=$year1."-".$month1."-".$day1;
	if($id==''){
		$dup_user=mysql_num_rows(mysql_query("select username from tbl_user where username='$username'"));
		if($dup_user>0)
		{
			$sess_msg='This Username Is Not Available,Please Try Another';
			$_SESSION['sess_msg']=$sess_msg;
		}
		else
		{
		$sql = "insert into tbl_user set username='$username',password='$password',email='$email',birthday='$birthday',city='$city',state='$state',zip='$zip',about_me='$about_me',join_date=now(),status=1";	
		executeUpdate($sql);
		}
	}
	else{		
		$sql="update tbl_user set password='$password',birthday='$birthday',email='$email',city='$city',state='$state',zip='$zip',about_me='$about_me' where id='$id'";
		executeUpdate($sql);
		}
	$_SESSION['frm_arr']='';
	header("Location: user_list.php");
	exit();
}

$id=$_REQUEST['id'];
if (is_array($_POST) && count($_POST)>0) {
	@extract($_POST);
}
elseif (trim($id) != "") 
{
	$sql="select * from tbl_user where id='$id'";
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
	if(obj.username.value == '') msg+='- Please enter Username. \n';
	if(obj.password.value == '') msg+='- Please enter password. \n';
	if(obj.cpassword.value == '') msg+='- Please enter  Confirm password. \n';
	if(obj.cpassword.value != obj.password.value) msg+='- Please enter Confirm password same as Password. \n';
	if(obj.email.value == '') msg+='- Please enter Email. \n';
	else if(!validEmailAddress(obj.email.value)) msg+='- Please enter valid email address. \n';
	if(obj.day1.value == '' || obj.month1.value == '' || obj.year1.value == '') msg+='- Please enter Birthday. \n';
	if(obj.city.value == '') msg+='- Please enter State. \n';
	if(obj.state.value == '') msg+='- Please enter State. \n';
	if(obj.zip.value == '') msg+='- Please enter Zip. \n';
	if(obj.about_me.value == '') msg+='- Please enter About Yourself. \n';
	
	
	
	
		
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
                    <tr>
                      <td width="76%"><span class="title"><img src="images/heading_icon.gif" width="16" height="16" hspace="5">User Manager</span></td>
                      <td width="24%" align="right"><input name="b1" type="button" class="button" id="b1" value="User Manager" onClick="location.href='user_list.php'"></td>
                    </tr>
                </table>
			</td>
          </tr>
          <tr>
            <td height="400" align="center" valign="top" bgcolor="#FFFFFF"><br>
              <form action="user_addf.php" method="post" enctype="multipart/form-data" name="regFrm"  onSubmit="return validForm(this)">
			  <input type="hidden" name="id" class="txtfld" value="<?=$id?>">
			<table width="98%" border="0" cellspacing="0" cellpadding="4" align=center  bgcolor="#FFFFFF">
				<TR bgcolor="#EDEDED" align="left"> 
					<TD height="25" colspan="2" bgcolor="#4096AF" class="bigWhite"><strong>
				    <?php if($id==''){?>
				    Add New
				    <?php }else{?>
				    Edit
				    <?php }?>User
			        Details</strong></TD>
				</TR>
				<?php if($_SESSION['sess_msg']!=''){?>
				<tr>
					<td colspan="2" align="center"  class="warning" bgcolor="#F6F6F6" ><?php print $_SESSION['sess_msg']; session_unregister('sess_msg'); $sess_msg='';?></td>
				</tr>
				<?php }?>
				<tr class="evenRow">
					<td class="txt" align="right" colspan="2"><span class="warning">*</span> - Required Fields</td>
				</tr>
				
				
				<tr class="oddRow">
					<td width="33%" height="23" align="left" class="txt">&nbsp;&nbsp;&nbsp;&nbsp; UserName :<span class="warning">*</span> </td>
					<td width="67%" align="left"><input type="text" name="username" value="<?=$username?>" size="30" maxlength="20"  class="txtfld"><div id="postid" class="txt"></div></td>
				</tr>
				<tr class="evenRow">
					<td height="23" align="left" class="txt">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Password:<span class="warning">*</span></td>
					<td align="left"><input type="password" class="txtfld" name="password" value="<?=$password?>" size="30"><div id="pass" class="txt">4 to 20 charactes(A-Z,a-z,0-9,no space)</div></td>
				</tr>
			  	<tr class="oddRow">
					<td height="23" align="left" class="txt">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Confirm Password :<span class="warning">*</span></td>
					 
					<td align="left"><input type="password" class="txtfld" name="cpassword" value="<?=$password?>" size="30" ><div id="cpass" class="txt">Re-enter Password</div></td>
			  	</tr>
				<tr class="evenRow">
					<td width="33%" height="23" align="left" class="txt">&nbsp;&nbsp;&nbsp;&nbsp; Email :<span class="warning">*</span> </td>
					<td class="txt" align="left"><input type="text" name="email" value="<?=$email?>"  class="txtfld" size="30"/></td>
				</tr>
				<tr class="oddRow">
					<td height="23" align="left" class="txt">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Birthday :<span class="warning">*</span></td>
					 
					<td align="left" class="txt">
					<?php $birh=explode("-",$birthday);
						?>
					<select name="day1" class="txtfld">
					<option value="">--Day--</option>
					<?php 
			  			for($i=01;$i<32;$i++)
						{
							if($i==$birh[2])
							{
								$chk='selected';
							}
							else
							{
								$chk='';
							}
						?>
						<option value="<?php echo $i?>" <?=$chk?>><?php echo $i; ?></option>
						<?php
						}
			  			?>
					</select>
					<select name="month1" class="txtfld">
					<option value="">--Month--</option>
						<?php 
			  			for($i=01;$i<13;$i++)
						{
							if($i==$birh[1])
							{
								$chk='selected';
							}
							else
							{
								$chk='';
							}
						?>
						<option value="<?php echo $i?>" <?=$chk?>><?php echo $i; ?></option>
						<?php
						}
			  			?>
					</select>
					<select name="year1" class="txtfld">
					<option value="">--Year--</option>
					<?php  $toyear=getdate(); 
			 	 	for($i=1900;$i<=$toyear[year];$i++)
					{
						if($i==$birh[0])
							{
								$chk='selected';
							}
							else
							{
								$chk='';
							}
					?>
					<option value="<?php echo $i?>" <?=$chk?>><?php echo $i; ?></option>
					<?php
					}
			  		?>
			 		</select>
					</td>
			  	</tr>
				<tr class="evenRow">
					<td width="33%" height="23" align="left" class="txt">&nbsp;&nbsp;&nbsp;&nbsp; City :<span class="warning">*</span> </td>
					<td class="txt" align="left"><input type="text" name="city" value="<?=$city?>"  class="txtfld" size="30"/></td>
				</tr>
				<tr class="oddRow">
					<td width="33%" height="23" align="left" class="txt">&nbsp;&nbsp;&nbsp;&nbsp; State :<span class="warning">*</span> </td>
					<td class="txt" align="left"><select name="state" class="txtfld">
					<option value="">--select state--</option>
					<?php 
						$res_state=mysql_query("select * from state");
						while($line_state=mysql_fetch_array($res_state))
						{
							if($line_state[id]==$state)
							{
								$chk='selected';							
							}
							else
							{
								$chk='';
							}
							?>
							<option value="<?=$line_state[id]?>" <?=$chk?>><?=$line_state[name]?></option>
							<?php
						}
					?>
					</select></td>
				</tr>
				
				<tr class="evenRow">
					<td width="33%" height="23" align="left" class="txt">&nbsp;&nbsp;&nbsp;&nbsp; Zip :<span class="warning">*</span></td>
					<td class="txt" align="left"><input type="text" name="zip" value="<?=$zip?>" class="txtfld" size="30" /></td>
				</tr>
				<tr class="oddRow">
					<td width="33%" height="23" align="left" class="txt">&nbsp;&nbsp;&nbsp;&nbsp;About Yourself :<span class="warning">*</span> </td>
					<td class="txt" align="left"><textarea name="about_me" rows="5" cols="30" class="txtfld"><?=$about_me?></textarea></td>
				</tr>
			  	
				<tr class="evenRow">
					<td height="23" colspan="2" align="center" ><input type="submit" name="submit"  value="Submit" class="button"/></td>
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
