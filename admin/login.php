<?
session_start();
require_once("../config/config.inc.php");
// @extract($_POST);
// Is this ghetto CSRF protection?
if($_POST['logged'] == "yes"){
  $sql = sprintf("select * from admin where username='%s' and password='%s' and status='1'",
    mysql_real_escape_string($_POST['username']), mysql_real_escape_string($_POST['password']));
  $rs = mysql_query($sql);

  if(mysql_num_rows($rs) > 0){
    $rc = mysql_fetch_array($rs);
    $_SESSION['sess_uid'] = $rc['id'];
    $_SESSION['sess_username'] = strtoupper($rc['username']);
    header("Location: admin_home.php");
    die();
  }
  else {
    $_SESSION['sess_msg'] = $_POST['username'] . $_POST['password'];
    header("Location: index.php");
  }
}
?>
