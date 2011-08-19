//admin page, no design done here
<?
session_start();
require_once("config/config.inc.php");
require_once("config/functions.inc.php");
validate_admin();
@extract($_POST);
$start=0;

if(isset($_GET['start'])) $start=$_GET['start'];
$pagesize=50;
if(isset($_GET['order_by'])) $order_by=$_GET['order_by'];
$order_by='tbl_document.doc_title';
if(isset($_GET['order_by2'])) $order_by2=$_GET['order_by2'];
$order_by2='asc';
$where=" and status=0";
$sql=executeQuery("select tbl_document.*,tbl_user.username from tbl_document inner join tbl_user on (tbl_document.posted_by=tbl_user.id) where 1=1   order by $order_by $order_by2 limit $start,$pagesize");
$reccnt=mysql_num_rows(executeQuery("select tbl_document.*,tbl_user.username from tbl_document inner join tbl_user on (tbl_document.posted_by=tbl_user.id) where 1=1 "));
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
			frmobj.action = "pending_document_del.php";
			frmobj.submit();
		}
		else{ 
			return false;
		}
	}
	else if(comb=='Pending'){
		frmobj.action = "pending_document_del.php";
		frmobj.submit();
	}
	else if(comb=='Approve'){
		frmobj.action = "pending_document_del.php";
		frmobj.submit();
	}
	else if(comb=='Feature'){
		frmobj.action = "pending_document_del.php";
		frmobj.submit();
	}
	else if(comb=='Remove Feature'){
		frmobj.action = "pending_document_del.php";
		frmobj.submit();
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
<table width="100%" cellspacing="0" cellpadding="0" ><Tr><Td align=center><? include("header.inc.php");?></Td></Tr></table>

<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="180" valign="top">
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center"><? include("left.inc.php");?></td>
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
                      <td width="76%"><span class="title"><strong><img src="images/heading_icon.gif" width="16" height="16" hspace="5">List of Documents</strong></span></td>
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
				  <form name="frm_del" method="post"></form> 				  <table width="98%" border="0" cellspacing="1" cellpadding="4" align=center  bgcolor="#D8D8D8">
				  <?php if($reccnt>0){?>
				  	<tr bgcolor="#4096AF" class="bigWhite">
					  <TD width="8%" align="center" bgcolor="#4096AF"><strong>S.No. </strong></TD>
					  <TD width="35%" align="center" bgcolor="#4096AF"><strong>Title</strong></TD>
					  <TD width="28%" align="center" bgcolor="#4096AF"><strong>Uploaded By &nbsp;(Username)</strong></TD>
					  <TD width="29%" align="center" bgcolor="#4096AF"><strong>View Document</strong></TD>
					  
					</tr>
					<?php $i=0;
					while($line=mysql_fetch_array($sql)){
					$className = ($className == "evenRow")?"oddRow":"evenRow";
					$i++;?>
					<tr class="<?php print $className?>"> 
					  <TD align="center" class="txt" ><?php print $i?>.</TD>
					  <TD align="center" class="txt" ><a href="document_addf.php?id=<?php echo $line[id]?>" class="orangetxt">
					  <?=ucfirst($line['doc_title'])?></a><?php if($line[feature]==1){?><span class="warning">*</span><?php }?><?php if($line[status]==1){?><span class="warning">~</span><?php }?></TD>
					  <TD align="center" class="txt" ><?php echo $line['username'];?></TD>
					 <TD align="center" class="txt" ><a href="javascript:void(0);" class="orangetxt" onclick="window.open('pop_up_view_document.php?doc_id=<?=$line['id']?>','view_document','menubar=0,height=600,width=600,resizable=0');">View</a></TD>
					
					</tr>
					<?php }?>
					<?php $className = ($className == "evenRow")?"oddRow":"evenRow";?>
					<tr align="right" class="<?php print $className?>"> 
					  <td colspan="8"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
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
