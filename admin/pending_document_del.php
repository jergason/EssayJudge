<?php
session_start();
require_once("../config/config.inc.php");
require_once("../config/functions.inc.php");
validate_admin();

/*
 * Returns an html escaped string of all
 * document names that will be affected
 * by this form submission
 * $docuement_ids is an array of ids
 */
function get_affected_document_names($document_ids) {
  $ids_string = mysql_real_escape_string(implode(",", $document_ids));
  $sql = sprintf("SELECT doc_title FROM `tbl_document` WHERE id IN (%s)",
    $ids_string);

  $res = mysql_query($sql);
  if ($res) {
    while($arr = mysql_fetch_array($res)) {
      $names[] = $arr['doc_title'];
    }
    return htmlentities(implode(", ", $names));
  }
}

$arr = $_POST['ids'];

if(count($arr)>0){
  $str_rest_refs = mysql_real_escape_string(implode(",",$arr));
  //Get names of documents we are changing so we can put them in the 
  //session messages.
  $affected_document_names = get_affected_document_names($_POST['ids']);

  if($_POST['Delete'])
  {
    $sql= sprintf("delete from tbl_document where id in ('%s')", $str_rest_refs);
    $sess_msg = "Deleted the following documents: " . $affected_document_names;
    executeUpdate($sql);
  }
  elseif($_POST['Approve'])
  {
    $sql="update tbl_document set status=1 where id in ($str_rest_refs)";
    executeUpdate($sql);
    $sess_msg="Approved the following documents: " . $affected_document_names;
  }
  elseif($_POST['Pending'])
  {
    $sql="update tbl_document set status=0 where id in ($str_rest_refs)";
    executeUpdate($sql);
    $sess_msg="Changed the following documents to pending: " . $affected_document_names;
  }
  elseif($_POST['Feature'])
  {
    $sql="update tbl_document set feature=1 where id in ($str_rest_refs)";
    executeUpdate($sql);
    $sess_msg="Featured the following documents: " . $affected_document_names;
  }
  elseif($_POST['Remove Feature'])
  {
    $sql="update tbl_document set feature=0 where id in ($str_rest_refs)";
    executeUpdate($sql);
    $sess_msg="Removed the following documents from being featured: " . $affected_document_names;
  }
  $_SESSION['sess_msg']=$sess_msg;
}
else{
  $sess_msg="Please select a check box.";
  $_SESSION['sess_msg']=$sess_msg;
  header("Location: ".$_SERVER['HTTP_REFERER']);
  exit();
}

header("Location: pending_document_list.php");
exit();
?>
