<?php session_start();
require_once("../config/config.inc.php");
require_once("../config/functions.inc.php");
validate_admin();
@extract($_POST);
$sql_content=mysql_query("select * from tbl_content ");
$reccnt=mysql_num_rows($sql_content);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=SITE_ADMIN_TITLE?></title>
<link href="css/style.css" rel="stylesheet" type="text/css" />

</head>
<body>
<? include("header.inc.php");?>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="180" valign="top">
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center"><? include("left_menu.inc.php");?></td>
        </tr>
        <tr>
          <td width="23" style="padding-left:10px">&nbsp;</td>
        </tr>
      </table>
    <br />
    <br /></td>
    <td width="1" bgcolor="#045972"><img src="images/spacer.gif" width="1" height="1" /></td>
    <td width="1"><img src="images/spacer.gif" width="1" height="1" /></td>
    <td height="400" align="center" valign="top">
	<!-- Center Part Begins Here  -->
		<table width="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
          <tr>
            <td height="21" align="left" bgcolor="#EDEDED" class="txt">
				<table width="98%"  border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="76%"><span class="title"><strong><img src="images/heading_icon.gif" width="16" height="16" hspace="5"></strong></span></td>
                       </tr>
                </table>
			</td>
          </tr>
          <tr>
            <td height="400" align="center" valign="top" bgcolor="#FFFFFF"><br>
              <table width="98%" height="200" border="0" cellpadding="5" cellspacing="0">
                <tr>
                  <td height="347" align="center" valign="top" bgcolor="#FFFFFF">
				   
				  
				  <BR>
				  <span class="warning"><?php print $_SESSION['sess_msg']; session_unregister('sess_msg'); $sess_msg='';?></span>
				  <form name="frm_del" method="post" >
				  <table width="98%" border="0" cellspacing="1" cellpadding="4" align=center  bgcolor="#D8D8D8">
				  <?php if($reccnt>0){?>
				  	<tr bgcolor="#4096AF" class="bigWhite">
					  <TD width="8%" align="center" bgcolor="#4096AF"><strong>S.No. </strong></TD>
					  <TD width="23%" align="center" bgcolor="#4096AF"><strong>Title</strong></TD>
					
					  <TD width="12%" align="center"><strong>Status </strong></TD>
					  <td width="9%" align="center" ><strong>Actions</strong></td>
					 </tr>
					<?php $i=0;
					while($result=mysql_fetch_array($sql_content)){
					$className = ($className == "evenRow")?"oddRow":"evenRow";
					$i++;?>
					<tr class="<?php print $className?>"> 
					  <TD align="center" class="txt" ><?php print $i?>.</TD>
					  <TD align="center" class="txt" ><?php echo $result['title'];?></TD>
				 			 
					  <TD align="center" class="txt"><? if($result[status]==1){?>Activate<? }else{?>Deactivate<? }?></TD>
					  <td width="9%" valign="middle" align="center"><a href="content_addf.php?id=<?php print $result[0]?>" class="orangetxt">Edit</a><br />
</td>
					 </tr>
					<?php }?>
					<?php $className = ($className == "evenRow")?"oddRow":"evenRow";?>
					<tr align="right" class="<?php print $className?>"> 
					  <td colspan="8"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
					    <!--tr>
							 <td align="right">
							<input type="submit" name="Submit" value="Activate" class="button" onclick="return del_prompt(this.form,this.value)">
							<input type="submit" name="Submit" value="Deactivate" class="button" onclick="return del_prompt(this.form,this.value)">
							<input type="submit" name="Submit" value="Delete" class="button" onclick="return del_prompt(this.form,this.value)"><br />
							</td>
					    </tr-->
                      </table></td>
					</tr>
			     <?php }else{?>
				    <tr align="center" class="oddRow">
					  <td colspan="8" class="warning">Sorry, Currently there are no Records to display.</td>
					</tr>
				 <?php }?>
			     </table>
				 </form>
				 <br></td>
			   </tr>
			   <tr align="center">
                 <td>&nbsp;</td>
               </tr>
               <tr align="center">
                 <td>&nbsp;</td>
               </tr>
            </table>
         </td>
       </tr>
     </table>
	<!-- Center Part Ends Here  -->
	</td>
    <td width="20" valign="top" bgcolor="#EDEDED">&nbsp;</td>
  </tr>
</table>
<? include("footer.inc.php");?>
</body>
</html>
