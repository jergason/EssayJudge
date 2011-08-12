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
		$sql="delete from tbl_user where id in ($str_rest_refs)"; 
		executeUpdate($sql);
		$sess_msg="Selected Record(s) Deleted Successfully";
		$_SESSION['sess_msg']=$sess_msg;
    }
	elseif($Submit=='Activate')
	{
		$sql="update tbl_user set status=1 where id in ($str_rest_refs)";
		executeUpdate($sql);
		$sess_msg="Selected Record(s) Activated Successfully";
		$_SESSION['sess_msg']=$sess_msg;
	}
	elseif($Submit=='Deactivate')
	{
		$sql="update tbl_user set status=0 where id in ($str_rest_refs)"; 
		executeUpdate($sql);
		$sess_msg="Selected Record(s) Deactivated Successfully";
		$_SESSION['sess_msg']=$sess_msg;
	}
	elseif($Submit=='Pool')
	{
		$sql="update tbl_user set pool=1 where id in ($str_rest_refs)";
		executeUpdate($sql);
		$sess_msg="Selected Record(s) Pooled Successfully";
		$_SESSION['sess_msg']=$sess_msg;
	}
	elseif($Submit=='Remove Pool')
	{
		$sql="update tbl_user set pool=0 where id in ($str_rest_refs)"; 
		executeUpdate($sql);
		$sess_msg="Selected Record(s) Removed pool Successfully";
		$_SESSION['sess_msg']=$sess_msg;
	}
	elseif($Submit=='Approve Photo')
	{
		$sql="update tbl_user set photo=1 where id in ($str_rest_refs)"; 
		executeUpdate($sql);
		$sess_msg="Selected Record(s) Removed pool Successfully";
		$_SESSION['sess_msg']=$sess_msg;
	}
	elseif($Submit=='Disapprove Photo')
	{
		$sql="update tbl_user set photo=0 where id in ($str_rest_refs)"; 
		executeUpdate($sql);
		$sess_msg="Selected Record(s) Removed pool Successfully";
		$_SESSION['sess_msg']=$sess_msg;
	}
	
}
else{
	$sess_msg="Please select Check Box";
	$_SESSION['sess_msg']=$sess_msg;
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit();
}

header("Location: user_list.php");
exit();
?>