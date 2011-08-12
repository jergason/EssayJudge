<?php 
include("config/config.inc.php");
include("config/functions.inc.php");

if($_GET[page_id])
{
	$line=mysql_fetch_array(mysql_query("select * from tbl_rss_master where id='$_GET[page_id]'"));
}
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>FixedOnTime.com</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<link href="css/style.css" rel="stylesheet" type="text/css">
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
<table width="1111" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="959" align="center" valign="top" background="images/bg.gif" style="background-repeat:repeat-x; "><table width="1111" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center" valign="top" background="images/header.jpg" style="background-repeat:no-repeat; "><table width="990" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="358" height="110" align="center" valign="top" >&nbsp;</td>
            <td width="632">&nbsp;</td>
          </tr>
          <tr align="center" valign="top">
            <td colspan="2"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="9" align="center" valign="top"><img src="images/whitebox-curv-upper.gif" width="990" height="9"></td>
              </tr>
              <tr>
                <td align="left" valign="top" bgcolor="#FFFFFF" style="padding-left:5px; padding-right:5px; "><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="42" align="left" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="12" height="42"><img src="images/black_curv_frnt.gif" width="12" height="42"></td>
                        <td align="left" valign="middle" background="images/black_curv_bg.gif"><?php include("header.inc.php")?></td>
                        <td width="12" height="42"><img src="images/black_curv_rear.gif" width="12" height="42"></td>
                      </tr>
                    </table></td>
                    </tr>
                  <tr align="center" valign="top">
                    <td height="5"><img src="images/spacer.gif" width="1" height="1"></td>
                    </tr>
                  <tr align="center" valign="top">
                    <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td height="8" align="center" valign="top"><img src="images/spacer.gif" width="1" height="1"></td>
                      </tr>
                      <tr>
                        <td align="center" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="left" valign="top" style="padding-left:10px; "><table width="100%"  border="0" align="left" cellpadding="0" cellspacing="0">
                              <tr >
                                <td class="grey_txt" style="padding-left:5px; "><strong><?php echo ucwords($line[page_name]);?></strong></td>
                              </tr>
                              <tr>
                                <td align="left" valign="top" class="black_txt" style="padding-top:10px; padding-left:25px; ">
								<?php 
									echo $line[content];
								?></td>
                              </tr>
                            </table></td>
                            </tr>
                        </table></td>
                      </tr>
                    </table></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td height="9" align="center" valign="top"><img src="images/whitebox-curv-bottom.gif" width="990" height="8"></td>
              </tr>
              <tr>
                <td align="center" valign="top" style="padding-top:4px; "><img src="images/whitebox2-curv-upper.gif" width="990" height="8"></td>
              </tr>
              <tr>
                <td align="left" valign="top" bgcolor="#FFFFFF" style="padding-left:5px; padding-right:5px; "><?php include("footer.inc.php")?></td>
              </tr>
              <tr>
                <td height="9" align="center" valign="top"><img src="images/whitebox2-curv-bottom.gif" width="990" height="8"></td>
              </tr>
            </table></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
