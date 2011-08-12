<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                      <td width="9" height="9" align="right" valign="top"><img src="images/box_left_upper.gif" width="9" height="9"></td>
                      <td width="577" align="left" valign="top" background="images/box_upper_bg.gif" style="background-repeat:repeat-x; background-position:top; "><img src="images/box_upper_bg.gif" width="9" height="9"></td>
                      <td width="14" height="9" align="left" valign="top"><img src="images/box_right_upper.gif" width="14" height="9"></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top" background="images/box_left_bg.gif" style="background-repeat:repeat-y; background-position:right; "><img src="images/box_left_bg.gif" width="9" height="2"></td>
                      <td align="center" valign="top" >
					<table width="181"  border="0" cellspacing="0" cellpadding="0">
					<tr bgcolor="#1173CA" height="25">
					<td   style="font-size:16px;font-weight:bold;color:#ffffff; " align="center">Newest Documents</td>
					</tr>
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
						
					<?php 
					$res_new_doc=mysql_query("select id,doc_title from tbl_document where id not in ($imp) and status=1 order by id desc limit 0,10 ");					
						while($line_new_doc=mysql_fetch_array($res_new_doc))
						{
					?>
            <tr>
              <td align="left" valign="top"><a href="document_detail.php?doc_id=<?=$line_new_doc[id]?>" class="bluelink"><?php echo ucwords($line_new_doc[doc_title]);?></a></td>
            </tr>
			<tr height="10">
			<td>
			<img src="images/seprater.gif">
			</td>
			</tr>
            	<?php }?>
				<tr>
					<td>&nbsp;&nbsp;</td>
					</tr>	
			<tr bgcolor="#1173CA" height="25">
					<td   style="font-size:16px;font-weight:bold;color:#ffffff; " align="center">Featured Documents</td>
					</tr>
					
            <?php /*$res_latest_review=mysql_query("select id,comment from tbl_comment order by comment asc limit 0,10 ");					
						while($line_latest_review=mysql_fetch_array($res_latest_review))
						{
					*/?>
					<?php $feature=mysql_query("select id,doc_title from tbl_document where id not in ($imp) and status=1 and feature=1 order by doc_title asc limit 0,10 ");					
						while($line_feature=mysql_fetch_array($feature))
						{
					?>
            <tr>
              <td align="left" valign="top" class="blue_txt"><?php echo nl2br(substr($line_feature[doc_title],0,10))."...";?><br>
				<div align="right"><a href="document_detail.php?doc_id=<?=$line_feature[id]?>">See</a></div> 
				</td>
				
            </tr>
			<tr height="10">
			<td>
			<img src="images/seprater.gif">
			</td>
			</tr>
            	<?php }?>
				
				<tr><td align="right"><a href="feature_document.php">See All Feature Document</a></td></tr>
          
		  </table>			 
				 
				  </td>
				<td align="left" valign="top" background="images/box_right_bg.gif"><img src="images/box_right_bg.gif" width="14" height="3"></td>
                    </tr>
					<tr>
                      <td width="9" height="16" align="right" valign="top"><img src="images/box_left_bottom.gif" width="9" height="16" vspace="0" hspace="0"></td>
                      <td align="left" valign="top" background="images/box_bottom_bg.gif"><img src="images/box_bottom_bg.gif" width="9" height="16"></td>
                      <td width="14" height="16" align="left" valign="top"><img src="images/box_right_bottom.gif" width="14" height="16"></td>
                    </tr>
           
          </table>

