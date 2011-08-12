<div class="contain_tl"><div class="contain_tr"><div class="contain_bl"><div class="contain_br">

<div class="banner">
            <table class="bannercont">
               <tr>
                  <td style="text-align:left;padding-top:25px">Submit Your Essay</td>
               </tr>
               <tr>
                  <td style="text-align:right;padding-right:100px">Get Feedback!</td>
               </tr>
                  <form name="searchfrm" action="search_result.php" method="post">
               <tr>
                  <td style="padding-left:40px;padding-top:20px;">
                  <table>
                     <tr>
                        <td style="vertical-align:middle"><input type="text" style="padding:2px;border:0" size=22 name="search_text"></td><td style="vertical-align:middle"><input type="submit" value="Search"></td>
                     </tr>
                  </table>
                  </td>
               </tr>
                  </form>
            </table>
      </div>
<?php
  $sql = sprintf("SELECT status FROM tbl_user WHERE id='%s'", mysql_real_escape_string($_SESSION['uid']));
  $sql_status = mysql_query($sql);
  $logged_in = false;
  if ($sql_status) {
    $result = mysql_fetch_array($sql_status);
    $logged_in = $result['status'];
  }
?>
      <center>
      <div style="padding:5px;margin-left:16px;margin-right:16px;background: url(/images/menubot.jpg) 0 100% no-repeat;">
         <div class="navbar"></div>
         <div class="navbar"><a href="<?php echo(SITE_URL); ?>">Home</a></div>
         <div class="navbar"><a href="search_result.php">Browse All</a></div>
         <?php if($logged_in){?>
         <div class="navbar"><a href="add_document.php">Submit Essay</a></div>
         <div class="navbar"><a href="my_account.php">My Account</a></div>
         <div class="navbar"><a href="logout.php">Logout</a></div>
         <?php }else{?>
         <div class="navbar"><a href="register.php">Sign Up</a></div>
         <div class="navbar"><a href="login.php">Login</a></div>
         <?php }?>
      </div>
<br>
