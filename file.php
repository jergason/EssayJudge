<?
// This is an example of PHP script using DOWNLOADFILE class.
// On any page you need to create a link to this script.
// By pressing on this link you will automatically get a dialog box to download the "filename.ext" file.

include("config/downloadfileclass.inc");

$downloadfile = new DOWNLOADFILE("uploaded_document/".$_GET[doc_path]);
if (!$downloadfile->df_download()) echo "Sorry, we are experiencing technical difficulties downloading this file. Please report this error to Technical Support.";
?>
