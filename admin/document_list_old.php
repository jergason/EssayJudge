<?
session_start();
require_once("../config/config.inc.php");
require_once("../config/functions.inc.php");
validate_admin();
@extract($_POST);
$start=0;
if(isset($_GET['start'])) $start=$_GET['start'];
$pagesize=50;
if(isset($_GET['order_by'])) $order_by=$_GET['order_by'];
$order_by='tbl_document.id';
if(isset($_GET['order_by2'])) $order_by2=$_GET['order_by2'];
$order_by2='asc';
$where=" and posted_by='$_GET[user_id]'";
$sql=executeQuery("select tbl_document.*,avg(tbl_rating.score) as avg_score from tbl_document left join tbl_rating on (tbl_document.id=tbl_rating.document_id) where 1=1 $where group by (tbl_document.id) order by $order_by $order_by2 limit $start,$pagesize");
$reccnt=mysql_num_rows(executeQuery("select tbl_document.*,avg(tbl_rating.score) as avg_score from tbl_document left join tbl_rating on (tbl_document.id=tbl_rating.document_id) where 1=1 $where group by (tbl_document.id) "));
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
			frmobj.action = "document_del.php?user_id="+user_id;
			frmobj.submit();
		}
		else{ 
			return false;
		}
	}
	else if(comb=='Pending'){
		frmobj.action = "document_del.php?user_id="+user_id;
		frmobj.submit();
	}
	else if(comb=='Approve'){
		frmobj.action = "document_del.php?user_id="+user_id;
		frmobj.submit();
	}
	else if(comb=='Feature'){
		frmobj.action = "document_del.php?user_id="+user_id;
		frmobj.submit();
	}
	else if(comb=='Remove Feature'){
		frmobj.action = "document_del.php?user_id="+user_id;
		frmobj.submit();
	}
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
                      <td width="76%"><span class="title"><strong><img src="images/heading_icon.gif" width="16" height="16" hspace="5">Document Manager</strong></span></td>
                      <td width="24%" align="right"><input name="b1" type="button" class="button" id="b1" value="Add Document" onClick="location.href='document_addf.php?user_id=<?=$_GET[user_id]?>'">&nbsp;<input type="button" name="b2" class="button" id="b2" value="User Manager" onclick="location.href='user_list.php'" /></td>
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
					<TD width="23%" align="center" bgcolor="#4096AF"><strong>Average Score</strong></TD>
					<TD width="23%" align="center" bgcolor="#4096AF"><strong>View Document</strong></TD>
					  <TD width="12%" align="center"><strong>Status </strong></TD>
					  <td width="9%" align="center" ><strong>Actions</strong></td>
					  <td width="7%" align="center" class="heading"> 
					  <input name="check_all" type="checkbox" id="check_all" value="check_all" onClick="checkall(this.form)">
					  </td>
					</tr>
					<?php $i=0;
					while($line=mysql_fetch_array($sql)){
					$className = ($className == "evenRow")?"oddRow":"evenRow";
					$i++;?>
					<tr class="<?php print $className?>"> 
					  <TD align="center" class="txt" ><?php print $i?>.</TD>
					  <TD align="center" class="txt" ><?=ucfirst($line['doc_title'])?><?php if($line[feature]==1){?><span class="warning">*</span><?php }?><?php if($line[status]==1){?><span class="warning">~</span><?php }?></TD>
					  <TD align="center" class="txt" ><?php if($line['avg_score']){?><?=$line['avg_score']?><?php }else{?>0<?php }?></TD>
				 	<TD align="center" class="txt" ><?php if($line['doc_path']){?><a href="../file.php?<?php echo $line['doc_path'];?>" class="orangetxt">Download</a>&nbsp;|&nbsp;<a href="../uploaded_document/<?php echo $line['doc_path'];?>" class="orangetxt"  target="_blank">View</a><?php }else{?><a href="javascript:void(0);" class="orangetxt" onclick="window.open('pop_up_view_document.php?doc_id=<?=$line['id']?>','view_document','menubar=0,height=600,width=600,resizable=0');">View</a><?php }?></TD>
					<TD align="center" class="txt"><? if($line[status]==1){?>Approved<? }else{?>Pending<? }?></TD>
					  <td width="9%" valign="middle" align="center"><a href="document_addf.php?id=<?php print $line[0]?>&user_id=<?=$_GET[user_id]?>" class="orangetxt">Edit</a><br />
					<a href="comment_list.php?document_id=<?=$line[id]?>&user_id=<?=$_GET[user_id]?>" class="orangetxt">View Comments</a>
					</td>
					  <td width="7%" valign="middle" align="center"><input type="checkbox" name="ids[]" value="<?php print $line[0]?>"></td>
					</tr>
					<?php }?>
					<?php $className = ($className == "evenRow")?"oddRow":"evenRow";?>
					<tr align="right" class="<?php print $className?>"> 
					  <td colspan="8"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
					    <tr>
							<td width="50%"  align="center"><?php include("../config/paging.inc.php"); ?></td>
                            <td align="right">
							<input type="submit" name="Submit" value="Approve" class="button" onclick="return del_prompt(this.form,this.value,'<?php echo $_GET[user_id]?>')">
							<input type="submit" name="Submit" value="Pending" class="button" onclick="return del_prompt(this.form,this.value,'<?php echo $_GET[user_id]?>')">
							<input type="submit" name="Submit" value="Delete" class="button" onclick="return del_prompt(this.form,this.value,'<?php echo $_GET[user_id]?>')">
							<input type="submit" name="Submit" value="Feature" class="button" onclick="return del_prompt(this.form,this.value,'<?php echo $_GET[user_id]?>')">
							<input type="submit" name="Submit" value="Remove Feature" class="button" onclick="return del_prompt(this.form,this.value,'<?php echo $_GET[user_id]?>')">
							<br />
							</td>
					    </tr>
                      </table></td>
					</tr>
					<tr>
					<td class="txt">Feature-<span class="warning">*</span><br />
						Approve-<span class="warning">*</span>
					</td>
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
