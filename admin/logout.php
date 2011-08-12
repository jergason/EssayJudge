<?
session_start();
require_once("../config/config.inc.php");

session_unregister("sess_msg");
session_unregister("sess_uid");
session_unregister("sess_username");

session_destroy();

header("Location: index.php");

?>