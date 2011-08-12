<?php 
session_start();
require_once("../config/config.inc.php");
require_once("../config/functions.inc.php");
validate_admin();


$arr =$_POST['ids'];
$Submit =$_POST['Submit'];
if(count($arr)>0){
$str_rest_refs=implode(",",$arr);
	if($Submit=='Delete')
	{
		$sql="delete from tbl_comment where id in ($str_rest_refs)"; 
		executeUpdate($sql);
		$sess_msg="Selected Record(s) Deleted Successfully";
		$_SESSION['sess_msg']=$sess_msg;
    }
}
header("Location: comment_list.php?user_id=".$_GET[user_id]."&document_id=".$_GET['document_id']);
exit();

?>