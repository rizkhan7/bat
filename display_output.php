<?
if(!isset($app_header_page)) $app_header_page = "header.php";
if(!isset($app_footer_page)) $app_footer_page = "footer.php";
if(!isset($renderfile)){echo "error: output page not defined!"; exit;}

include $app_header_page;
include $renderfile;
include $app_footer_page;
?>