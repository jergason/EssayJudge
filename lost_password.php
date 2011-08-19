<?php session_start();
require_once("config/config.inc.php");
require_once("config/functions.inc.php");
@extract($_REQUEST);
if($_POST['submitForm'] == "yes") {
$sql_email=mysql_query("select * from tbl_user where email='$email'");
$rs_email=mysql_num_rows($sql_email);
if($rs_email>0){
$emails=mysql_fetch_array($sql_email);
$headers  = 'MIME-Version: 1.0' . "\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n";
$headers .= 'From: Admin@EssayJudge.com';
$to = $email;
$subject = 'EssayJudge.com - Password Recovery ';
$email_message = 'Dear '.ucwords($emails['name']).',<br><br>';
$email_message.= 'We have successfully recovered your account information: <br><br>';
$email_message.= 'Username: '.$emails['username'].'<br>';
$email_message.= 'Password: '.$emails['password'].'<br><br>';
$email_message.= '-EssayJudge';
@mail($to, $subject, $email_message, $headers);
$_SESSION['sess_msg']='Your password has been sent to your email address.';
}else{
$_SESSION['sess_msg']="Sorry, we did not recognize your email address";
}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript" type="text/javascript">
function validate_form(obj)
{
msg='';
if(obj.email.value=='') msg='Please Enter Email Address';
if(msg!=''){
alert(msg);
return false;
}else{
return true;
}
}
</script>				  
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
<div id="main">
<div id="subheading">Lost your password?</div>
            <form action="lost_password.php" method="post" enctype="multipart/form-data" name="frm" onsubmit="return validate_form(this)">
			   <input type="hidden" name="submitForm" value="yes">
				<input type="hidden" name="doc_detail" value="<?=$_GET[doc_detail]?>">		 
				<input type="hidden" name="referer" value="<?=$_SERVER['HTTP_REFERER']?>">

               <center><span style="color:red"><?php print $_SESSION['sess_msg']; session_unregister('sess_msg'); $sess_msg='';?></span><br/>
               Email Address:&nbsp;&nbsp;&nbsp;<input type="text" name="email" size="35"  class="input_box"/>&nbsp;&nbsp;<input type="submit" value="Submit" style="margin-top:5px"/>
</center>
</div>
      <?php include("footer.inc.php")?>
   </div>
</body>
</html>