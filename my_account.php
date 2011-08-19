<?php session_start();
require_once("config/config.inc.php");
require_once("config/functions.inc.php");
validate_user();
@extract($_REQUEST);
if ($_POST['submit'] == "Submit") {

  $birthday=$year1."-".$month1."-".$day1;
  if($id==''){
    $dup_user=mysql_num_rows(mysql_query("select username from tbl_user where username='$username'"));
    if($dup_user>0)
    {
      $sess_msg='This Username Is Not Available, Please Try Another';
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
  $sql="select * from tbl_user where id='$id' and status=1";
  $result=executeQuery($sql);
  $num=mysql_num_rows($result);
  if($line=ms_stripslashes(mysql_fetch_array($result))){
    @extract($line);		
  }
}

?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
<title>Essay Judge - Writing Community for Peer Editing</title>
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





  if(msg == 'Incomplete data! Please give information.\n\n')
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
	<div id="sidebar">
               <?php $get_user_name=mysql_fetch_array(mysql_query("select username from tbl_user where id=".$_SESSION[uid]))?>
           <div id="topdoc">Welcome <?php echo ucwords($get_user_name[0]);?></div><br>
To post an essay for review, click "Submit Essay"
<br>
To see your review, click "Latest Comments"
<br>
Your review will normally be posted in less than a day
<br>
</div>
<div id="main">
	<div id="subheading">What to do now?</div>
 <center><span style="color:red"><?php print $_SESSION['sess_msg']; session_unregister('sess_msg'); $sess_msg='';?></span><br/>

<a href="add_document.php" alt="Add New Document" title="Submit New Document"><img src="icons/upload.png"><br>Add a new essay</a>

<a href="user_latest_comment.php" alt="See The Latest Comments Posted On My Document" title="See Comments On My Essay"><img src="icons/comments.png"><br>Read My Comments</a>


<a href="register.php" alt="Edit Profile" title="Edit My Profile"><img src="icons/user.png"><br>Edit My Profile</a>


<a href="user_documents.php?user_id=<?=$_SESSION[uid]?>" alt="See My Documents" title="See My Documents"><img src="icons/view.png"><br>View My Documents</a>
</center>

      </div>
	<?php include("footer.inc.php")?>
   </div>
</body>
</html>
