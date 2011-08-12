<?php 
session_start();
include("codelibrary/inc/variables.php");
include("codelibrary/inc/functions.php");
include("codelibrary/inc/message.inc.php");
require_once('codelibrary/inc/user_top.php');

if($_GET['press_id']){
$where="where cat_id='".$_GET['press_id']."'";
}
elseif($_GET['archive_id']){
$where="where post_date like '".$_GET['archive_id']."%'";
}
else
$where="where post_date like '".date("Y-m")."%'";
 ?>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_showHideLayers() { //v6.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}
//-->
</script>
<script type="text/javascript">
function display_text(obj1,obj2)
{
	document.getElementById(obj2).style.display='';
	document.getElementById(obj1).style.display='none';
}



</script>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="top"><form action="" method="post" enctype="multipart/form-data" name="form1">
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td valign="top"><table width="99%"  border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="65%" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                    <tr>
                      <td><img src="images/bdr_toplft.gif" width="12" height="10" alt="Unleash Video" title="Unleash Video" /></td>
                      <td width="100%" background="images/bdr_topbg.gif"><img src="images/bdr_topbg.gif" width="12" height="10" /></td>
                      <td><img src="images/bdr_toprt.gif" width="11" height="10" alt="Unleash Video" title="Unleash Video" /></td>
                    </tr>
                    <tr>
                      <td valign="top" background="images/bdr_lftbg.gif"><img src="images/bdr_lftbg.gif" width="12" height="10" alt="Unleash Video" title="Unleash Video" /></td>
                      <td valign="top" class="boxbg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td class="cmsbg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td valign="top"><img src="images/head_leftcurve.gif" width="7" height="40" alt="Unleash Video" title="Unleash Video" /></td>
                                <td width="100%" valign="top" background="images/head_bg.gif"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td><img src="images/head_upress.gif" alt="Unleashed Press" title="Unleashed Press" /></td>
                                    <td align="right">&nbsp;</td>
                                  </tr>
                                </table></td>
                                <td valign="top"><img src="images/head_rightcurve.gif" width="8" height="40" alt="Unleash Video" title="Unleash Video" /></td>
                              </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td class="cmsbg"><img src="images/spacer.gif" width="1" height="10" alt="Unleash Video" title="Unleash Video" /></td>
                        </tr>
                        <tr>
                          <td valign="top" class="txtpress"><table width="99%"  border="0" align="center" cellpadding="0" cellspacing="0">
                            <?php 
							$start=0;
							if(isset($_GET['start'])) $start=$_GET['start'];
							$pagesize=5;
							if(isset($_GET['pagesize'])) $pagesize=$_GET['pagesize'];
							$order_by='id'; 
							if(isset($_GET['order_by'])) $order_by=$_GET['order_by'];
							$order_by2='desc';
							if(isset($_GET['order_by2'])) $order_by2=$_GET['order_by2'];
							$query_desc=executeQuery("select * from tbl_press  $where ORDER BY $order_by $order_by2 limit $start, $pagesize");
							$fetch_rec=mysql_num_rows($query_desc);
							$reccnt=mysql_num_rows(executeQuery("select * from tbl_press  $where ORDER BY $order_by $order_by2"));
							while($press_res=mysql_fetch_array($query_desc)){
							$ij++;
							?>
							<tr>
                              <td  valign="top" class="txtpress" ><span class="txtbold"><?php echo ucfirst($press_res['title']);?></span><br>
                               </td> </tr>
									<tr id="des_<?=$press_res[id]?>"><td valign="top" class="txtpress"><?php echo nl2br(substr($press_res['description'],0,200));?>   
									 &nbsp;<a href="javascript:void(0)" onClick="javascript:display_text('des_<?=$press_res[id]?>','des1_<?=$press_res[id]?>')" class="alinksmall">more...</a></p></td>
                            </tr>
							<tr style="display:none " id="des1_<?=$press_res[id]?>"><td valign="top" class="txtpress"><?php echo nl2br($press_res['description']);?>   
									 &nbsp;<a href="javascript:void(0)" onClick="javascript:display_text('des1_<?=$press_res[id]?>','des_<?=$press_res[id]?>')" class="alinksmall">...less</a></p></td>
                            </tr>
							<? if($ij<$fetch_rec){?>
                            <tr>
                             <td background="images/comments_sep.gif"><img src="images/comments_sep.gif" alt="Unleash Video" title="Unleash Video" ></td>
                            </tr>
							<? }							
							} ?>
                             <tr>
							<td valign="top" class="alinksmall"><?php include("codelibrary/inc/frontpaging.inc.php"); ?></td>
							</tr>
                          </table></td>
                        </tr>
                      </table></td>
                      <td valign="top" background="images/bdr_rtbg.gif"><img src="images/bdr_rtbg.gif" width="11" height="10" alt="Unleash Video" title="Unleash Video"></td>
                    </tr>
                    <tr>
                      <td><img src="images/bdr_btmlft.gif" width="12" height="16" alt="Unleash Video" title="Unleash Video"></td>
                      <td background="images/bdr_btmbg.gif"><img src="images/bdr_btmbg.gif" alt="Unleash Video" width="12" height="16" title="Unleash Video" /></td>
                      <td><img src="images/bdr_btmrt.gif" width="11" height="16" alt="Unleash Video" title="Unleash Video"></td>
                    </tr>
                  </table></td>
                </tr>
              </table></td>
              <td width="1%" valign="top">&nbsp;</td>
              <td valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                          <tr>
                            <td><img src="images/bdr_toplft.gif" width="12" height="10" alt="Unleash Video" title="Unleash Video" /></td>
                            <td width="100%" background="images/bdr_topbg.gif"><img src="images/bdr_topbg.gif" width="12" height="10" alt="Unleash Video" title="Unleash Video" /></td>
                            <td><img src="images/bdr_toprt.gif" width="11" height="10" alt="Unleash Video" title="Unleash Video" /></td>
                          </tr>
                          <tr>
                            <td valign="top" background="images/bdr_lftbg.gif"><img src="images/bdr_lftbg.gif" width="12" height="10" alt="Unleash Video" title="Unleash Video" /></td>
                            <td valign="top" class="boxbg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td class="cmsbg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td valign="top"><img src="images/head_leftcurve.gif" width="7" height="40" alt="Unleash Video" title="Unleash Video" /></td>
                                        <td width="100%" valign="top" background="images/head_bg.gif"><img src="images/head_categories.gif" alt="Categories" title="Categories" /></td>
                                        <td valign="top"><img src="images/head_rightcurve.gif" width="8" height="40" alt="Unleash Video" title="Unleash Video" /></td>
                                      </tr>
                                  </table></td>
                                </tr>
                                <tr>
                                  <td class="cmsbg"><img src="images/spacer.gif" width="1" height="10" alt="Unleash Video" title="Unleash Video" /></td>
                                </tr>
                                <tr>
                                  <td valign="top">
								  <?php
								   $query_press_category=executeQuery("select tbl_press_category.id,tbl_press_category.category as cat,count(tbl_press.cat_id) as cnt from tbl_press_category left join tbl_press on (tbl_press_category.id=tbl_press.cat_id) where tbl_press_category.status=1 and tbl_press.status=1 group by tbl_press_category.id ");?>
                                    <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="pressbox">
                                      <tr>
                                        <td valign="top"> <? while($row=mysql_fetch_array($query_press_category)){ echo $row['cat'];?> (<a href="press.php?press_id=<? echo $row['id'];?>" class="alinksmall"><? echo $row['cnt']?></a>) <br>
                                         <? }?> </td>
                                      </tr>
                                  </table></td>
                                </tr>
                            </table></td>
                            <td valign="top" background="images/bdr_rtbg.gif"><img src="images/bdr_rtbg.gif" width="11" height="10" alt="Unleash Video" title="Unleash Video"></td>
                          </tr>
                          <tr>
                            <td height="16"><img src="images/bdr_btmlft.gif" width="12" height="16" alt="Unleash Video" title="Unleash Video"></td>
                            <td background="images/bdr_btmbg.gif"><img src="images/bdr_btmbg.gif" alt="Unleash Video" width="12" height="16" title="Unleash Video" /></td>
                            <td><img src="images/bdr_btmrt.gif" width="11" height="16" alt="Unleash Video" title="Unleash Video"></td>
                          </tr>
                      </table></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><img src="images/spacer.gif" width="10" height="6"></td>
                </tr>
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                    <tr>
                      <td><img src="images/bdr_toplft.gif" width="12" height="10" alt="Unleash Video" title="Unleash Video" /></td>
                      <td width="100%" background="images/bdr_topbg.gif"><img src="images/bdr_topbg.gif" width="12" height="10" alt="Unleash Video" title="Unleash Video" /></td>
                      <td><img src="images/bdr_toprt.gif" width="11" height="10" alt="Unleash Video" title="Unleash Video" /></td>
                    </tr>
                    <tr>
                      <td valign="top" background="images/bdr_lftbg.gif"><img src="images/bdr_lftbg.gif" width="12" height="10" alt="Unleash Video" title="Unleash Video" /></td>
                      <td valign="top" class="boxbg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td class="cmsbg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td valign="top"><img src="images/head_leftcurve.gif" width="7" height="40" alt="Unleash Video" title="Unleash Video" /></td>
                                  <td width="100%" valign="top" background="images/head_bg.gif"><img src="images/head_archives.gif" alt="Archives" title="Archives" /></td>
                                  <td valign="top"><img src="images/head_rightcurve.gif" width="8" height="40" alt="Unleash Video" title="Unleash Video" /></td>
                                </tr>
                            </table></td>
                          </tr>
                          <tr>
                            <td class="cmsbg"><img src="images/spacer.gif" width="1" height="10" alt="Unleash Video" title="Unleash Video" /></td>
                          </tr>
                          <tr>
                            <td valign="top">
                              <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="pressbox">
                                <tr><td valign="top">
								<?php $query_date=executeQuery("select count(*) as c,date_format(post_date,'%M-%Y') as d1,date_format(post_date,'%Y-%m') as d from tbl_press where status=1 group by d  order by d desc");
								while ($result=mysql_fetch_array($query_date)){?>
								
                                  <a href="press.php?archive_id=<?=$result['d']?>" class="alinksmall"><? echo $result['d1'];?></a><br>
                                   <? }?></td>
                                </tr>
                            </table></td>
                          </tr>
                      </table></td>
                      <td valign="top" background="images/bdr_rtbg.gif"><img src="images/bdr_rtbg.gif" width="11" height="10" alt="Unleash Video" title="Unleash Video"></td>
                    </tr>
                    <tr>
                      <td height="16"><img src="images/bdr_btmlft.gif" width="12" height="16" alt="Unleash Video" title="Unleash Video"></td>
                      <td background="images/bdr_btmbg.gif"><img src="images/bdr_btmbg.gif" alt="Unleash Video" width="12" height="16" title="Unleash Video" /></td>
                      <td><img src="images/bdr_btmrt.gif" width="11" height="16" alt="Unleash Video" title="Unleash Video"></td>
                    </tr>
                  </table></td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
      </table>
    </form></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<?php require_once('codelibrary/inc/user_footer.php'); ?>