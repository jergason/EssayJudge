<?
session_start();
require_once("../config/config.inc.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>VALUEONWEB</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->

/*Function for Login Form Validation of Required Fields.              */
var msg = "Incorrect data!. Kindly enter the following details.\n";
function validateForm(obj)
{  
	var str="";
	
	if(obj.username.value == '') str+='- Please Enter Username. \n';
	if(obj.password.value == '') str+='- Please Enter Password. \n';

	if(str) {
		alert(msg+str);
		return false;
	}
}
</script>
</head>
<body onload="MM_preloadImages('images/home_ovr.jpg','images/about_ovr.jpg','images/services_ovr.jpg','images/portfolio_ovr.jpg','images/contactus_ovr.jpg')">
<table width="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#4196AF">
  <tr>
    <td width="624"><img src="images/innerHeader.jpg" width="783" height="122" /></td>
    <td width="1"><img src="images/spacer.gif" width="1" height="1" /></td>
  </tr>
</table>
<table width="100%"  border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td height="21" align="left" valign="middle" background="images/topGreyBar.jpg" style="padding-left:10px"><img src="images/securedAdminSuite.jpg" width="147" height="5" /></td>
  </tr>
</table>

<table width="100%"  border="0" cellspacing="1" cellpadding="0">
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><img src="images/spacer.gif" width="1" height="1" /></td>
  </tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="209" valign="top">
      &nbsp;
    <br />
    <br /></td>
    <td width="1" bgcolor="#045972"><img src="images/spacer.gif" width="1" height="1" /></td>
    <td width="1"><img src="images/spacer.gif" width="1" height="1" /></td>
    <td height="400" align="center" valign="top"><p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p align="center" class="warning"><?=$_SESSION['sess_msg']?></p>
<form name="login" method="post" action="login.php" enctype="multipart/form-data" onSubmit="return validateForm(this)">
      <table width="300" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="30" align="left" bgcolor="#166B84">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/securedLogin.jpg" width="108" height="9" /></td>
        </tr>
        <tr>
          <td><table width="370" border="0" cellspacing="0" cellpadding="4">
              
              <tr>
                <td width="3" bgcolor="#F06E07"><img src="images/spacer.gif" width="3" height="3" /></td>
                <td width="80" bgcolor="#EDEDED"><span class="txt"><strong>USERNAME</strong></span></td>
                <td height="30" align="left" bgcolor="#EDEDED"><input name="username" type="text" class="txtfld" /></td>
              </tr>
              <tr>
                <td width="3" bgcolor="#F06E07"><img src="images/spacer.gif" width="3" height="3" /></td>
                <td width="80"><span class="txt"><strong>PASSWORD</strong></span></td>
                <td height="30" align="left"><input name="password" type="password" class="txtfld" /></td>
              </tr>
              <tr>
                <td width="3" bgcolor="#F06E07"><img src="images/spacer.gif" width="3" height="3" /></td>
                <td width="80" bgcolor="#F7F7F7"><span class="txt"></span></td>
                <td height="30" align="left" bgcolor="#F7F7F7"><input type='hidden' name="logged" value="yes" /><input type="image" src="images/submit.gif" width="82" height="26" /></td>
              </tr>
          </table></td>
        </tr>
      </table>
    </form>
    <p>&nbsp;</p>
    <p><br />
    </p>
    <p>&nbsp;</p></td>
    <td width="20" valign="top" bgcolor="#EDEDED">&nbsp;</td>
  </tr>
</table>
<table width="100%" height="128"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top" background="images/footerBackground.jpg"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="79"><img src="images/footerLogoTop.jpg" width="79" height="36" /></td>
        <td align="center" background="images/footerLogoBackground.jpg" class="bigWhite">&nbsp;</td>
      </tr>
      <tr>
        <td width="79"><img src="images/footerLogoBottom.jpg" width="79" height="34" /></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?
$_SESSION['sess_msg'] = '';
?>
