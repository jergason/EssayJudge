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
    $sql="delete from tbl_document where id in ($str_rest_refs)"; 
    executeUpdate($sql);
    $sess_msg="Selected Record(s) Deleted Successfully";
    $_SESSION['sess_msg']=$sess_msg;
  }
  elseif($Submit=='Approve')
  {
    $sql="update tbl_document set status=1 where id in ($str_rest_refs)"; 
    executeUpdate($sql);
    $sess_msg="Selected Record(s) Approved Successfully";
    $_SESSION['sess_msg']=$sess_msg;
  }
  elseif($Submit=='Pending')
  {
    $sql="update tbl_document set status=0 where id in ($str_rest_refs)"; 
    executeUpdate($sql);
    $sess_msg="Selected Record(s) Status Changed To Pending Successfully";
    $_SESSION['sess_msg']=$sess_msg;
  }
  elseif($Submit=='Feature')
  {
    $sql="update tbl_document set feature=1 where id in ($str_rest_refs)"; 
    executeUpdate($sql);
    $sess_msg="Selected Record(s) Status Changed To Pending Successfully";
    $_SESSION['sess_msg']=$sess_msg;
  }
  elseif($Submit=='Remove Feature')
  {
    $sql="update tbl_document set feature=0 where id in ($str_rest_refs)"; 
    executeUpdate($sql);
    $sess_msg="Selected Record(s) Status Changed To Pending Successfully";
    $_SESSION['sess_msg']=$sess_msg;
  }

}
else{
  $sess_msg="Please select Check Box";
  $_SESSION['sess_msg']=$sess_msg;
  header("Location: ".$_SERVER['HTTP_REFERER']);
  exit();
}

header("Location: document_list.php?user_id=".$_GET[user_id]);
exit();
?>
