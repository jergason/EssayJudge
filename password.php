<?php session_start();
require_once("config/config.inc.php");
require_once("config/functions.inc.php");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Password Reset</title>
</head>

<body>
<?php
  $username=$_POST['username'];
  $sql_login=mysql_query("select * from tbl_user where username='$username' ");
  $result=mysql_num_rows($sql_login);
  if($result>0){
    $result_login=mysql_fetch_array($sql_login);
    $email= $result_login['email'];
    $password= $result_login['password'];
    $username= $result_login['username'];
    $message="Dear $username, your password is : $password";
  }
  $mailid=mail('$email', 'My Subject', $message);
  if($mailid=='') {
    echo "check your username ";
  }
  else {
    echo "Your password has been sent to your Email-id";
  }
?>

</body>
</html>
