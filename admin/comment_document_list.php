<?php session_start();
require_once("../config/config.inc.php");
require_once("../config/functions.inc.php");
validate_admin();
@extract($_POST);
if($_POST['ids']){
$arr=$_POST['ids'];
if(count($arr)>0){
$str_arr=implode(",",$arr);
$sql_del=mysql_query("delete from tbl_comment where id in ($str_arr)");
header("Location: comment_document_list.php");
exit();
}
}
$start=0;
if(isset($_GET['start'])) $start=$_GET['start'];
if($_GET['page']){
$pagesize=$_GET[page];
}else{
$pagesize=10;
}
if(isset($_GET['pagesize'])) $pagesize=$_GET['pagesize'];
$sql=executeQuery("select tbl_comment.*,tbl_document.doc_title from tbl_comment inner join tbl_document on (tbl_comment.doc_id=tbl_document.id) limit $start,$pagesize");
$reccnt=mysql_num_rows(executeQuery("select * from tbl_comment inner join tbl_document on (tbl_comment.doc_id=tbl_document.id)"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=SITE_ADMIN_TITLE?></title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" type="text/JavaScript">

function checkall(objForm)
{
	len = objForm.elements.length;
	var i=0;
	for( i=0 ; i<len ; i++){
		if (objForm.elements[i].type=='checkbox') 
			objForm.elements[i].checked=objForm.check_all.checked;
	}
}

function del_prompt(frmobj,comb,user_id)
{
	if(comb=='Delete'){
		if(confirm ("Are you sure you want to delete Record(s)")){
			frmobj.action = "comment_document_list.php";
			frmobj.submit();
		}
		else{ 
			return false;
		}
	}
	
}

function paging(frmobj,comb){

frmobj.action = 'comment_document_list.php?page='+comb;
			frmobj.submit();
}


</script>
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
                      <td width="76%"><span class="title"><strong><img src="images/heading_icon.gif" width="16" height="16" hspace="5">Comments Details</strong></span></td>
                      <td width="24%" align="right"></td>
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
				  <table width="759" height="19" cellpadding="0" cellspacing="0">
				  	<tr>
						<td  align="right" class="txt" >
						Paging&nbsp;<select name="page" onChange="javascript: paging(this.form,this.value)">
									<option value="10" <?php if($_GET[page]==10){?>selected<? } ?>>1-10</option>
									<option value="20" <?php if($_GET[page]==20){?>selected<? } ?>>10-20</option>
									<option value="30" <?php if($_GET[page]==30){?>selected<? } ?>>20-30</option>
									<option value="40" <?php if($_GET[page]==40){?>selected<? } ?>>30-40</option>
									<option value="50" <?php if($_GET[page]==50){?>selected<? } ?>>40-50</option>
									</select>
						</td>
					</tr>
				  </table>

				  <table width="98%" border="0" cellspacing="1" cellpadding="4" align=center  bgcolor="#D8D8D8">
				  <?php if($reccnt>0){?>
				  	<tr bgcolor="#4096AF" class="bigWhite">
					  <TD width="13%" align="center" bgcolor="#4096AF"><strong>S.No. </strong></TD>
					  <TD width="23%" align="center" bgcolor="#4096AF"><strong>Docuemt Name</strong></TD>
					  <TD width="38%" align="center" bgcolor="#4096AF"><strong>Comment </strong></TD>
					  <TD width="18%" align="center" bgcolor="#4096AF"><strong>Comment Edit </strong></TD>
					   <td width="8%" align="center" class="heading"> 
					  <input name="check_all" type="checkbox" id="check_all" value="check_all" onClick="checkall(this.form)">
					  </td></tr>
					<?php $i=0;
					
					while($line=mysql_fetch_array($sql)){
					$className = ($className == "evenRow")?"oddRow":"evenRow";
					$i++;?>
					<tr class="<?php print $className?>"> 
					  <TD align="center" class="txt" ><?php echo  $i; ?></TD>
					   <TD align="center" class="txt"><?php echo $line['doc_title']; ?></TD>
					  <TD align="center" class="txt"><?php echo $line['comment']; ?></TD>
					  <TD align="center" ><a href="comment_addf.php?editid=<?php echo $line['id'] ?>" class="orangetxt">Edit</a></TD>
					<td width="8%" valign="middle" align="center"><input type="checkbox" name="ids[]" value="<?php print $line[0]?>"></td>
					
					
					  <!--td width="9%" valign="middle" align="center"><a href="document_addf.php?id=<?php print $line[0]?>&user_id=<?=$_GET[user_id]?>" class="orangetxt">Edit</a><br />
					<a href="comment_list.php?document_id=<?=$line[id]?>&user_id=<?=$_GET[user_id]?>" class="orangetxt">View Comments</a>
					</td-->
					 
					</tr>
					<?php }?>
					<?php $className = ($className == "evenRow")?"oddRow":"evenRow";?>
					<tr align="right" class="<?php print $className?>"> 
					  <td colspan="8"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
					    <tr>
							<td width="50%"  align="center"><?php include("../config/paging.inc.php"); ?></td>
                            <td align="right">
							<input type="submit" name="Submit" value="Delete" class="button" onclick="return del_prompt(this.form,this.value)">
							</td>
					    </tr>
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
