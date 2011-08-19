<?php session_start();
require_once("config/config.inc.php");
require_once("config/functions.inc.php");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>EssayJudge</title>
<link href="style.css" rel="stylesheet" type="text/css">
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
   <div class="container">
      <?php include("header.inc.php")?>
		<div id="main">
      
                  <?php 
								if(isset($_GET['order_by'])) $order_by=$_GET['order_by'];
								$result1=mysql_query("select tbl_document.id,tbl_document.doc_title, avg( distinct tbl_rating.score) as avg_score, date_format(tbl_document.post_date,'%M %e, %Y') as post_date,tbl_user.username,count(tbl_comment.id) as comment_rec from tbl_document inner join tbl_user on (tbl_document.posted_by=tbl_user.id) left join tbl_rating on (tbl_document.id=tbl_rating.document_id) left join tbl_comment on (tbl_document.id=tbl_comment.doc_id) where tbl_document.status=1 $where group by tbl_document.id order by tbl_document.post_date desc");
								$result=mysql_query("select tbl_document.id,tbl_document.doc_title,tbl_user.username from tbl_document inner join tbl_user on (tbl_document.posted_by=tbl_user.id) left join tbl_comment on (tbl_document.id=tbl_comment.doc_id) where tbl_document.status=1 $where group by tbl_document.id ");
							
							$reccnt=mysql_num_rows($result);
							if($reccnt>0)
							{
								while($line=mysql_fetch_array($result1))
								{ ?>
								   <a href="document_detail.php?doc_id=<?=$line[id]?>" style="font-size:12px"><?php echo $line[doc_title];?></a><br>
                        <? } 
                     } ?>

            </div>
      <?php include("footer.inc.php")?>
   </div>
</body>
</html>