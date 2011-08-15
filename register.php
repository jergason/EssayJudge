<?php
session_start();
require_once("config/config.inc.php");
require_once("config/functions.inc.php");
// WHY U DO DIS?
@extract($_REQUEST);
if($_SESSION['uid']) {
  $id=$_SESSION['uid'];
}
else {
  $id='';
}

if ($_POST['SubmitForm'] == 'yes') {

  $birthday=$year1."-".$month1."-".$day1;
  if($id==''){
    $dup_user=mysql_num_rows(mysql_query("select username from tbl_user where username='$username'"));
    $dup_email=mysql_num_rows(mysql_query("select email from tbl_user where email='$email'"));

    if($dup_user>0) {
      $sess_msg='<br clear=all><br><font color=red>This User Name is already taken!  Please try another.</font>';
      $_SESSION['sess_msg']=$sess_msg;
      header("Location: register.php");
      exit();
    }
    elseif($dup_email>0) {
      $sess_msg='<br clear=all><br><font color=red>This Email address has already been used.</font>  <a href="http://www.essayjudge.com/lost_password.php">Did you forget your password?</a>';
      $_SESSION['sess_msg']=$sess_msg;
      header("Location: register.php");
      exit();
    }
    else {
      if($security_code!=$_SESSION['seccode']) {
        $_SESSION['sess_msg']='<br clear=all><br><font color=red>Incorrect Security Code (It is Case-Sensitive)</font>';
        header("Location: register.php");
        exit();
      }
      else {
        if($state_id) {
          $state=$state_id;
        }
        else {
          mysql_query("insert into state set name='$state1',status=1");
          $stateid=mysql_insert_id();
          $state=$stateid;
        }
        $sql = sprintf("INSERT INTO tbl_user SET
          username='%s',
          password='%s',
          email='%s',
          birthday='1920-2-19',
          city='a',
          state='1',
          zip='1',
          about_me='%s',
          join_date=now(),
          status=1",
          mysql_real_escape_string($username), mysql_real_escape_string($password),
          mysql_real_escape_string($email), mysql_real_escape_string($about_me));
        executeUpdate($sql);
        $nid=mysql_insert_id();
        //$_SESSION['sess_msg']='You Are Registered Successfully! Please Check Your Mail';
        $headers  = 'MIME-Version: 1.0' . "\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n";
        $headers .= 'From: Admin@EssayJudge.com';
        $to=$email;
        $subject= "Essay Judge";
        $message="Welcome ".$username.",<br>\n<br>\n";
        //$message.="You have one step left to register with EssayJudge.com. Simply click this , ";
        //$message.="<a href='http://www.EssayJudge.com/login.php?nid=$nid'>Activation Link</a><br>\n<br>\n";
        $message.="Your Account Username:  ".$username."<br>\n";
        $message.="Welcome to EssayJudge.com!<br><br>
          If you find this service helpful, please tell your friends and your teachers.  <Br><u>Here is how it works:</u>
            <ol>
            <li><b>Post</b> an essay draft you have written.
            <li>Get <b>constructive feedback</b> on your essay.
            <li>Consider offering helpful feedback to others.
            </ol>
            <br><u>That's all there is to it</u>\n";
        //@mail($to, $subject, $message, $headers);
      }
    }
    $_SESSION['sess_msg']='Thank you for registering.  Please login to post and review essays!';
    header("location: login.php");
    exit();
  }
  else {
    $sql="update tbl_user set password='$password',birthday='$birthday',email='$email',city='a',state='1',zip='1',about_me='$about_me' where id='$id'";
    executeUpdate($sql);
    $_SESSION['sess_msg']='Profile Updated Successfully';
    header("Location: my_account.php");
    exit();
  }

}

$id=$_SESSION['uid'];
// Oh no it is so bad make it stop.
if (is_array($_POST) && count($_POST)>0) {
  @extract($_POST);
}
elseif (trim($id) != "") {
  $sql="select * from tbl_user where id='$id' and status=1";
  $result=executeQuery($sql);
  $num=mysql_num_rows($result);
  if($line=ms_stripslashes(mysql_fetch_array($result))){
    @extract($line);
  }
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>EssayJudge - Registration</title>
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

  var msg='Incomplete data!\n\n', flag=false;
  if(obj.username.value == '') msg+='- Please enter Username. \n';
  if(obj.password.value == '') msg+='- Please enter password. \n';
  if(obj.cpassword.value == '') msg+='- Please enter password twice. \n';
  if(obj.cpassword.value != obj.password.value) msg+='- Please enter Confirm password same as Password. \n';
  if(obj.email.value == '') msg+='- Please enter Email. \n';
  else if(!validEmailAddress(obj.email.value)) msg+='- Please enter valid email address. \n';
  if(obj.day1.value == '' || obj.month1.value == '' || obj.year1.value == '') msg+='- Please enter Birthday. \n';
  if(obj.city.value == '') msg+='- Please enter City. \n';
  if((obj.state.value == '')&&(obj.state1.value=='')) msg+='- Please enter State. \n';
  if(obj.zip.value == '') msg+='- Please enter Zip. \n';
  if(obj.about_me.value == '') msg+='- Please enter About Yourself. \n';
  if(obj.security_code.value == '') msg+='- Please enter Security Code. \n';
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

         <form action="register.php" method="post" enctype="multipart/form-data" name="frm" onsubmit="return validForm(this)">
        <input type="hidden" name="SubmitForm" value="yes">
         <div id="main">
<?php
if($status!=1) {
?>
                 <div id="subheading">Sign Up!</div><?php print $_SESSION['sess_msg']; session_unregister('sess_msg'); $sess_msg='';?></td>
<?php }
else
{
?>
                  <td colspan=2 style="padding-bottom:15px;"><div id="subheadng;">My Profile</h3><?php print $_SESSION['sess_msg']; session_unregister('sess_msg'); $sess_msg='';?></td>
               <?php } ?>
			<br><br>
              Username<br>
			<input type="text" size="33" class="input_box" name="username" value="<?=$username?>" <?php if($status==1){?>readonly<?php }?>><span class="orange_txt"></span>
             <br>
<br>
			Password<br>
			<input type="password" size="33" class="input_box" name="password" value="<?=$password?>"><span class="orange_txt"></span>
			<br>
			Confirm Password<br>
			<input type="password" size="33" class="input_box" name="cpassword" value="<?=$password?>"><span class="orange_txt"></span>
              <br>
<br>
			Email (for password recovery)<br>
			<input type="text" size="33" class="input_box" name="email" value="<?=$email?>"><span class="orange_txt"></span>
			<br>
			<br><br>
<!--
          <tr>
              <td width="30%"  align="left" style="padding-top:25px;background-color:#D6EAF3;" class="black_txt">Birthday</td>
              <td  align="left"width="70%" style="padding-top:25px;padding-left:5px"><?php $birh=explode("-",$birthday);?>
                <select name="day1" class="input_box">
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
                     <select name="month1" class="input_box">
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
                     <select name="year1" class="input_box">
                     <option value="">--Year--</option>
<?php  $toyear=getdate(); 
for($i=1900;$i<=$toyear['year'];$i++)
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
                     </select><span class="orange_txt"></span>
              </td>
           </tr>
          <tr>
              <td width="30%"  align="left" style="padding-top:25px;background-color:#D6EAF3;" class="black_txt">State</td>
              <td  align="left"width="70%" style="padding-top:25px;padding-left:5px"><select name="state_id" class="input_box" style="width:200px; ">
                     <option value="">--select state--</option>
<?php
$res_state=mysql_query("select * from state");
while($line_state=mysql_fetch_array($res_state))
{
  if($line_state['id']==$state)
  {
    $chk='selected';
  }
  else
  {
    $chk='';
  }
?>
                           <option value="<?=$line_state['id']?>" <?=$chk?>><?=$line_state['name']?></option>
<?php
}
?>
                     </select><span class="orange_txt"></span>
             </td>
           </tr>
          <tr>
              <td width="30%"  align="left" style="padding-top:25px;background-color:#D6EAF3;" class="black_txt">Zip</td>
              <td  align="left"width="70%" style="padding-top:25px;padding-left:5px"><input type="text" size="33" class="input_box" name="zip" value="<?=$zip?>"><span class="orange_txt"></span>
              </td>
          </tr>

-->

<!-- Removes About Me Field
          <tr>
              <td width="30%"  align="left" style="padding-top:25px;background-color:#D6EAF3;" class="black_txt">About Yourself</td>
              <td  align="left"width="70%" style="padding-top:25px;padding-left:5px"><textarea name="about_me" rows="5" cols="35" class="input_box"><?=$about_me?></textarea><span class="orange_txt"></span>
              </td>
          </tr>
-->

<?php
if($status!=1)
{
?>
	Phrase (Case Sensitive)
     <input style="float:left" name="security_code" type="text" size="6" maxlength="20" class="input_box" >&nbsp;&nbsp;&nbsp;&nbsp;<img src="image.php?PHPSESSID=<?=$ssid?>" alt="Security Code" align="absmiddle" title="Security Code">
	<br>
           <?php }?>
          
		<input type="submit" value="Submit">
         </div>
         </form>
<br>
      <?php include("footer.inc.php")?>
   </div>
</body>
</html>

