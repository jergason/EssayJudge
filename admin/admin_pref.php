<?php
session_start();
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
header("Cache-Control: no-store, must-revalidate");
header("Pragma: no-cache");
require_once("../config/config.inc.php");
require_once ("../config/functions.inc.php");
include "validate.php";
$updateFlag=0;
$sessionUser=trim($_SESSION['sess_uid']);
@extract($_POST);
if($_POST['SubForm']==1)
{
  if($cnpwd!=$npwd)
  {
    $msg=MISMATCHPASS;
  }
  else
  {
    $sqlselect="select password from admin where password='$pwd' and username='$admin_id'";
    $resultselect=mysql_query($sqlselect)or die("Select Password from admin failed".mysql_error());
    $numrows=mysql_num_rows($resultselect);
    if($numrows==0)
    {
      $msg=INCORRECTPASS;
      $_SESSION['msg'] = $msg;
    }
    else
    {
      //echo "update admin set password='".$_POST['npwd']."',username='".$_POST['username']."' where id='$sessionUser'";
      $update="update admin set password='".$_POST['npwd']."',username='".$_POST['username']."' where id='$sessionUser'";
      $resultupdate=mysql_query($update)or die("Update Query Failed".mysql_error());
      $msg=UPDATEPASS;
      $pwd="";
      $npwd="";
      $cnpwd="";
      $_SESSION['msg'] = $msg;
      $updateFlag=1;
    }
  }	

}
?><head>
<title><?=ADMINTITLE?></title>
<SCRIPT LANGUAGE="JavaScript">
function check()
{
  var MasterString = "Sorry, we cannot complete your request.\nKindly provide us the missing or incorrect information enclosed below.\n";
  var flag=false;
  var visitor="";
  var emailFlag="";
  var pwdFlag="";
  if(document.form1.username.value=="")
  {
    visitor +=  "\nPlease enter Username.";
    emailFlag=1;
  }
  if(document.form1.npwd.value=="")
  {
    visitor +=  "\nPlease enter New Password.";
    pwdFlag=1;
  }
  if(document.form1.npwd.value!=document.form1.cnpwd.value)
  {
    visitor +=  "\nNew Password and Confirm Password must be same.";
    pwdFlag=1;
  }	
  if(visitor != "") {
    MasterString = MasterString + visitor;
    flag=true;
  }
  if (flag == true) {
    alert(MasterString);
    document.form1.username.focus();
    return false;
  }
}

</script>
</head>
<link  rel="stylesheet" href="css/style.css" type="text/css">
<body  topmargin="0" leftmargin="0" rightmargin="0">
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="27%"><? include"header.inc.php"?></td>
  </tr>

  <tr align="left"s>
    <td colspan="2"><table width="95%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="left" valign="top" width="20%"><? require_once "left_menu.inc.php"; ?></td>
          <td width="100%" valign="top"><table width="100%"  border="0" cellpadding="0" cellspacing="1" bgcolor="#B1B1B1">
              <tr>
                <td height="21" align="left"  bgcolor="#EDEDED" >
                  <table width="98%"  border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="76%" class="h1"><img src="images/heading_icon.gif" width="16" height="16" hspace="5"><span class="verdana_small_white"><span class="title">Admin Preferences</span></span></td>
                      <td width="24%" align="right">&nbsp;</td>
                    </tr>
                </table></td>
              </tr>
              <tr>
               <td height="400" align="center" valign="top" bgcolor="#FFFFFF"><br>
                  <form name="form1" method="post" >
                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1">
                      <tr>
                        <td class="white" align="left"> </td>
                      </tr>
<?php
$sqladmin="select username,password from admin where id='$sessionUser'";
$resultadmin=mysql_query($sqladmin)or die("Select Admin Query Failed".mysql_error());
$rowadmin=mysql_fetch_array($resultadmin);
?>
                     <?php if(isset($msg) && $msg!=""){?>
            <tr bgcolor="#F3F4F5" align="center">
                        <td>
                        <span class="warning"><strong><?php echo $msg;
session_unregister("msg");
?></strong></span>
            </td>
                      </tr>
            <?php }?>
                      <input type="hidden" name="action" value="Update Password">
                      <input type="hidden" name="admin_id" value="<?=$rowadmin['username'];?>">
          <tr bgcolor="#F3F4F5" align="center">
                        <td height="30" bgcolor="#F3F4F5">
                        <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#D8D8D8">
                              <tr class="evenRow">
                                <td height="24" colspan="2" bgcolor="#4096AF" class="bigWhite"><strong>Update Password</strong></td>
                              </tr>
                              <tr class="oddRow">
                                <td height="20" width="35%"   class="txt" align="right"><B>Username:<span class="warning">*</span></B></td>
                                <td height="20" width="65%" colspan="-1" align="left"><input type="text" readonly name="username" size="35" class="txt" value="<?php echo trim($rowadmin['username']);?>"></td>
                              </tr>
                              <tr class="evenRow">
                                <td height="20" align="right"  class="txt"><strong>Old Password: </strong></td>
                                <td width="65%" colspan="-1" align="left" bgcolor="#F6F6F6">
                                  <input name="pwd" type="text" class="txt" id="pwd" value="<?=$rowadmin['password']?>" size="35" disabled></td>
                                  <input type="hidden" name="pwd" value="<?=$rowadmin['password']?>">
                </tr>
                              <tr class="oddRow">
                                <td height="20" align="right"  class="txt"><strong>New Password:<span class="warning">*</span> </strong></td>
                                <td width="65%" colspan="-1" align="left">
                                <input name="npwd" type="password" class="txt" id="npwd" value="<?=$npwd?>" size="35"></td>
                              </tr>
                              <tr class="evenRow">
                                <td height="20" align="right" class="txt"><strong>Confirm Password: </strong></td>
                                <td width="65%" colspan="-1" align="left">
                                <input name="cnpwd" type="password" class="txt" id="cnpwd" value="<?=$cnpwd?>" size="35"></td>
                              </tr>
                              <tr class="oddRow">
                                <td height="20" >&nbsp; </td>
                                <td height="20" align="left" valign="middle" bgcolor="#FFFFFF">
                <input type="image" src="images/submit.gif" width="82" height="26" onclick="return check();"/>

                <input type="hidden" name="SubForm" value="1">
                </td>
                              </tr>
                          </table>
                    </table>
                </form>
          </table></td>
       </tr>
      </table>
        <br>
        <br>
  </tr>
  <tr>
    <td height="1" colspan="2"><? include"footer.inc.php"?></td>
  </tr>
</table>
<span class="sess_msg_red"><?echo $_SESSION['sess_msg']; session_unregister('sess_msg'); $sess_msg='';?></span>

</body>
