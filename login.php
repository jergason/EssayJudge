<?php session_start();
require_once("config/config.inc.php");
require_once("config/functions.inc.php");
if($_REQUEST['nid']){
  $update=mysql_query("update tbl_user set status=1 where id='".$_REQUEST['nid']."'");
}
if($_POST['submitForm'] == "yes") {
  $sql = sprintf("SELECT id, username FROM tbl_user WHERE username = '%s' AND password = '%s' AND status=1",
    mysql_real_escape_string($_POST['username']), mysql_real_escape_string($_POST['password']));
  $sql_login=mysql_query($sql);
  $result=mysql_num_rows($sql_login);
  if($result>0) {
    executeUpdate("update tbl_user set last_activity=now()");
    $result_login=mysql_fetch_array($sql_login);
    $_SESSION['uid']=$result_login['id'];
    if($_REQUEST['back']) {
      header("Location: " . $_REQUEST['back']);
      exit();
    }
    elseif($_REQUEST['doc_detail']==1) {
      header("Location: ".$_REQUEST['referer']);
      exit();
    }
    else {
      header("Location: my_account.php");
      exit();
    }
  }
  else {
    $_SESSION['sess_msg']='Invalid Username and Password.';
    header("Location: login.php");
    exit();
  }
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript" type="text/javascript">
function validate_form(obj) {
  msg='';
  if (obj.username.value=='') {
    msg='Please Enter a Username';
  }
  else if(obj.password.value=='') {
    msg='Please Enter a Password ';
  }
  if(msg!='') {
    alert(msg);
    return false;
  }
  else {
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
<div id="sidebar">
<div id="topdoc">Help</div>
<br>
<a href="register.php">I want to sign up!</a><br /><br /><a href="lost_password.php">I forgot my password</a>
</div>

	<div id = "main">
               <!--<div style="float:right;margin-top:10px;margin-right:25px;"><?php include("welnewfea.inc.php")?></div>-->
               <form action="login.php" method="post" enctype="multipart/form-data" name="frm" onsubmit="return validate_form(this)">
               <input type="hidden" name="submitForm" value="yes">
               <input type="hidden" name="doc_detail" value="<?=$_GET[doc_detail]?>">		 
               <input type="hidden" name="referer" value="<?=$_SERVER['HTTP_REFERER']?>">
               <input type="hidden" name="back" value="<?php echo $_GET['back'];?>">
               <center><span style="color:red"><?php print $_SESSION['sess_msg']; session_unregister('sess_msg'); $sess_msg='';?></span><br/></center>

<div id="subheading">Login</div><br />
<center>
                     Username:
<input type="text" name="username" size="17"  class="input_box"/><br><br>
				Password:
				<input type="password" name="password" size="17"  class="input_box"/><br/><input type="submit" value="Submit" style="margin-top:5px"/>
</div>
</center>
      <?php include("footer.inc.php")?>
   </div>
</body>
</html>
