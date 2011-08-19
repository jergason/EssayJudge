//also probably not used anymore
<?php session_start();
require_once("config/config.inc.php");
require_once("config/functions.inc.php");
@extract($_REQUEST);


$username= mysql_real_escape_string($_GET['username']);
$_SESSION['message']='';
$sql_login=mysql_query("select * from tbl_user where username='$username' ");
$result=mysql_num_rows($sql_login);
if($result>0)
{
  $result_login=mysql_fetch_array($sql_login);
  $email= $result_login['email'];
  $password= $result_login['password'];
  $username= $result_login['username'];
  $message="Dear $username, your password is : $password";
  $mailid=mail('$email', 'My Subject', $message);
  if($mailid=='') {
    $_SESSION['message']="Sorry! Unable to send you mail containing Password.";
  }
  else {
    $_SESSION['message']="Your password has been successfully sent in your Email-id.";
  }
}
else {
  $_SESSION['message']="Please Enter Correct Username.";
}
?>
<?php
if($_POST['submitForm'] == "yes") {
  $sql_login=mysql_query("select * from tbl_user where username='$username' ");
  $result=mysql_num_rows($sql_login);
  if($result>0){
    //  executeUpdate("update tbl_user set last_activity=now()");
    $result_login=mysql_fetch_array($sql_login);

    echo $result_login['id'];
    $_SESSION['uid']=$result_login['id'];

    if($doc_detail==1)
    {
      header("Location: ".$referer);
      exit();
    }
    else
    {
      header("Location: my_account.php");
      exit();
    }
  }else{
    $_SESSION['sess_msg']='Please Enter Correct Username and Password.';
    header("Location: login.php");
    exit();
  }
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo SITE_TITLE;?></title>
<style type="text/css">
<!--
body {
  margin-left: 0px;
  margin-top: 0px;
  margin-right: 0px;
  margin-bottom: 0px;
}
-->
</style>
<link href="css/style.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript">
function validate_form(obj)
{
  msg='';
  if(obj.username.value=='') msg='Please Enter Username';

  if(msg!=''){
    alert(msg);
    return false;
}else{
  return true;
}
}
</script>
<style type="text/css">
<!--
.style1 {
  font-family: Verdana, Arial, Helvetica, sans-serif;
  font-weight: bold;
  font-size: large;
}
-->
</style>
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
                      <td height="30" colspan="3" align="left" class="blue_txt"><span class="style1">RECOVER PASSWORD</span></td>
              </tr>
                    <tr>
                      <td width="9" height="9" align="right" valign="top"><img src="images/box_left_upper.gif" width="9" height="9"></td>
                      <td width="577" align="left" valign="top" background="images/box_upper_bg.gif" style="background-repeat:repeat-x; background-position:top; "><img src="images/box_upper_bg.gif" width="9" height="9"></td>
                      <td width="14" height="9" align="left" valign="top"><img src="images/box_right_upper.gif" width="14" height="9"></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top" background="images/box_left_bg.gif" style="background-repeat:repeat-y; background-position:right; "><img src="images/box_left_bg.gif" width="9" height="2"></td>
                      <td align="center" valign="top">


       <form action="password_recover.php" method="get" name="frm" onsubmit="return validate_form(this)">
        <input type="hidden" name="submitForm" value="yes">


        <table width="100%" border="0" cellspacing="6" cellpadding="1">
           <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
            <tr>
          <td colspan="2" align="center"  class="blue_txt"><?php print $_SESSION['sess_msg']; session_unregister('sess_msg'); $sess_msg='';?></td>
        </tr>
        <tr><td colspan=2 align="justify"><?php  echo $_SESSION['message']; $_SESSION['message']='';  ?></td></tr>
           <tr>
          <td  align="right" class="blue_txt" width="27%">Username</td>
          <td align="left" width="73%"><input type="text" name="username" size="25"  class="input_box"/></td>
        </tr>
                  <tr><td>&nbsp;</td><td align="left"><input type="image" src="images/submit_btn.jpg"/></td></tr>

          </table>
       </form>

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
