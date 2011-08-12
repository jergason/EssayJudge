<?php
session_start();
if (!session_is_registered('sess_uid'))
{
   		echo "<script>parent.location.href='index.php?msg=Session Expired'</script>";
		exit;
}
?>