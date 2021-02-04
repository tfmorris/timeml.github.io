<?php require('utils.php');$file = $HTTP_GET_VARS['file'];$login = $HTTP_GET_VARS['login'];function select_first($array) { 	return $array[0]; }function getArticles($login){	global $SENTENCES_TABLE;	global $DOCS_TABLE;	$query = "SELECT file FROM $DOCS_TABLE;";	$rows = dbSelect($query, 'getArticles');	return array_map("select_first",$rows);}function getCounts(){	global $RELTYPES_TABLE;	global $ADJUCATED_RELTYPES_TABLE;	$query = "SELECT file, annotator, count(*) FROM $RELTYPES_TABLE GROUP BY file, annotator;";	$rows = dbSelect($query, 'getCounts');	$counts = Array();	foreach ($rows as $row) {		$file = $row[0];		$annotator = $row[1];		$links = $row[2];		$counts[$file][$annotator] = $links;	}	$query = "SELECT file, count(*) FROM $ADJUCATED_RELTYPES_TABLE GROUP BY file;";	$rows = dbSelect($query, 'getCounts');	foreach ($rows as $row) {		$file = $row[0];		$links = $row[1];		$counts[$file]['adj'] = $links;	}	return $counts;}?><!doctype html public "-//W3C//DTD HTML 4.0 //EN"> <html><head><title>TempEval Annotations</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><link href="../../timebank.css" rel="stylesheet" type="text/css"></head><body><h2>TempEval Annotations</h2><hr><?php	$files = getArticles($login);	$counts = getCounts();	echo "<blockquote>\n";	echo "<table cellpadding=5>\n";	$count = 0;  	foreach ($files as $file) {		$count++;		$allLinks = $counts[$file]['tb'];		$doneLinks = $counts[$file]['adj'];		$done = '';		if ($allLinks == $doneLinks) {			$done = 'done';		}		if (! $doneLinks) {			$doneLinks = 0;		}		$annotators = array_keys($counts[$file]);		$count1 = $counts[$file][$annotators[0]];		$count2 = $counts[$file][$annotators[1]];		$count3 = $counts[$file][$annotators[2]];		if ($count1 == $count2 and $count1 == $count3) {			echo "<tr>\n";			echo "  <td align=right>$count\n";			echo "  <td><a href=adminArticle.php?login=$login&file=$file>$file</a>\n";			echo "  <td>[ ";			foreach ($annotators as $annotator) {				if ($annotator != 'tb' and $annotator != 'adj') { echo "$annotator "; }			}			echo "]\n";			echo "  <td align=right>$allLinks\n";			echo "  <td align=right>$doneLinks\n";			echo "  <td>$done\n";		}	}	echo "</table>\n";	echo "</blockquote>\n";?><hr><table><tr><!--<td>  <form action="index.php" method="get">  <input type="hidden" name="login" value="<?php echo $login; ?>" />  <input type="submit" value="Home" />  </form>--><td>  <form action="adminArticles.php" method="get">  <input type="hidden" name="login" value="<?php echo $login; ?>" />  <input type="submit" value="Document List" />  </form></table></body></html>