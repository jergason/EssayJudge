<div id="name">EssayJudge.com</div>
<?php
  $sql = sprintf("SELECT status FROM tbl_user WHERE id='%s'", mysql_real_escape_string($_SESSION['uid']));
  $sql_status = mysql_query($sql);
  $logged_in = false;
  if ($sql_status) {
    $result = mysql_fetch_array($sql_status);
    $logged_in = $result['status'];
  }
?>
<div id="navigation">
   <div class="navbar"> <a href='http://www.EssayJudge.com/'>Home</a></div>
   <div class="navbar"> <a href='http://www.EssayJudge.com/search_result.php'>Browse All</a></div>
   <?php if($result['status']==1){?>
   <div class="navbar"> <a href='http://www.EssayJudge.com/add_document.php';">Submit Essay</a></div>
   <div class="navbar"> <a href="http://www.EssayJudge.com/my_account.php">My Account</a></div>
   <div class="navbar"> <a href='http://www.EssayJudge.com/logout.php'>Logout</a></div>
   <?php }else{?>
   <div class="navbar"> <a href='http://www.EssayJudge.com/register.php'>Sign Up</a></div>
   <div class="navbar"> <a href='http://www.EssayJudge.com/login.php'>Login</a></div>
   <?php }?>
	<div class="navbar"><a href="http://www.essayjudge.com/sitemap.php">Site Map</a></div>		
</div>