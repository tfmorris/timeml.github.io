<?php require('utils.php');$query = "SELECT distinct tmlfile FROM $SENTENCES_TABLE";$result = mysql_query($query, $db_conn);if (mysql_errno()){printMySqlErrors($query,"displayArticles.php:8"); }else {  while ($row = mysql_fetch_row($result)) {	$files[] = $row[0]; }}?><!doctype html public "-//W3C//DTD HTML 4.0 //EN"> <html><head><title><?php echo $TB_VERSION ?> files</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><script language="JavaScript" type="text/JavaScript"><!--function openArticle(doc) {  var newurl = "displayArticle2.php?file=" + doc;  var w = window.open(newurl,"article","width=500,height=600,status=yes,scrollbars=yes,resizable=yes"); }--></script></head><body><?php readfile("topnav.php"); ?><h2><?php echo $TB_VERSION ?> files</h2><ol><?phpforeach ($files as $file){  // use the first to open in current window, use the second to open in another  // window without all tool bars  echo '<li><a href=displayArticle2.php?file='.$file.'>'.$file."</a>\n";  //echo '<li><a href=javascript:openArticle("'.$file.'")>'.$file."</a>\n";}?></ol></body></html>