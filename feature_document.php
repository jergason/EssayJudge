//old page, probably no longer used
<?php session_start();
require_once("config/config.inc.php");
require_once("config/functions.inc.php");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?=SITE_TITLE?></title>
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
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
        <?php include("header.inc.php")?>
        </tr>
        <tr>
          <td align="center" valign="top"><?php include("left.inc.php")?></td>
          <td width="600" align="center" valign="top"><table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
              <tr align="left" valign="top">
                      <td colspan="3" align="left" class="blue_txt" height="30"><font  class="large_blue_txt" size="+2">Feature Document</font></td>
              </tr>
				    <tr>
                      <td width="9" height="9" align="right" valign="top"><img src="images/box_left_upper.gif" width="9" height="9"></td>
                      <td width="577" align="left" valign="top" background="images/box_upper_bg.gif" style="background-repeat:repeat-x; background-position:top; "><img src="images/box_upper_bg.gif" width="9" height="9"></td>
                      <td width="14" height="9" align="left" valign="top"><img src="images/box_right_upper.gif" width="14" height="9"></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top" background="images/box_left_bg.gif" style="background-repeat:repeat-y; background-position:right; "><img src="images/box_left_bg.gif" width="9" height="2"></td>
                      <td align="center" valign="top">
				 		<table width="100%">
						<!--tr class="bluerow">
						<td class="big_white_txt" align="left" style="padding-left:3px; ">Featured Documents</td>
						</tr
						find_in_set('".$_POST[search_text]."',tbl_document.keywords)-->
						<?php 
					$h=array();
						$sp=mysql_query("select * from tbl_flag where ifnull(flag,0)=0 or flag=0");
							
							while($doc=mysql_fetch_array($sp))
							{
								$h[]=$doc['document_id'];
								
							}
							$imp=implode(",",$h);
							
							if($imp=='')
							$imp='0';
							
					?>
						<?php $feature=mysql_query("select id,doc_title from tbl_document where id not in ($imp) and status=1 and feature=1 order by doc_title asc ");					
						while($line_feature=mysql_fetch_array($feature))
						{
						$bgcolor=="#f6f6f6"?$bgcolor="#ffffff":$bgcolor="#f6f6f6";
					?>
            <tr style="background:<?=$bgcolor?>; ">
              <td align="left" valign="top" class="blue_txt"  style="padding-left:55px; "><?php echo nl2br(ucwords($line_feature[doc_title]));?><br>
				<div align="right" style="padding-right:55px;"><a href="document_detail.php?doc_id=<?=$line_feature[id]?>">See</a></div> 
				</td>
			   </tr>
			   	<?php }?>
						</table>
				  </td>
				<td align="left" valign="top" background="images/box_right_bg.gif"><img src="images/box_right_bg.gif" width="14" height="3"></td>
                    </tr>
					<tr>
                      <td width="9" height="16" align="right" valign="top"><img src="images/box_left_bottom.gif" width="9" height="16" vspace="0" hspace="0"></td>
                      <td align="left" valign="top" background="images/box_bottom_bg.gif"><img src="images/box_bottom_bg.gif" width="9" height="16"></td>
                      <td width="14" height="16" align="left" valign="top"><img src="images/box_right_bottom.gif" width="14" height="16"></td>
                    </tr>
           
          </table></td>
          <td width="250" align="right" valign="top" style="padding-right:16px; "></td>
        </tr>
    </table></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
     <?php include("footer.inc.php")?>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="top">&nbsp;</td>
   
  </tr>
</table>
</body>
</html>
